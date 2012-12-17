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
 * @property string $email
 * @property string $realname
 * @property string $slogan
 * @property integer $active
 * @property string $activationcode
 */
class UserHistory extends User
{
	private $referenceModel;

	/**
	 * Set reference model (User) so we can clone its password hash.
	 */
	public function setReferenceModel($referenceModel)
	{
		$this->referenceModel = $referenceModel;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user_history';
	}

	/**
	 * Executed after validation, but before saving. Original method on User generates a fresh hash for new passwords.
	 */
	protected function beforeSave()
	{
		$this->password = $this->referenceModel->password;
		return CActiveRecord::beforeSave();
	}

	/**
	 * Checks uniqueness of usernames, not used in UserHistory
	 */
	public function isUniqueAttribute($attribute, $params)
	{
		// do nothing - work around unique username check in User model
	}

	/**
	 * Checks old password, not used in UserHistory
	 */
	public function validOldPassword($attribute, $params)
	{
		// do nothing - work around valid password check in User model
	}
}
