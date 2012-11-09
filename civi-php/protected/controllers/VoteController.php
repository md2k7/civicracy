<?php

class VoteController extends Controller
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
		// temp: for now, redirect directly to the single active election (currently called category)
		$categoryId = Category::model()->find('active = :active', array('active' => 1))->id;
		$this->redirect($this->createUrl('/vote/view', array('id'=>$categoryId)));

		// get vote counts for us
		$ownWeight = User::model()->findByPk(Yii::app()->user->id)->getVoteCount();

		// get categories where we've voted
		$votedFor = new CActiveDataProvider('Category', array(
			'criteria' => array(
				'with' => array(
					'votes' => array(
						'condition' => 'voter_id=:userId',
						'params' => array('userId' => Yii::app()->user->id),
					)
				),
				'together' => true,
			),
		));

		// get categories where we haven't voted yet
		$freeVote = new CActiveDataProvider('Category', array(
			'criteria' => array(
				'condition' => 'NOT EXISTS (SELECT 1 FROM tbl_vote WHERE voter_id=:userId AND category_id=t.id)',
				'params' => array('userId' => Yii::app()->user->id),
			),
		));

		$this->render('index', array(
			'ownWeight' => $ownWeight,
			'votedFor' => $votedFor,
			'freeVote' => $freeVote,
		));
	}

	/**
	 * Delete the vote in a category.
	 * @param integer category ID
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$vote = User::model()->findByPk(Yii::app()->user->id)->loadVoteByCategoryId($id);
			if($vote === null)
				throw new CHttpException(404, Yii::t('app', 'http.404'));
			$vote->delete();
			// TODO: use VoteHistory

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	/**
	 * Enter vote for a given category.
	 * @param integer category ID
	 */
	public function actionUpdate($id)
	{
		$model = User::model()->findByPk(Yii::app()->user->id)->loadVoteByCategoryId($id);
		if($model === null)
		{
			$model = new Vote;
			$model->category_id = $id;
		}
		$categoryModel = Category::model()->findByPk($id);

		if(isset($_POST['Vote']))
		{
			$model->attributes=$_POST['Vote'];
			$model->voter_id = Yii::app()->user->id; // for security, we don't use a hidden field for this
			$model->setCandidate($_POST['candidate']);
			if($model->validate())
			{
				$transaction = Yii::app()->db->beginTransaction();
				if($model->save()) {
					$historyModel = new VoteHistory;
					$historyModel->attributes = $model->attributes;
					$historyModel->voter_id = $model->voter_id; // set safe attribute separately
					$historyModel->id = null;
					$historyModel->timestamp = null;
					if($historyModel->save()) {
						$transaction->commit();
						$this->redirect(array('view','id'=>$id)); // doesn't return
					} else {
						$transaction->rollBack();
					}
				} else {
					$transaction->rollBack();
				}
			}
		}

		$this->render('update', array(
			'model' => $model,
			'category' => Category::model()->findByPk($id),
			'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
			'candidates' => $this->loadCandidates(),
		));
	}

	/**
	 * @return array of candidate names
	 */
	private function loadCandidates()
	{
		$candidates = User::model()->findAll("username != :adminUser AND active = :active", array('adminUser' => 'admin', 'active' => 1));
		$nameList = array();
		$slogans = array();
		foreach($candidates as $c) {
			$nameList[] = $c->realname;
			$slogans[$c->realname] = $c->slogan;
		}
		return array('names' => $nameList, 'slogans' => $slogans);
	}

	/**
	 * View the vote path for a given category.
	 * @param integer category ID
	 */
	public function actionView($id)
	{
		$vote = User::model()->findByPk(Yii::app()->user->id)->loadVoteByCategoryId($id);
		$reason = ($vote !== null) ? $vote->reason : '';

		$votedTime = ($vote !== null ? strtotime($vote->timestamp) : 0);
		$nextVoteTime = ($vote !== null ? ($votedTime + Vote::model()->calculateSustainTime(Yii::app()->user->id, $id)) : 0);

		$this->render('view', array(
			'votePath' => Vote::model()->loadVotePath($id),
			'category' => Category::model()->findByPk($id),
			'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
			'reason' => $reason,
			'voted' => ($vote !== null),
			'id' => $id,

			// for testing
			'ranking' => User::model()->getVoteCountInCategoryTotal($id),
			'votedTime' => $votedTime,
			'nextVoteTime' => $nextVoteTime,
			'deltaT' => ($vote !== null ? Vote::model()->calculateSustainTime(Yii::app()->user->id, $id) : 0),
			/*'numberofcandidates' => 3,
			'names' => array("hans", "georg", "franz"),
			'weightAbs' => array(5, 10, 5),
			'weightPer' => array(25, 50, 25),*/				
				));
	}
}
