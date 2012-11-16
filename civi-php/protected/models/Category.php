<?php

/**
 * This is the model class for table "tbl_category".
 *
 * The followings are the available columns in table 'tbl_category':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $institution
 * @property float $boardsize
 * @property float $rmax
 * @property float $tmax
 * @property boolean $viewboard
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property User[] $tblUsers
 */
class Category extends CActiveRecord
{
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
		return 'tbl_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('institution', 'default'),
			array('description', 'default'),
			array('name, institution', 'length', 'max'=>255),
			array('boardsize, rmax, tmax', 'required'),
			array('boardsize, rmax, tmax', 'numerical'),
			array('viewboard', 'boolean'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, description, institution, boardsize, rmax, tmax', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'votes' => array(self::HAS_MANY, 'Vote', 'category_id'),

			/* statistical queries */
			'voteCount' => array(self::STAT, 'Vote', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('app', 'models.category'),
			'description' => Yii::t('app', 'models.description'),
			'institution' => Yii::t('app', 'models.institution'),
			'boardsize' => Yii::t('app', 'models.boardsize'),
			'rmax' => Yii::t('app', 'models.rmax'),
			'tmax' => Yii::t('app', 'models.tmax'),
			'viewboard' => Yii::t('app', 'models.viewboard'),
		);
	}

	/**
	 * Used in vote/index to determine the candidate name for a category
	 * @return the candidate in this category voted for by us
	 */
	public function getCandidate()
	{
		return Vote::model()->with('candidate')->find('category_id=:category_id AND voter_id=:voter_id', array(':category_id' => $this->id, ':voter_id' => Yii::app()->user->id))->candidate;
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

		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function viewboard()
	{
		if($this->viewboard==true)
			return Yii::t('app', 'yes');
		else 
			return Yii::t('app', 'no');
	}
}
