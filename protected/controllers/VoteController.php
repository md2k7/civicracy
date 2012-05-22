<?php

class VoteController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('deny', // deny admin user all actions (admin doesn't vote)
				'users'=>array('admin'),
			),
			array('allow', // allow authenticated users (except admin, see above) all actions
				'users'=>array('@'),
			),
			array('deny',  // for completeness, deny all users all actions
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		// get vote counts for us
		$ownWeight = new CActiveDataProvider('Category', array(
			'criteria' => array(
				'with' => array(
					'voteCount' => array(
						'condition' => 'candidate_id=' . Yii::app()->user->id,
					)
				),
			),
		));

		// get categories where we've voted
		$votedFor = new CActiveDataProvider('Category', array(
			'criteria' => array(
				'with' => array(
					'votes' => array(
						'condition' => 'voter_id=' . Yii::app()->user->id,
					)
				),
				'together' => true,
			),
		));

		// get categories where we haven't voted yet
		$freeVote = new CActiveDataProvider('Category', array(
			'criteria' => array(
				'condition' => 'NOT EXISTS (SELECT 1 FROM tbl_vote WHERE voter_id='.Yii::app()->user->id.' AND category_id=t.id)',
			),
		));

		$this->render('index', array(
			'ownWeight' => $ownWeight,
			'votedFor' => $votedFor,
			'freeVote' => $freeVote,
		));
	}

	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionDelete($categoryId)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadVoteByCategoryId($categoryId)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		$this->render('delete');
	}

	public function actionUpdate()
	{
		$this->render('update');
	}

	public function actionView()
	{
		$this->render('view');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadVoteByCategoryId($categoryId)
	{
		$model=Category::model()->findByPk($categoryId)->getCandidate();
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
