<?php
require_once dirname(__FILE__).'/lib/file_api.php';
//require_once dirname(__FILE__).'/lib/xml_mapping.php';
require_once dirname(__FILE__).'/'.'../database/lib/database.php';
require_once dirname(__FILE__).'/'.'../database/lib/database_api.php';
require_once dirname(__FILE__).'/'.'../database/lib/valid.php';

//	$xml_log_location_array = array('D:/test_log_file_for_debug');
//	print_r($xml_log_location_array);

	$xml_log_location_array = array('/home/rawdata/SWJ',
									'/home/rawdata/ASF/TMT1',
									'/home/rawdata/ASF/TMT2',
									'/home/rawdata/ASF/TMT3',
									'/home/rawdata/ASF/TMT4',
									'/home/rawdata/ASF/TPT',
									);
									
									
//	$Invalid_sn_folder = 'D:/test_log_file_for_debug/Invalid';
	foreach ($xml_log_location_array as $key=>$xml_log_location)
	{
		try
		{
			$myDBAPI = new MyDataBaseAPI();
			$valid = new Valid();
			
			$i=1;
			$Invalid_sn_folder = $xml_log_location.'/../Invalid';
			$my_file = new fileAPI($xml_log_location);
			$folders = $my_file->first_sub_dir();
			$folders = array_slice($folders,0,7);
	//		print_r($folders);
			foreach ($folders as $folder_key=>$folder)
			{
				$log_list = $my_file->search_by_file_type($folder,'xml');
	//			print_r($log_list);
				if (is_array($log_list))
				{
					foreach ($log_list as $one_log)
					{
						echo $i."	";
//						$my_xmlAPI = new xml_log_API($one_log);
//						$xml_obj = $my_xmlAPI->get_obj_of_xml();
						$xml_obj = simplexml_load_file($one_log);
						
						if($valid->test_log_isValid($xml_obj))
						{
//							$myDBAPI = new MyDataBaseAPI();
							if($myDBAPI->db_log_check($xml_obj))
							{
							//echo $xml_obj->Serial_Number."<---"." already exist!";
								echo "";
							}
							else
							{
								$row_affected = $myDBAPI->table_dut_insert($xml_obj);
								if ( $row_affected != 0 )
								{
									$dut_id=$myDBAPI->get_auto_increased_id('trackpad','dut')-1;
									if($xml_obj->Test_Station == 'IDD StandBy')
									{
										$myDBAPI->idd_table_insert($dut_id,$xml_obj);
									}
									else if($xml_obj->Test_Station == 'TMT' or $xml_obj->Test_Station == 'TPT')
									{
										if(isset ($xml_obj->Raw_Count_Averages))
										{
											$table_name = "rawcountaverage";
											$myDBAPI->sub_table_insert($dut_id,$table_name,$xml_obj->Raw_Count_Averages);
										}
										if(isset ($xml_obj->Raw_Count_Noise))
										{
											$table_name = "rawcountnoise";
											$myDBAPI->sub_table_insert($dut_id,$table_name,$xml_obj->Raw_Count_Noise);
										}
										if(isset ($xml_obj->Global_IDAC_Value))
										{
											$table_name	=	"idacvalue";
											$myDBAPI->sub_table_insert($dut_id,$table_name,$xml_obj->Global_IDAC_Value);
										}
										if(isset ($xml_obj->IDAC_Value))
										{
											$table_name	=	"idacvalue";
											$myDBAPI->sub_table_insert($dut_id,$table_name,$xml_obj->IDAC_Value);
										}
										
									}
									echo "Log of ".$xml_obj->Serial_Number." of ".$xml_obj->Test_Station. " inserted"."\n";
								}
							}
//							else
//							{
//								echo "Same Log of ".$xml_obj->Serial_Number." of ".$xml_obj->Test_Station. " has already been in the database"."\n";
//							}
						}
						else
						{
							echo "File ".$one_log. "'s Test Log --> ".$xml_obj->Serial_Number." <-- is Not Valid!"."\n" ;
							if($my_file->move_file($one_log, $Invalid_sn_folder.'/'.basename($one_log)))
							{
								echo "file has been moved"."\n";
							}
							else
							{
								echo "failed to move this file"."\n";	
							}
						}
						$i++;
					}
				}

			}
		}
		catch(Exception $e)
		{
	    	//json_encode($e);
			print $e."\n";
		}
	}
	



?>
