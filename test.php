<?php
require_once "C:/xampp/php/pear/XML/Serializer.php";
require_once "C:/xampp/php/pear/XML/Unserializer.php";
	 $options = array( 
					     'complexType'       => 'object',               // complex types will be converted to arrays, if no type hint is given
                         'keyAttribute'      => '_originalKey',         // get array key/property name from this attribute
                         'typeAttribute'     => '_type',                // get type from this attribute
                         'classAttribute'    => '_class',               // get class from this attribute (if not given, use tag name)
                         'tagAsClass'        => true,                   // use the tagname as the classname
                         'defaultClass'      => 'stdClass',             // name of the class that is used to create objects
                         'parseAttributes'   => false,                  // parse the attributes of the tag into an array
                         'attributesArray'   => false,                  // parse them into sperate array (specify name of array here)
                         'prependAttributes' => '',                     // prepend attribute names with this string
                         'contentName'       => '_content',             // put cdata found in a tag that has been converted to a complex type in this key
                         'tagMap'            => array(),                // use this to map tagnames
                         'forceEnum'         => array(),                // these tags will always be an indexed array
                         'encoding'          => null,                   // specify the encoding character of the document to parse
                         'targetEncoding'    => null,                   // specify the target encoding
                         'decodeFunction'    => null,                   // function used to decode data
                         'returnResult'      => false                   // unserialize() returns the result of the unserialization instead of true
					 );
		 $xml_file = 'C:\Users\mzfa\Desktop\20130126\20130126\TMT\1160020003130410A76.xml';
		 $unserializer = new XML_Unserializer($options);
		$unserializer->unserialize($xml_file,true);
			$obj = $unserializer->getUnserializedData();
//			print_r($obj);
//			echo $unserializer->getRootName();
  		echo get_class($obj->Global_IDAC_Value) ;
//			$a = serialize($obj);
			
?>
