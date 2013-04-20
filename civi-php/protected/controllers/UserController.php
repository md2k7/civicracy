<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform the actions
				'actions'=>array('index','view','update','admin','settings','delete', 'import', 'resendActivationMail'),
				'users'=>array('admin'),
			),
			array('allow', // allow all authenticated users to change their settings
				'actions'=>array('settings'),
				'users'=>array('@'),
			),
			array('allow', // allow everyone to activate their user and create a new one (with registrationCode)
				'actions'=>array('activate','create','createSuccess'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Activation of user via activation code from e-mail.
	 */
	public function actionActivate($code)
	{
		$user = User::model()->find('activationcode = :activationcode', array(':activationcode'=>$code));
		$valid = ($user !== null && $user->activationcode !== null && $user->activationcode == $code);

		if($valid && isset($_POST['User'])) {
			$user->scenario = 'activate';
			$user->attributes = $_POST['User'];
			$user->active = true;
			$user->activationcode = null;

			if($this->saveUserAndHistory($user)) {
				// log activation event
				$history = new LoginHistory;
				$history->user_id = $user->id;
				$history->action = LoginHistory::ACTION_ACTIVATE;
				$history->save();

				$this->loginActivatedUser($user);
			}

			$user->sanitizePassword(); // don't retransmit even the hashed password to the user
		}

		$this->render('activate',array(
			'user'=>$user,
			'valid'=>$valid,
		));
	}

	private function loginActivatedUser($user)
	{
		$model = new LoginForm;
		$model->username = $user->username;
		$model->password = $_POST['User']['password'];

		$success = ($model->validate() && $model->login());

		if(!$success)
			throw new CHttpException(500, 'Interner Serverfehler bei Aktivierung des Benutzers.');

		$this->redirect(array('settings', 'activationSuccess' => 1));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$isAdmin = (property_exists(Yii::app()->user, 'isAdmin') && Yii::app()->user->isAdmin);
		if($isAdmin)
			$model=new User;
		else
			$model=new User('anonReg');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->active = 0;

			if($this->saveUserAndHistory($model)) {
				$this->sendActivationEmail($model);
				if($isAdmin)
					$this->redirect(array('view','id'=>$model->id));
				else
					$this->redirect(array('createSuccess'));
			}
		}

		$model->sanitizePassword(); // don't retransmit even the hashed password to the user

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Resend activation e-mail. Useful if it hasn't been received for some reason.
	 */
	public function actionResendActivationMail($id)
	{
		$model = $this->loadModel($id);
		$this->sendActivationEmail($model);
	}

	public function actionCreateSuccess()
	{
		$this->render('createSuccess');
	}

	/**
	 * Imports and Creates new User-models.
	 * At current stage: saves the csv file in folder civi-php/csvfiles
	 */
	public function actionImport()
	{
		$model = new CsvFile();
		$form = new CForm('application.views.user.importForm', $model);
		if ($form->submitted('submit') && $form->validate())
		{
			$form->model->csvfile = CUploadedFile::getInstance($form->model, 'csvfile');
			$savepath=Yii::getPathOfAlias('webroot').'/csvfiles/current.csv';
			$model->csvfile->saveAs($savepath);

			try
			{
				$new_users=$model->extractUsers($savepath);
			}
			catch(CException $e)
			{
				$model->addError('csvfile', $e->getMessage());
				$this->render('import', array('form' => $form));
				return;
			}

			$importSuccess = false;
			$transaction = Yii::app()->db->beginTransaction();

			try
			{
				$newU = array();

				Yii::log(CVarDumper::dumpAsString($new_users), 'info', 'UserController');

				// insert users into DB
				foreach($new_users as $key => $value)
				{
					$newU[$key] = new User;
					$newU[$key]->attributes = $value;
					$newU[$key]->active = 0;

					if(!$this->saveUserAndHistory($newU[$key]))
						throw new CException(CVarDumper::dumpAsString($newU[$key]->getErrors()));
				}
				$importSuccess = true;
				$transaction->commit();

				$this->createLogEntry(Log::USER_CONTROLLER, 'Admin completed CSV user import');
			}
			catch(Exception $e)
			{
				if($importSuccess)
				{
					// sending e-mail failed, log this!
					Yii::log($e->getMessage(), 'error', 'UserController');
					$model->addError('csvfile', 'failed to send e-mail: ' . $e->getMessage());
				}
				else
				{
					$transaction->rollBack();
					$model->addError('csvfile', $e->getMessage());
				}
				$importedUsers=$this->getImportedUsers();
				if(isset($importedUsers))
					$this->render('import', array('form' => $form, 'newU'=>$importedUsers));
				else
					$this->render('import', array('form' => $form));
				return;
			}
			$importedUsers=$this->getImportedUsers();
			$this->render('import', array('form' => $form, 'newU'=>$importedUsers));
			return;
		} elseif (isset($_GET['sendemail']))
		{
			if($_GET['sendemail']==true)
			{
				$importedUsers=$this->getImportedUsers();
				$pass = array();
				foreach($importedUsers as $row)
				{
					$this->sendActivationEmail($row);
				}
				$importedUsers=$this->getImportedUsers();
				$this->render('import', array('form' => $form, 'newU'=>$importedUsers));
				unset($_GET);
				return;
			}
		}
		else
			$importedUsers=$this->getImportedUsers();

		if(isset($importedUsers))
				$this->render('import', array('form' => $form, 'newU'=>$importedUsers));
		else
				$this->render('import', array('form' => $form));
		return;
	}

	/**
	 * @return array of imported users which haven't been sent any activation e-mail yet
	 */
	private function getImportedUsers()
	{
		return User::model()->findAll('activationcode IS NULL AND password = :password AND active = :active', array('password'=>'', 'active'=>0));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			// for test environment, make sure no-one changes admin or users 1-4
			$this->restrictUsers($model);

			if($model->reset_password)
				$password = $model->createRandomPassword();
			else
				$model->password = ''; // make sure the admin doesn't play dirty tricks with POST parameters

			if($this->saveUserAndHistory($model)) {
				if($model->reset_password)
					$this->sendPasswordEmail($model, $password, true);
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$model->sanitizePassword(); // don't retransmit even the hashed password to the user

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSettings($activationSuccess=0)
	{
		$message = '';
		$model=$this->loadModel(Yii::app()->user->id);
		$username = $model->username;
		$realname = $model->realname;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->scenario = 'settings';
			$model->attributes=$_POST['User'];
			$model->id = Yii::app()->user->id; // for security, we don't use a hidden field for this
			$model->username = $username;
			$model->realname = $realname;

			// for test environment, make sure no-one changes admin or users 1-4
			$this->restrictUsers($model);

			if($this->saveUserAndHistory($model))
				$message = Yii::t('app', 'user.settings.saved');
		}

		if($activationSuccess === '1')
			$message = Yii::t('app', 'user.activation.success');

		$model->sanitizePassword(); // don't retransmit even the hashed password to the user

		$this->render('settings',array(
			'model'=>$model,
			'message'=>$message,
		));
	}

	private function restrictUsers($model)
	{
		if(!Yii::app()->params['users.testmode'])
			return;

		// for test environment, make sure no-one changes admin or users 1-4
		$restricted = array('admin', 'user1', 'user2', 'user3', 'user4');
		if(in_array($model->username, $restricted))
			throw new CHttpException(403, 'Bitte vorhandene Test-Benutzer nicht ändern! Bitte einen neuen Benutzer anlegen, um die Benutzerverwaltung zu testen.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
			// for test environment, make sure no-one changes admin or users 1-4
			$this->restrictUsers($this->loadModel($id));

			$transaction = Yii::app()->db->beginTransaction();

			try {
				$user = $this->loadModel($id);

				// mark user as deleted
				$user->active = 0;
				if(!$this->saveUserAndHistory($user))
					throw new CException(CVarDumper::dumpAsString($user->getErrors()));

				// remove all votes of/for this user
				Vote::model()->removeUserVotes($user->id);

				$transaction->commit();
			} catch(Exception $e) {
				$transaction->rollBack();
				$e->getMessage();
				Yii::log($e->getMessage(), 'error', 'UserController');
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, Yii::t('app', 'http.400'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('app', 'http.404'));
		return $model;
	}

	/**
	 * Save a User model while keeping history in UserHistory.
	 */
	private function saveUserAndHistory($model)
	{
		$historyModel = new UserHistory;
		$historyModel->attributes = $model->attributes;
		$historyModel->setReferenceModel($model);

		// copy safe attributes separately
		$historyModel->active = $model->active;

		return $this->saveModelAndHistory($model, $historyModel, 'user_id');
	}

	/**
	 * Send out an activation e-mail with a link to create a user.
	 */
	private function sendActivationEmail($user)
	{
		$code = $user->createActivationCode();

		if(!$this->saveUserAndHistory($user))
			throw new CException(CVarDumper::dumpAsString($user->getErrors()));

		$subject = Yii::t('app', 'activation.subject');

		if(Yii::app()->params['users.logpassword']) {
			// log activation code for testing, instead of sending e-mail
			Yii::log('user: ' . $user->username . ', activation code: ' . $code, 'info', 'UserController');
		} else {
			$body = $this->renderPartial('activationMail', array(
				'model' => $user,
				'url' => $this->createAbsoluteUrl('/user/activate', array('code' => $code)),
			), true);

			require_once(Yii::getPathOfAlias('webroot') . '/phpmailer/class.phpmailer.php');
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->CharSet = 'utf-8';
			$mail->SetFrom(Yii::app()->params['registration.adminEmail'], Yii::app()->params['registration.adminEmailName']);
			$mail->AddAddress($user->email, $user->realname);
			$mail->Subject = $subject;
			$mail->Body = $body;

			if($mail->Send())
				$this->createLogEntry(Log::USER_CONTROLLER, 'Admin sent password email to ' . $user->username);
			else
				Yii::log('mail send failed to ' . $user->realname . ' <' . $user->email . '>: ' . $mail->ErrorInfo, 'error', 'UserController');
		}
	}

	/**
	 * Send out a registration e-mail with the password.
	 */
	private function sendPasswordEmail($user, $password, $passwordReset=false)
	{
		$subjectMessageKey = $passwordReset ? 'passwordReset.subject' : 'registration.subject';
		$subject = Yii::t('app', $subjectMessageKey);

		if(Yii::app()->params['users.logpassword']) {
			// log password for testing, instead of sending e-mail
			Yii::log('user: ' . $user->username . ', password: ' . $password, 'info', 'UserController');
		} else {
			$body = $this->renderPartial('registrationMail', array(
				'model' => $user,
				'password' => $password,
			), true);

			require_once(Yii::getPathOfAlias('webroot') . '/phpmailer/class.phpmailer.php');
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->CharSet = 'utf-8';
			$mail->SetFrom(Yii::app()->params['registration.adminEmail'], Yii::app()->params['registration.adminEmailName']);
			$mail->AddAddress($user->email, $user->realname);
			$mail->Subject = $subject;
			$mail->Body = $body;

			if($mail->Send())
				$this->createLogEntry(Log::USER_CONTROLLER, 'Admin sent password email to ' . $user->username);
			else
				Yii::log('mail send failed to ' . $user->realname . ' <' . $user->email . '>: ' . $mail->ErrorInfo, 'error', 'UserController');
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
