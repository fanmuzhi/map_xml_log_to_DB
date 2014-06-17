<?php

class fileAPI
{	
	public	$path;
	public	$files_array = array();
	public	$error_message;
	
	public function __construct($path)
	{
		try
		{
			$this->path = $path;
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
	
	
	
	public function __destruct()
	{
		try
		{
			unset($this->path);
			unset($this->files_array);
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
	

	
	public function search_by_file_type ( $dirname ,$file_type='xml')  
	{  
		try
		{
		    static $dInfo;  
		    $dirname .= subStr( $dirname, -1 ) == "/"  ? "" : "/";  
		    $dirInfo = glob( $dirname . "*");  
		    foreach ( $dirInfo as $info )
		    {  
				if( pathinfo($info,PATHINFO_EXTENSION)==$file_type or pathinfo($info,PATHINFO_EXTENSION)==strtoupper($file_type))
				{
		        	$dInfo[] = $info;
				}  
		        else if ( is_dir( $info ) )
		        {  
		            if ( !is_readable( $info ) )
		            {  
		                chmod( $info, 0777 );  
		            }  
		            $this->search_by_file_type( $info );  
		        }  
		    } 
//		    print_r($dInfo); 
		    return $dInfo;  
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}  
	
	
	
	public function first_sub_dir()
	{
		try
		{
		     $root_location = $this->path;
		     if( is_dir( $root_location )  )
		     {
		    	 $sub_dir_list = glob($root_location.'/'.'*',GLOB_ONLYDIR);
		     }
		     rsort($sub_dir_list);
		     return $sub_dir_list;
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
	
	public function move_file($file,$target_fold)
	{
		try
		{
			$move = copy($file, $target_fold);
			if($move)
			{
				unlink($file);
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
	
	
	
	
	
	
//	public function glob_sub_dir($root_location)
//	{
//		try
//		{
//			if(!isset($this->dir_list))
//			{
//				array_push($this->dir_list,$root_location);
//			}
//			array_push($this->dir_list,$temp= glob($root_location.'/'.'*',GLOB_ONLYDIR));
//			foreach ($temp as $sub_dir)
//			{
//				$this->glob_sub_dir($sub_dir);
//			}
//		}
//		catch(Exception $ex)
//		{
//			$this->error_message=$ex->getMessage();
//		}
//	}
	



	
}
?>
