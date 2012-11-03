<?php

/**
 * This is the model class for table "tbl_vote_history".
 *
 * The followings are the available columns in table 'tbl_vote_history':
 * @property integer   $id
 * @property timestamp $timestamp
 * @property integer   $category_id
 * @property integer   $voter_id
 * @property integer   $candidate_id
 * @property string    $reason
 * @property timestamp $timestamp
 */
class VoteHistory extends Vote
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_vote_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			array('timestamp', 'safe'),
		));
	}
}
