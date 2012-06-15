<?php

/**
 * Simple model class for the personal vote count (weight) per category
 */
class VoteCount extends CModel
{
	public $categoryName;
	public $voteCount;

	public static function model()
	{
		return new VoteCount;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'categoryName' => Yii::t('app', 'models.category'),
			'voteCount' => Yii::t('app', 'models.voteCount'),
		);
	}

	public function attributeNames()
	{
		return array('categoryName', 'voteCount');
	}
}
