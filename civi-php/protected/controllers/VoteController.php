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
		$this->redirect($this->createUrl('/vote/view', array('id'=>$categoryId))); // doesn't return

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
	 * Enter vote for a given category.
	 *
	 * @param integer $id category ID
	 * @param integer $remove whether remove action is active
	 */
	public function actionUpdate($id, $remove=0)
	{
		if(!$this->mayVote($id))
			throw new CHttpException(403, Yii::t('app', 'http.403'));

		$model = User::model()->findByPk(Yii::app()->user->id)->loadVoteByCategoryId($id);

		if($model === null) {
			$model = new Vote;
			$model->category_id = $id;
		}
		$categoryModel = Category::model()->findByPk($id);
		$failedValidation = false;

		if(isset($_POST['Vote']) || $remove === '1') {
			if($remove === '1') {
				// remove comes via GET
				$model->setScenario('delete');
				$model->candidate_id = Yii::app()->user->id; // vote removal = vote for self
				$model->reason = '';
			} else {
				// update comes via POST
				$model->attributes=$_POST['Vote'];
				$failedValidation = !$model->setCandidate($_POST['candidate']);
			}

			$model->voter_id = Yii::app()->user->id; // for security, we don't use a hidden field for this

			if(isset($_POST['confirm'])) {
				// vote confirmed
				if(!$this->saveVoteAndHistory($model))
					$failedValidation = true;
			} else if(!isset($_POST['cancel']) && !$failedValidation) {
				// isset($_POST['cancel']) would mean: canceled voting from confirmation page

				// not confirmed, not canceled: just sent vote, display confirmation page ("are you sure"?)
				$this->render('confirm', array(
					'model' => $model,
					'votePath' => Vote::model()->previewVotePath($model),
					'category' => Category::model()->findByPk($id),
					'candidate' => User::model()->findByPk($model->candidate_id)->realname,
					'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
					'revoke' => ($model->candidate_id == Yii::app()->user->id),
					'nextVoteTime' => $this->nextVoteTime($id, true), // vote time estimate
					'id' => $id,
				));
				return;
			}
			if(!$failedValidation)
				$this->redirect(array('view','id'=>$id)); // doesn't return
		}

		$this->render('update', array(
			'id' => $id,
			'model' => $model,
			'category' => Category::model()->findByPk($id),
			'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
			'candidates' => $this->loadCandidates(),
		));
	}

	/**
	 * View the vote path for a given category.
	 * @param integer category ID
	 */
	public function actionView($id)
	{
		$vote = $this->loadVoteByCategoryId($id);
		$reason = ($vote !== null) ? $vote->reason : '';

		$votedTime = ($vote !== null ? strtotime($vote->timestamp) : 0);

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
			'nextVoteTime' => $this->nextVoteTime($id),
			'mayVote' => $this->mayVote($id),
			/*'numberofcandidates' => 3,
			'names' => array("hans", "georg", "franz"),
			'weightAbs' => array(5, 10, 5),
			'weightPer' => array(25, 50, 25),*/				
				));
	}

	/**
	 * Save a Vote model while keeping history in VoteHistory.
	 */
	private function saveVoteAndHistory($model, $active=1)
	{
		$historyModel = new VoteHistory;
		$historyModel->setScenario($model->scenario);
		$historyModel->attributes = $model->attributes;

		// copy safe attributes separately
		$historyModel->voter_id = $model->voter_id;
		$historyModel->id = null;
		$historyModel->timestamp = null; // will get default CURRENT_TIMESTAMP from DB
		$historyModel->active = $active;

		// use a transaction: maybe we will delete the model
		$transaction = Yii::app()->db->beginTransaction();
		if($this->saveModelAndHistory($model, $historyModel)) {
			if($active === 0) {
				if($model->delete()) {
					// to delete, and succeeded -> all is well
					$transaction->commit();
					return true;
				}
			} else {
				// not to delete -> all is well
				$transaction->commit();
				return true;
			}
		}
		// save or delete failed -> roll back
		$transaction->rollBack();
		return false;
	}

	/**
	 * @return array of candidate names
	 */
	private function loadCandidates()
	{
		$candidates = User::model()->findAll("username != :adminUser AND active = :active AND id != :currentId", array('adminUser' => 'admin', 'active' => 1, 'currentId' => Yii::app()->user->id));
		$nameList = array();
		$slogans = array();
		foreach($candidates as $c) {
			$nameList[] = $c->realname;
			$slogans[$c->realname] = $c->slogan;
		}
		return array('names' => $nameList, 'slogans' => $slogans);
	}

	/**
	 * @return whether the current user is allowed to vote 
	 */
	private function mayVote($categoryId)
	{
		return (time() > $this->nextVoteTime($categoryId));
	}

	/**
	 * @return approximate time the next vote change will be allowed
	 */
	private function nextVoteTime($categoryId, $estimate=false)
	{
		$vote = $this->loadVoteByCategoryId($categoryId);

		$votedTime = ($vote !== null ? strtotime($vote->timestamp) : 0);
		if($estimate)
			$votedTime = time();
		$nextVoteTime = (($vote !== null || $estimate) ? ($votedTime + Vote::model()->calculateSustainTime(Yii::app()->user->id, $categoryId)) : 0);
		return $nextVoteTime;
	}

	/**
	 * Load vote by categoryId, like the User model function, but return null if vote for self (deleted vote)
	 */
	private function loadVoteByCategoryId($categoryId)
	{
		$vote = User::model()->findByPk(Yii::app()->user->id)->loadVoteByCategoryId($categoryId);

		// handle vote for self as deleted vote
		if($vote->candidate_id == Yii::app()->user->id)
			$vote = null;

		return $vote;
	}
}
