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
		// get vote counts 
		$ownWeight = Category::model()->with('voteCount', 'votes')->find('candidate_id=:candidate_id', array(':candidate_id' => Yii::app()->user->id));

		$this->render('index', array(
			'ownWeight' => $ownWeight,
		));
	}

	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionDelete()
	{
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
} 
