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
				'actions'=>array('index','view','create','update','admin','settings','delete'),
				'users'=>array('admin'),
			),
			array('allow', // allow all authenticated users to change their settings
				'actions'=>array('settings'),
				'users'=>array('@'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$password = $model->createRandomPassword();

			if($model->save()) {
				$this->sendPasswordEmail($model, $password);
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$model->sanitizePassword(); // don't retransmit even the hashed password to the user

		$this->render('create',array(
			'model'=>$model,
		));
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

			if($model->save()) {
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
	public function actionSettings()
	{
		$message = '';
		$model=$this->loadModel(Yii::app()->user->id);
		$username = $model->username;
		$realname = $model->realname;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->id = Yii::app()->user->id; // for security, we don't use a hidden field for this
			$model->username = $username;
			$model->realname = $realname;

			// for test environment, make sure no-one changes admin or users 1-4
			$this->restrictUsers($model);

			if($model->save())
				$message = Yii::t('app', 'user.settings.saved');
		}

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
		if(Yii::app()->request->isPostRequest)
		{
			// for test environment, make sure no-one changes admin or users 1-4
			$this->restrictUsers($this->loadModel($id));

			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

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
	 * Send out a registration e-mail with the password.
	 */
	private function sendPasswordEmail($user, $password, $passwordReset=false)
	{
		$subjectMessageKey = $passwordReset ? 'passwordReset.subject' : 'registration.subject';
		$subject = '=?UTF-8?B?'.base64_encode(Yii::t('app', $subjectMessageKey)).'?=';

		$headers = 'From: ' . Yii::app()->params['registration.adminEmail'] . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";

		mail($user->email, $subject, $this->renderPartial('registrationMail', array(
			'model' => $user,
			'password' => $password,
		), true), $headers);
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
