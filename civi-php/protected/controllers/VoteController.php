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
	public function actionDelegate($id, $remove=0)
	{
		if(!$this->mayVote($id))
			throw new CHttpException(403, Yii::t('app', 'http.403'));

		// fetch model and update it from POST data
		$model = $this->loadVote($id);

		// form data comes via POST
		if(isset($_POST['Vote']) && $model->validate()) {
			$this->actionConfirm($id); // render confirm view for vote
			return;
		}

		$this->render('delegate', array(
			'id' => $id,
			'model' => $model,
			'category' => Category::model()->findByPk($id),
			'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
			'candidates' => $this->loadCandidates($id),
		));
	}

	/**
	 * Confirm vote revocation.
	 * @param integer $id category ID
	 */
	public function actionRevoke($id)
	{
		$this->actionConfirm($id, 'revoke');
	}

	/**
	 * Confirm vote self-reference.
	 * @param integer $id category ID
	 */
	public function actionReference($id)
	{
		$this->actionConfirm($id, 'reference');
	}

	/**
	 * Confirm vote delegation.
	 *
	 * @param integer $id category ID
	 * @param $type optional type for loadVote(), delegate|revoke|reference
	 */
	public function actionConfirm($id, $type='delegate')
	{
		if(!$this->mayVote($id))
			throw new CHttpException(403, Yii::t('app', 'http.403'));

		// fetch model and update it from POST data
		$model = $this->loadVote($id, $type);

		$category = Category::model()->findByPk($id);
		$board = $category->viewboard ? User::model()->getVoteCountInCategoryTotal($id) : false;

		$authOk = true;
		if(isset($_POST['confirm'])) {
			// vote confirmed, now check password
			$identity = new UserIdentity(Yii::app()->user->name, $_POST['VoteConfirm']['password']);
			if($identity->authenticate()) {
				// vote confirmed
				if($this->saveVoteAndHistory($model))
					$this->redirect(array('view','id'=>$id)); // doesn't return
			} else {
				$authOk = false;
			}
		}

		$confirmModel = new VoteConfirm;
		$confirmModel->attributes = $model->attributes;
		if(!$authOk)
			$confirmModel->addError('password', Yii::t('app', 'login.password.incorrect'));

		// not confirmed, not canceled: just sent vote, display confirmation page ("are you sure"?)
		$this->render('confirm', array(
			'model' => $confirmModel,
			'votePath' => Vote::model()->previewVotePath($model),
			'category' => $category,
			'candidate' => ($model->candidate_id !== null ? User::model()->findByPk($model->candidate_id)->realname : ''),
			'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
			'type' => $type,
			'nextVoteTime' => $this->nextVoteTime($id, true), // vote time estimate
			'id' => $id,
			'leaveBoard' => $this->onBoard(Yii::app()->user->id, $board),
		));
	}

	public function actionUpdate($id) {
		$this->render('update', array(
			'id' => $id,
			'category' => Category::model()->findByPk($id),
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

		$category = Category::model()->findByPk($id);
		$board = $category->viewboard ? User::model()->getVoteCountInCategoryTotal($id) : false;

		$voterStatus = 'unknown';
		if($vote !== null) {
			if($vote->candidate_id == null) {
				// there is no candidate: revoked
				$voterStatus = 'revoke';
			} else if($vote->candidate_id != Yii::app()->user->id) {
				// there is a candidate, and candidate_id is not self: delegation
				$voterStatus = 'delegate';
			} else if($vote->candidate_id == Yii::app()->user->id) {
				// candidate is self: self-referenced vote for getting on board
				if($board !== false && $this->onBoard(Yii::app()->user->id, $board)) // don't display 'on board' for user if viewboard is turned off
					$voterStatus = 'board';
				else
					$voterStatus = 'reference';
			}
		} else {
			// no vote yet
			$voterStatus = 'revoke';
		}

		$this->render('view', array(
			'votePath' => Vote::model()->loadVotePath($id),
			'category' => $category,
			'weight' => User::model()->findByPk(Yii::app()->user->id)->getVoteCountInCategory($id)->voteCount,
			'reason' => $reason,
			'voted' => ($vote !== null),
			'id' => $id,

			'ranking' => $board,
			'votedTime' => $votedTime,
			'nextVoteTime' => $this->nextVoteTime($id),
			'mayVote' => $this->mayVote($id),
			'voterStatus' => $voterStatus,
		));
	}

	private function onBoard($userId, $board)
	{
		for($i = 0; $i < count($board); $i++)
			if($board[$i]['id'] == $userId)
				return true;
		return false;
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
	 * Load a Vote model: Either load it for the given category, or create one from scratch if there is none yet.
	 * Update its attributes from POST data.
	 *
	 * @param $id category ID
	 * @param $type optional, delegate|revoke|reference
	 */
	private function loadVote($id, $type='delegate')
	{
		$model = User::model()->findByPk(Yii::app()->user->id)->loadVoteByCategoryId($id);

		if($model === null) {
			$model = new Vote;
			$model->category_id = $id;
		}
		if($type == 'delegate')
			$model->setScenario('delegate');

		// we might get POST data of Vote when called from actionDelegate()
		if(isset($_POST['VoteConfirm']))
			$_POST['Vote'] = $_POST['VoteConfirm'];

		// update comes via POST
		if(isset($_POST['Vote'])) {
			$model->attributes=$_POST['Vote'];
			$model->setCandidate($_POST['candidate']);
		} else if($type == 'revoke') {
			// user abstains from voting
			$model->candidate_id = null;
			$model->reason = '';
		} else if($type == 'reference') {
			// user wants to be a candidate for the board
			$model->candidate_id = Yii::app()->user->id;
			$model->reason = '';
		}

		$model->voter_id = Yii::app()->user->id; // for security, we don't use a hidden field for this

		return $model;
	}

	/**
	 * @return array of candidate names
	 */
	private function loadCandidates($categoryId)
	{
		$candidates = User::model()->getVotersInCategory($categoryId, 'id != :currentId', array('currentId' => Yii::app()->user->id));
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

		// handle abstained vote (candidate null) as deleted vote
		if($vote !== null && $vote->candidate_id == null)
			$vote = null;

		return $vote;
	}
}
