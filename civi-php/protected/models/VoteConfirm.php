<?php

/**
 * This is the model class for table "tbl_vote" with an additional password field.
 *
 * The followings are the available columns in table 'tbl_vote':
 * @property integer   $id
 * @property timestamp $timestamp
 * @property integer   $category_id
 * @property integer   $voter_id
 * @property integer   $candidate_id
 * @property string    $reason
 *
 * @property string    $password  additional password attribute
 */
class VoteConfirm extends Vote
{
	public $password;

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return CMap::mergeArray(Vote::attributeLabels(), array(
			'password' => Yii::t('app', 'models.password'),
		));
	}
}
