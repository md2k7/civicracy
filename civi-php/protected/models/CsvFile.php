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
    	
    	if (($handle = fopen($location, "r")) !== FALSE) 		//Schauen, ob File existiert
    	{
    		$row = 1;
    		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) 	//Bis zum EOF lesen
    		{
    			$num = count($data);		//Wieviele Spalten sind in dieser Zeile
    			/*if($num < 2)
    				$output .= "Zu wenige elemente in der Zeile ".$row;		//Hier Fehlerbehandlung
    			elseif($num >3)
    				$output .= "Zu viele elemente in der Zeile ".$row;		//Hier Fehlerbehandlung
    			else
    			{*/
    				//Element in Spalte "realname" eintragen
    				$output[$row]['realname']=$data[0];
    				//Element in Spalte "email" eintragen
    				$output[$row]['email']=$data[1];				
    				//Element in Spalte "username" eintragen
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
    									
    			//}
    			$row++;
    		}
    		fclose($handle);
    	}
    	else
    	{
    		echo "CSV kann nicht gefunden werden"; 			//anpassen!!
    	}
    	return $output;
    }
 
}
?>