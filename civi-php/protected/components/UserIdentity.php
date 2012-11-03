<?php

/**
 * UserIdentity represents the data needed to identify a user.
 * It contains the authentication method that checks if the provided
 * data can identify the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 *
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$username=strtolower($this->username);
		$user=User::model()->find('LOWER(username) = :username AND active = :active',array('username' => $username, 'active' => 1));

		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id;
			$this->username=$user->username;
			// set isAdmin property of Yii::app()->user
			$this->setState('isAdmin', $this->username == 'admin');
			$this->setState('realname', $user->realname);
			$this->errorCode=self::ERROR_NONE;
		}
		return ($this->errorCode==self::ERROR_NONE);
	}

	public function getId()
	{
		return $this->_id;
	}
}
