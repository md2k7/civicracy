<?php
 
class CsvFile extends CFormModel {
 
    public $csvfile;
 
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            //note you wont need a safe rule here
            array('csvfile', 'file', 'types' => 'csv'),
        );
    }

    public function extractUsers($location)
    {
    	
    	if (($handle = fopen($location, "r")) !== FALSE) 		// check if file exists
    	{
    		$row = 0;
    		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) 	// read till EOF
    		{
    			$num = count($data);		// number of columns in this row

				if($num < 2 || $num > 3)
				{
					throw new CException(Yii::t('app', 'Wrong number of columns (must be 2 or 3) in row {row}', array('{row}' => ($row + 1))));
				}
				else
				{
    				// column "realname"
    				$output[$row]['realname']=$data[0];
    				// column "email"
    				$output[$row]['email']=$data[1];				
    				//column "username"
    				if ($num == 2)
    				{
    					$output[$row]['username'] = str_replace(' ', '',$data[0]);
    				}
    				if($num == 3)
    				{
    					if($data[2] == "")
    						$output[$row]['username'] = str_replace(' ', '',$data[0]);
    					else
    						$output[$row]['username'] = $data[2];
    				}
    			}
    			$row++;
    		}
    		fclose($handle);
    	}
    	else
    	{
			throw new CException("can't find CSV file to import from");
    	}
    	return $output;
    }
 
}
?>
