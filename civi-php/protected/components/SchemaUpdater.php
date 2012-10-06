<?php

/**
 * SchemaUpdater is responsible for creating and maintaining the DB schema, according to tbl_parameter table, schema_version param
 */
class SchemaUpdater
{
	private $basePath;
	private static $initialized = false;

	/**
	 * The constructor runs all neccessary checks and updates.
	 */
	public function __construct()
	{
		// only setup the data once, we don't need to check afterwards
		if(self::$initialized)
			return;
		self::$initialized = true;

		$this->basePath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mysql' . DIRECTORY_SEPARATOR . Yii::app()->params['database.schema'];

		$db = Yii::app()->getDb();
		try {
			$version = $db->createCommand("SELECT value FROM tbl_parameter WHERE name = 'schema_version'")->queryRow();
		} catch(CDbException $e) {
			$version = 0;
		}
		$version = (int) $version['value'];
		$files = $this->getSchemaFiles();
		$currentVersion = max(array_keys($files)); // get newest known schema version

		for(; $version < $currentVersion; $version++) {
			$nextVersion = $version + 1;
			$lines = @file($this->basePath . DIRECTORY_SEPARATOR . $files[$nextVersion]) or array();
			foreach($lines as $command)
				if(trim($command) != '' && substr($command, 0, 2) != '--')
					$db->createCommand($command)->execute();
			$db->createCommand("UPDATE tbl_parameter SET value = '${nextVersion}' WHERE name = 'schema_version'")->execute();
		}
	}

	/**
	 * @return associative array, index: number, value: file name
	 */
	private function getSchemaFiles()
	{
		$result = array();
		$dir = @opendir($this->basePath) or null;
		$name = @readdir($dir) or false;
		while($name !== false) {
			if(($pos = strpos($name, '-')) !== false) {
				$id = (int) substr($name, 0, $pos);
				$result[$id] = $name;
			}
			$name = @readdir($dir) or false;
		}
		@closedir($dir);
		return $result;
	}
}
