<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();


	/**
	 * @param string $id id of this controller
	 * @param CWebModule $module the module that this controller belongs to.
	 */
	public function __construct($id,$module=null)
	{
		parent::__construct($id, $module);
		new SchemaUpdater; // setup DB schema if needed
	}

	/**
	 * Save a model while keeping history.
	 *
	 * Uses a transaction, but also supports embedded use in running transactions
	 * (in embedded use, this does not commit or roll back, use the return value)
	 *
	 * @param $model model instance to be saved
	 * @param $historyModel copy of the model, instance of a "History"-suffixed class
	 * @param $historyModelIdAttr optional attribute name of History class to be set to the model ID
	 *
	 * @return whether save() was successful
	 */
	public function saveModelAndHistory($model, $historyModel, $historyModelIdAttr=null)
	{
		$myTransaction = false;
		$transaction = Yii::app()->db->getCurrentTransaction();
		if($transaction === null) {
			// no current running transaction, create our own one
			$myTransaction = true;
			$transaction = Yii::app()->db->beginTransaction();
		}

		if(!$model->save()) {
			if($myTransaction)
				$transaction->rollBack();
			Yii::log('model validation failed: ' . CVarDumper::dumpAsString($model), 'trace', 'Controller');
			return false;
		}

		if($historyModelIdAttr !== null)
			$historyModel->setAttribute($historyModelIdAttr, $model->id);

		if(!$historyModel->save()) {
			// log error: the history model should never fail to validate, as the original model has already validated successfully before
			Yii::log('historyModel ' . CVarDumper::dumpAsString($historyModel) . ' errors: ' . CVarDumper::dumpAsString($historyModel->getErrors()), 'error', 'Controller');

			// if we can't save the historyModel, roll back the complete transaction (don't save the original model data)
			if($myTransaction)
				$transaction->rollBack();
			return false;
		}

		// everything OK
		if($myTransaction)
			$transaction->commit();
		return true;
	}

	/**
	 * Create a new log entry (Log entity) in the DB.
	 *
	 * @param $category category constant from the Log class
	 * @param $message log message
	 *
	 * @return whether the DB operation was successful
	 */
	public function createLogEntry($category, $message)
	{
		$logEntry = new Log;
		$logEntry->category = $category;
		$logEntry->log = $message;
		return $logEntry->save();
	}

	/**
	 * Parse a percentage string. Returns the number if not percentage string (contains no '%' sign)
	 */
	public function decodePercent($percentStr)
	{
		if(preg_match('/^[0-9]{1,2}\%$/', $percentStr))
			$percentStr = (substr($percentStr, 0, strpos($percentStr,'%'))/100);
		return $percentStr;
	}

	/**
	 * Parse percentage strings of an array. Keeps the number if not percentage string (contains no '%' sign)
	 *
	 * @param array $percentArray associative array of stuff
	 * @param array $entries entries (keys) to be 'unpercented'
	 */
	public function decodePercentArray($percentArray, $entries)
	{
		foreach($entries as $key)
			$percentArray[$key] = $this->decodePercent($percentArray[$key]);
		return $percentArray;
	}
}
