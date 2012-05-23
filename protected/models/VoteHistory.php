<?php

/**
 * Simple model class for single-column "voter" history.
 */
class VoteHistory extends CModel
{
	public $realname;
	public $reason;
	public $candidate_id; // only used via PHP at the moment

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realname' => User::model()->getAttributeLabel('realname'),
			'reason' => Vote::model()->getAttributeLabel('reason'),
		);
	}

	public function attributeNames()
	{
		return array('realname', 'reason');
	}
}
