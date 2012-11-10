<?php

/**
 * This is the model class for table "tbl_login_history".
 *
 * The followings are the available columns in table 'tbl_login_history':
 * @property integer   $id
 * @property timestamp $timestamp
 * @property integer   $user_id
 * @property enum      $action
 */
class LoginHistory extends CActiveRecord
{
	// enum values for $action
	const ACTION_LOGIN = "LOGIN";
	const ACTION_LOGOUT = "LOGOUT";

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
		return 'tbl_login_history';
	}
}
