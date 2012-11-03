<?php

/**
 * This is the model class for table "tbl_vote".
 *
 * The followings are the available columns in table 'tbl_vote':
 * @property integer $category_id
 * @property integer $voter_id
 * @property integer $candidate_id
 * @property string $reason
 * @property timestamp $timestamp
 */
class Vote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_vote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, candidate_id, reason', 'required'),
			array('category_id, candidate_id', 'numerical', 'integerOnly'=>true),
			array('category_id', 'isValidCategory'),
			array('candidate_id', 'isValidCandidate'),
			array('timestamp', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'insert, update'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
			'voter'=>array(self::BELONGS_TO, 'User', 'voter_id'),
			'candidate'=>array(self::BELONGS_TO, 'User', 'candidate_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reason' => Yii::t('app', 'models.vote.reason'),
			'candidate_id' => Yii::t('app', 'models.vote.candidate'),
		);
	}

	/*
	 * @param string $attribute the name of the attribute to be validated
	 * @param array $params options specified in the validation rule
	 */
	public function isValidCategory($attribute, $params)
	{
		if(Category::model()->findByPk($this->category_id) === null)
			$this->addError($attribute, Yii::t('app', 'models.vote.categoryIncorrect'));
	}

	/*
	 * Set the candidate_id from a realname of a user
	 */
	public function setCandidate($candidateName)
	{
		$candidate = User::model()->find('realname=:realname', array(':realname' => $candidateName));
		$this->candidate_id = ($candidate !== null) ? $candidate->id : -1;
	}

	/*
	 * @param string $attribute the name of the attribute to be validated
	 * @param array $params options specified in the validation rule
	 */
	public function isValidCandidate($attribute, $params)
	{
		$chainLink = ' -&gt; ';

		$candidate = User::model()->findByPk($this->candidate_id);
		if($candidate === null)
		{
			$this->addError($attribute, Yii::t('app', 'models.vote.candidateIncorrect'));
		}
	}

	/**
	 * Recursively load the vote path for a given category ID.
	 * @param integer $categoryId
	 * @param integer $startUserId if given, start at this user, instead of generating the path for the current user
	 * @return array vote path
	 */
	public function loadVotePath($categoryId, $startUserId=null)
	{
		$path = array();
		$voterId = $startUserId !== null ? $startUserId : Yii::app()->user->id;
		$run = true;
		$voters = array(Yii::app()->user->id); // cycle prevention in software (prevents hangups if the DB contains cycles)

		// add ourselves to vote path
		$vote = Vote::model()->with('candidate')->find('voter_id=:voter_id AND category_id=:category_id', array(':voter_id' => $voterId, ':category_id' => $categoryId));
		$myself = new VotePath;
		$myself->candidate_id = $voterId;
		$myself->reason = ($vote !== null) ? $vote->reason : '';
		$myself->realname = Yii::app()->user->realname;
		$myself->slogan = User::model()->findByPk(Yii::app()->user->id)->slogan;
		$path[] = $myself;

		while($run)
		{
			// we could use a prepared statement here to improve performance
			$vote = Vote::model()->with('candidate')->find('voter_id=:voter_id AND category_id=:category_id', array(':voter_id' => $voterId, ':category_id' => $categoryId));
			if($vote !== null && $voterId != $vote->candidate_id && !in_array($vote->candidate_id, $voters))
			{
				$voterId = $vote->candidate_id;
				$entry = new VotePath;
				$entry->candidate_id = $vote->candidate_id;
				$otherVote = $vote->candidate->loadVoteByCategoryId($categoryId);
				$entry->reason = ($otherVote !== null) ? $otherVote->reason : '';
				$entry->realname = $vote->candidate->realname;
				$entry->slogan = $vote->candidate->slogan;
				$path[] = $entry;
				$voters[] = $voterId;
			}
			else
			{
				$run = false;
			}
		}

		return $path;
	}

	/**
	 * Log and actually remove votes of/for the specified user. Use only in a try/catch block in a transactional context!
	 */
	public function removeUserVotes($userId)
	{
		// log removal of all votes of/for this user
		$votes = Vote::model()->findAll('voter_id = :user_id OR candidate_id = :user_id', array('user_id' => $userId));
		foreach($votes as $vote) {
			$voteHistory = new VoteHistory;
			$voteHistory->attributes = $vote->attributes;
			$voteHistory->voter_id = $vote->voter_id;
			$voteHistory->id = null;
			$voteHistory->active = 0;
			if(!$voteHistory->save())
				throw new Exception('logging of removal of votes of/for user ' . $userId . ' failed');
		}

		// remove all votes of or for this user
		if(!Vote::model()->deleteAll('voter_id = :user_id OR candidate_id = :user_id', array('user_id' => $userId)))
			throw new Exception('removal of votes of/for user ' . $userId . ' failed');
	}

	/**
	 * Calculate and return t_sustain, the min. time in seconds between cast votes for a given user and category.
	 * Users with more responsibility (votes) have a longer t_sustain and can change their minds less often.
	 */
	public function calculateSustainTime($userId, $categoryId)
	{
		$user = User::model()->findByPk($userId);
		$R = $user->getVoteCountInCategory($categoryId)->voteCount;

		$params = CiviGlobals::getSustainTimeParameters();
		$R_max = $params['R_max'];
		$T_max = $params['T_max'];

		$t_sustain = ($R / $R_max) * $T_max + 1;

		return $t_sustain;
	}
}
