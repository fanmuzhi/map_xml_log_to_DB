<?php
require_once "/lib/file_api.php";
require_once "/lib/xml_mapping.php";
require_once dirname(__FILE__).'/'.'../database/lib/database.php';
require_once dirname(__FILE__).'/'.'../database/lib/database_api.php';
require_once dirname(__FILE__).'/'.'../database/lib/valid.php';

	$xml_log_location = '/home/rawdata/SWJ';
	$Invalid_sn_folder = '/home/rawdata/SWJ_Invalid';
	
	try
	{
		$i=1;
		$my_file = new fileAPI($xml_log_location);
		$folders = $my_file->first_sub_dir();
		//	print_r($folders);
		foreach ($folders as $folder)
		{
			$log_list = $my_file->search_by_file_type($folder,'xml');
		//		print_r($log_list);
			foreach ($log_list as $one_log)
			{
				echo $i."	";
				$my_xmlAPI = new xml_log_API($one_log);
				$xml_obj = $my_xmlAPI->get_obj_of_xml();
				
				if($xml_obj->Test_Station != 'IDD StandBy')
				{
					if(isset ($xml_obj->Global_IDAC_Value))
					{
						$table_name	=	"idacvalue";
						
						$myDB = new MyDatabase();
								
						$sql =  " select dut.Id from dut " .
								" where dut.SerialNumber = '".$xml_obj->Serial_Number."'".
								" and dut.TestStation = '".$xml_obj->Test_Station."'".
								" and dut.TestTime = '".$xml_obj->Test_Time."'";
						$DUTID = $myDB->execute_scalar($sql);
						if($DUTID != -1)
						{
							$sql0 = "select * from idacvalue where DUTID = ".$DUTID;
							$idac_exist = $myDB->execute_scalar($sql0);
							if ($idac_exist == -1)
							{
								$myDBAPI=new MyDatabaseAPI();
								$myDBAPI->sub_table_insert($DUTID,$table_name,$xml_obj->Global_IDAC_Value);
								echo $xml_obj->Serial_Number." idacvalue inserted"."\n";
							}
						}
						else
						{
							echo $xml_obj->Serial_Number."	".$xml_obj->Test_Station."	".$xml_obj->Test_Time."#####################################"."\n";
						}
						
					}
				}
				$i++;
			}
		}
	}
				
				
				
				
				
				
	catch(Exception $e)
		{
        	//json_encode($e);
			print $e."\n";
    	}
	



?>