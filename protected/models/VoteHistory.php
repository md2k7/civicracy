<?php

/**
 * Simple model class for single-column "voter" history.
 */
class VoteHistory extends CModel
{
	public $realname;
	public $candidate_id; // only used via PHP at the moment

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array('realname' => User::model()->getAttributeLabel('realname'));
	}

	public function attributeNames()
	{
		return array('realname');
	}
}
