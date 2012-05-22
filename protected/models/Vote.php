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
			'category_id' => 'Category',
			'voter_id' => 'Voter',
			'candidate_id' => 'Candidate',
			'reason' => 'Reason',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('voter_id',$this->voter_id);
		$criteria->compare('candidate_id',$this->candidate_id);
		$criteria->compare('reason',$this->reason,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
	 * @param string $attribute the name of the attribute to be validated
	 * @param array $params options specified in the validation rule
	 */
	public function isValidCategory($attribute, $params)
	{
		if(Category::model()->findByPk($this->category_id) === null)
			$this->addError($attribute, 'Incorrect category.');
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
			$this->addError($attribute, 'Incorrect candidate.');
		}
		else
		{
			// cycle detection (note: this may be a race condition - we should obtain a DB lock before checking for loops, and release it after saving the vote)
			$history = $this->loadVoteHistory($this->category_id, $this->candidate_id)->rawData;
			$chain = $candidate->realname . $chainLink;
			foreach($history as $entry)
			{
				if($entry->candidate_id == Yii::app()->user->id)
				{
					$this->addError($attribute, 'Cycle found in the chain of votes: ' . $chain . Yii::app()->user->realName . '. Please meet and discuss.');
					break;
				}
				$chain .= $entry->realname . $chainLink;
			}
		}
	}

	/**
	 * Recursively load the vote history for a given category ID.
	 * @param integer $categoryId
	 * @param integer $startUserId if given, start at this user, instead of generating the history for the current user
	 * @return CArrayDataProvider providing the vote history
	 */
	public function loadVoteHistory($categoryId, $startUserId=null)
	{
		$history = array();
		$voterId = $startUserId !== null ? $startUserId : Yii::app()->user->id;
		$run = true;
		$voters = array(); // cycle prevention in software (this prevents hangups if the DB is already broken)

		while($run)
		{
			// we could use a prepared statement here to improve performance
			$vote = Vote::model()->with('candidate')->find('voter_id=:voter_id AND category_id=:category_id', array(':voter_id' => $voterId, ':category_id' => $categoryId));
			if($vote !== null && $voterId != $vote->candidate_id && !in_array($vote->candidate_id, $voters))
			{
				$voterId = $vote->candidate_id;
				$entry = new VoteHistory;
				$entry->candidate_id = $vote->candidate_id;
				$entry->realname = $vote->candidate->realname;
				$history[] = $entry;
				$voters[] = $voterId;
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
}
