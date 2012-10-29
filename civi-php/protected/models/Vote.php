<?php

/**
 * This is the model class for table "tbl_vote".
 *
 * The followings are the available columns in table 'tbl_vote':
 * @property integer $category_id
 * @property integer $voter_id
 * @property integer $candidate_id
 * @property string $reason
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
		$myself->reason = $vote->reason;
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
}
