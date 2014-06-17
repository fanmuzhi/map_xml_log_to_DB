<?php
	require_once "/usr/share/pear/XML/Serializer.php";
	require_once "/usr/share/pear/XML/Unserializer.php";
//	require_once "C:/xampp/php/pear/XML/Serializer.php";
//	require_once "C:/xampp/php/pear/XML/Unserializer.php";

class xml_log_API
{
	private $xml_file = '';
	private $unserializer;
	private $unserialized_obj;
	
	private $options = array( 
					   "indent"          => "    ", 
					   "linebreak"       => "\n", 
					   "typeHints"       => false, 
					   "addDecl"         => true, 
					   "encoding"        => "UTF-8", 
					   "rootAttributes"  => array("desciprtion" => "This is a moive class"), 
					   "defaultTagName"  => "item", 
					   "attributesArray" => "_attributes", 
					   "complexType" => "object"
					 );
					 
	public function __construct($source)
	{
		try
		{
			$this->xml_file = $source;
			$this->unserializer = new XML_Unserializer($this->options);
			$this->unserialized_obj = $this->unserializer->unserialize($this->xml_file,true);
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
	
	public function get_obj_of_xml()
	{
		try
		{
			$xml_obj = $this->unserializer->getUnserializedData();
			return $xml_obj;
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
	
	public function get_root_name()
	{
		try
		{
			$root_name = $this->unserializer->getRootName();
			return $root_name;
		}
		catch(Exception $ex)
		{
			$this->error_message=$ex->getMessage();
		}
	}
}



// $options = array(
//	"indent"          => " ", 
//   "linebreak"       => "", 
//   "typeHints"       => false, 
//   "addDecl"         => true, 
//   "encoding"        => "UTF-8", 
//   "rootAttributes"  => "", 
//   "defaultTagName"  => "item", 
//   "attributesArray" => "_attributes", 
//   "complexType" => "object"
////
//    );
//
//    $serializer = new XML_Serializer($options);
//
//    $rdf        = $serializer->serialize($data);
//    $serialized = $serializer->getSerializedData();
//    echo $serialized;
?>
