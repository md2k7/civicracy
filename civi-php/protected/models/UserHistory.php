<?php

/**
 * This is the model class for table "tbl_user_history".
 *
 * The followings are the available columns in table 'tbl_user_history':
 * @property integer $id
 * @property timestamp $timestamp
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $realname
 * @property string $slogan
 * @property integer $active
 */
class UserHistory extends User
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user_history';
	}

	/**
	 * Executed after validation, but before saving. Original method on User generates a fresh salt for new passwords.
	 */
	protected function beforeSave()
	{
		return CActiveRecord::beforeSave();
	}

	/**
	 * Checks uniqueness of usernames, not used in UserHistory
	 */
	public function isUniqueAttribute($attribute, $params)
	{
		// do nothing - work around unique username check in User model
	}
}
