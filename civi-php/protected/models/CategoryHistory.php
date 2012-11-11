<?php

/**
 * This is the model class for table "tbl_category_history".
 *
 * The followings are the available columns in table 'tbl_category_history':
 * @property integer $id
 * @property timestamp $timestamp
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $institution
 * @property float $boardsize
 * @property float $rmax
 * @property float $tmax
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property User[] $tblUsers
 */
class CategoryHistory extends Category
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_category_history';
	}
}
