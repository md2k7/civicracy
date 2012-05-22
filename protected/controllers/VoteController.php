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

	/**
	 * Delete the vote in a category.
	 * @param integer category ID
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$vote = $this->loadVoteByCategoryId($id);
			if($vote === null)
				throw new CHttpException(404,'The requested page does not exist.');
			$vote->delete();

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
		$model = $this->loadVoteByCategoryId($id);
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
			if($model->save())
				$this->redirect(array('view','id'=>$id));
		}

		$this->render('update', array(
			'model' => $model,
			'categoryModel' => $categoryModel,
		));
	}

	/**
	 * View the vote history for a given category.
	 * @param integer category ID
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'voteHistory' => $this->loadVoteHistory($id),
			'category' => Category::model()->findByPk($id)->name,
			'reason' => $this->loadVoteByCategoryId($id)->reason,
			'id' => $id,
		));
	}

	/**
	 * Recursively load the vote history for a given category ID.
	 */
	private function loadVoteHistory($categoryId)
	{
		$history = array();
		$voterId = Yii::app()->user->id;
		$run = true;

		while($run)
		{
			// we could use a prepared statement here to improve performance
			$vote = Vote::model()->with('candidate')->find('voter_id=:voter_id AND category_id=:category_id', array(':voter_id' => $voterId, ':category_id' => $categoryId));
			if($vote !== NULL && $voterId != $vote->candidate_id)
			{
				$voterId = $vote->candidate_id;
				$entry = new VoteHistory;
				$entry->realname = $vote->candidate->realname;
				$history[] = $entry;
			}
			else
			{
				$run = false;
			}
		}

		return new CArrayDataProvider($history, array(
			'id' => 'vote_history',
			'keyField' => 'realname',
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer category ID
	 */
	private function loadVoteByCategoryId($categoryId)
	{
		$model=Category::model()->with('votes')->find('voter_id=:voter_id AND category_id=:category_id', array(
			':voter_id' => Yii::app()->user->id,
			':category_id' => $categoryId,
		));
		if($model === null || $model->votes === null || count($model->votes) != 1)
			return null;
		return $model->votes[0];
	}
}
