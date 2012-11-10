<?php

/**
 * This is the model class for table "tbl_log".
 *
 * The followings are the available columns in table 'tbl_log':
 * @property integer   $id
 * @property timestamp $timestamp
 * @property string    $category
 * @property string    $log
 */
class Log extends CActiveRecord
{
	// log categories
	const USER_CONTROLLER = "USER_CONTROLLER";

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'tbl_log';
	}
}
