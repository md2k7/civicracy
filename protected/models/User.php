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
	public $repeat_password;
	public $initialPassword;

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
			array('username, email, realname', 'required'),
			array('password, repeat_password', 'required', 'on'=>'insert'),
			array('repeat_password', 'default'),
			array('password', 'compare', 'compareAttribute'=>'repeat_password'),
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
			'username' => Yii::t('app', 'models.username'),
			'password' => Yii::t('app', 'models.password'),
			'repeat_password' => Yii::t('app', 'models.repeat_password'),
			'email' => Yii::t('app', 'models.email'),
			'realname' => Yii::t('app', 'models.realname'),
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

	/**
	 * @return CArrayDataProvider providing our weights per category
	 */
	public function getVoteCount()
	{
		$categories = Category::model()->findAll();
		$voteCount = array();

		$users = array();
		$userObjects = User::model()->findAll();
		foreach($userObjects as $u)
			$users[] = $u->id;

		foreach($categories as $c) {
			$votes = Vote::model()->findAllByAttributes(array('category_id' => $c->id));
			$graph = new VoteGraph($users, $votes);
			$weights = $graph->getWeights();

			$entry = new VoteCount;
			$entry->categoryName = $c->name;
			$entry->voteCount = $weights[$this->id];
			$voteCount[] = $entry;
		}

		return new CArrayDataProvider($voteCount, array(
			'id' => 'vote_count',
			'keyField' => 'categoryName',
		));
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->initialPassword;
	}
 
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	/**
	 * Executed after validation, but before saving. Generates a fresh salt for new passwords.
	 */
	protected function beforeSave()
	{
		// if the user left the pw field empty, he didn't change his password - keep the old one
		if(empty($this->password))
			$this->password = $this->initialPassword;
		else
			$this->createPasswordHash();

		return parent::beforeSave();
	}

	private function createPasswordHash()	
	{
		$this->salt = $this->createSalt();
		$this->password = md5($this->salt . $this->password);
	}

	protected function afterFind()
	{
		// don't show the password hash to the user
		$this->initialPassword = $this->password;
		$this->sanitizePassword();

		return parent::afterFind();
	}

	public function sanitizePassword()
	{
		$this->password = '';
		$this->repeat_password = '';
	}

	private function createSalt()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890!$%&/()=[]{}+#-*~.,_';
		$len = 20;
		$salt = '';

		for($i = 0; $i < $len; $i++)
			$salt .= substr($alphabet, rand(0, strlen($alphabet) - 1), 1);

		//Yii::trace('salt created: ' . $salt);

		return $salt;
	}

	/*
	 * @param string $attribute the name of the attribute to be validated
	 * @param array $params options specified in the validation rule
	 */
	public function isUniqueAttribute($attribute, $params)
	{
		$other = $this->find($attribute . '=:val', array(':val' => $this->getAttribute($attribute)));

		// if there is another user with that attribute, and that user is not us, that's a problem
		if($other !== null && $other->id !== $this->id)
			$this->addError($attribute, Yii::t('app', 'models.duplicate', array('{attribute}' => $this->getAttributeLabel($attribute), '{value}' => $this->getAttribute($attribute))));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer category ID
	 */
	public function loadVoteByCategoryId($categoryId)
	{
		$model=Category::model()->with('votes')->find('voter_id=:voter_id AND category_id=:category_id', array(
			':voter_id' => $this->id,
			':category_id' => $categoryId,
		));
		if($model === null || $model->votes === null || count($model->votes) != 1)
			return null;
		return $model->votes[0];
	}
}
