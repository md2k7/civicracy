<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $realname
 *
 * The followings are the available model relations:
 * @property Category[] $tblCategories
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, realname', 'required'),
			array('username, password, email, realname', 'length', 'max'=>128),
			array('username, realname', 'isUniqueAttribute'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('username, realname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'votes' => array(self::HAS_MANY, 'Vote', 'voter_id'),
			'supporters' => array(self::HAS_MANY, 'Vote', 'candidate_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => Yii::t('app', 'Username'),
			'password' => Yii::t('app', 'Password'),
			'email' => Yii::t('app', 'Email'),
			'realname' => Yii::t('app', 'Full name'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('realname',$this->realname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}
 
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	/**
	 * Override save() method of CActiveRecord to generate a fresh salt for new passwords
	 */
	public function save($runValidation=true, $attributes=NULL)
	{
		if($attributes === NULL || in_array('password', $attributes))
		{
			$this->salt = $this->createSalt();
			$this->password = md5($this->salt . $this->password);
			if($attributes !== NULL && !in_array('salt', $attributes))
				$attributes[] = 'salt';
		}
		return parent::save($runValidation, $attributes);
	}

	private function createSalt()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890!"§$%&/()=?';
		$len = 20;
		$salt = '';

		for($i = 0; $i < $len; $i++)
			$salt .= substr($alphabet, rand(0, strlen($alphabet) - 1), 1);

		return $salt;
	}

	/*
	 * @param string $attribute the name of the attribute to be validated
	 * @param array $params options specified in the validation rule
	 */
	public function isUniqueAttribute($attribute, $params)
	{
		if($this->find($attribute . '=:val', array(':val' => $this->getAttribute($attribute))) !== null)
			$this->addError($attribute, $this->getAttributeLabel($attribute) . ' duplicate: ' . $this->getAttribute($attribute) . ' is already registered.');
			$this->addError($attribute, Yii::t('app', '{attribute} duplicate: {value} is already registered.', array('{attribute}' => $this->getAttributeLabel($attribute), '{value}' => $this->getAttribute($attribute))));
	}
}
