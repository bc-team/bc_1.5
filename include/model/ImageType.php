<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/baseType.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
 */
class ImageType extends baseType {

	/**
	 * @access public
	 * @param name
	 * @param type
	 * @param for_key
	 * @param pri_key
	 * @param length
	 * @param mandatory
	 * @ParamType name 
	 * @ParamType type 
	 * @ParamType for_key 
	 * @ParamType pri_key 
	 * @ParamType length 
	 * @ParamType mandatory 
	 */
	public function __construct($name, $type, $for_key, $pri_key, $length, $mandatory) {
		parent::__construct($name, $type, $for_key, $pri_key, $length, $mandatory);
		$this->type="IMAGE";  //beContent dependant
	}

	/**
	 * 
	 * (non-PHPdoc)
	 * @see baseType::connect()
	 * @access public
	 * @param entity_name
	 * @ParamType entity_name 
	 */
	public function connect($entity_name) {
		$query.= Parser::first_comma("create".$entity_name,", ")."{$this->name} LONGBLOB NOT NULL";
		$query.= Parser::first_comma("create".$entity_name,", ")."{$this->name}_thumb LONGBLOB NOT NULL";
		$query.= Parser::first_comma("create".$entity_name,", ")."{$this->name}_filename VARCHAR(255) NOT NULL";
		$query.= Parser::first_comma("create".$entity_name,", ")."{$this->name}_size INT UNSIGNED NOT NULL";
		$query.= Parser::first_comma("create".$entity_name,", ")."{$this->name}_type VARCHAR(40) NOT NULL";
		return $query;
	}

	/**
	 * 
	 * (non-PHPdoc)
	 * @see baseType::save($commaId)
	 * @access public
	 * @param commaId
	 * @ParamType commaId 
	 */
	public function save($commaId) {
		if (is_uploaded_file($_FILES[$this->name]['tmp_name'])) {
			$filename = $_FILES[$this->name]['name'];
			$filesize = $_FILES[$this->name]['size'];
			$filetype = $_FILES[$this->name]['type'];
		
			$fp = fopen($_FILES[$this->name]['tmp_name'],"r");
			$buffer = file_get_contents($_FILES[$this->name]['tmp_name']);
		
			if (get_magic_quotes_gpc()) {
				/*
		
				Here instead of trim one should use stripslashes but doesn't work.
		
				*/
		
				$buffer = mysql_real_escape_string(trim($buffer));
			} else {
				/*
		
				It could be that here something different is required.
		
				*/
		
				$buffer = mysql_real_escape_string(trim($buffer));
			}
		
			fclose($fp);
		}
		
		/* ** */
		
		list($width, $height) = getimagesize($_FILES[$this->name]['tmp_name']);
		$newwidth = 100; // $width * $percent;
		$newheight = 100; //$height * $percent;
		
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($_FILES[$this->name]['tmp_name']);
		
		// Resize
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		/* $buffer = imagejpeg($thumb); */
		
		/* ** */
		
		$buffer = (isset($buffer)) ? $buffer:"";
		$query .= Parser::first_comma($commaId,", ")."'{$buffer}'";
		
		/* Thumb */
		$buffer = imagejpeg($thumb);
		
		$buffer = (isset($buffer)) ? $buffer:"";
		$query .= Parser::first_comma($commaId,", ")."'{$buffer}'";
		
		$filename = (isset($filename)) ? $filename:"";
		$query .= Parser::first_comma($commaId,", ")."'{$filename}'";
		
		$filesize = (isset($filesize)) ? $filesize:"";
		$query .= Parser::first_comma($commaId,", ")."'{$filesize}'";
		
		$filetype = (isset($filetype)) ? $filetype:"";
		$query .= Parser::first_comma($commaId,", ")."'{$filetype}'";
			
		return $query;
	}

	/**
	 * @access public
	 * @param commaId
	 * @param value
	 * @ParamType commaId 
	 * @ParamType value 
	 */
	public function update($commaId, $value) {
		if ($_REQUEST[$this->name."_delete"]) {
			$query .= Parser::first_comma($commaId,", ")."{$this->name}=''";
			$query .= ", {$this->name}_thumb=''";
			$query .= ", {$this->name}_filename=''";
			$query .= ", {$this->name}_size=''";
			$query .= ", {$this->name}_type=''";
		} else {
			if (is_uploaded_file($_FILES[$this->name]['tmp_name'])) {
				$filename = $_FILES[$this->name]['name'];
				$filesize = $_FILES[$this->name]['size'];
				$filetype = $_FILES[$this->name]['type'];
				$fp = fopen($_FILES[$this->name]['tmp_name'],"r");
				$buffer = fread($fp, filesize($_FILES[$this->name]['tmp_name']));
				if ($this->addslashes) {
					$filename = addslashes($filename);
				} else {
					#$buffer = file_get_contents($_FILES[$this->name]['tmp_name']);
				}
				if (get_magic_quotes_gpc()) {
					/*
					Here instead of trim one should use stripslashes but doesn't work.
					*/
					$buffer = mysql_real_escape_string(trim($buffer));
				} else {
					/*
					It could be that here something different is required.
					*/
					$buffer = mysql_real_escape_string(trim($buffer));
				}
				fclose($fp);
					
				/* ** */
					
				#list($width, $height) = getimagesize($_FILES[$this->name]['tmp_name']);
				$newwidth = 100; // $width * $percent;
				$newheight = 100; //$height * $percent;
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($_FILES[$this->name]['tmp_name']);
				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagejpeg($thumb,$_FILES[$this->name]['tmp_name']);
				$fp = fopen($_FILES[$this->name]['tmp_name'],"r");
				$buffer_thumb = fread($fp, filesize($_FILES[$this->name]['tmp_name']));
				/* ** */
				$query .= Parser::first_comma($commaId,", ")."{$this->name}='{$buffer}'";
				$query .= ", {$this->name}_thumb='{$buffer_thumb}}'";
				$query .= ", {$this->name}_filename='{$filename}'";
				$query .= ", {$this->name}_size='{$filesize}'";
				$query .= ", {$this->name}_type='{$filetype}'";
			}
		}
		return $query;
	}
}
/**
 * Color type factory
 * @author nicola
 *
 */
class ImageTypeFactory implements baseTypeFactory
{
	function create($name, $type, $for_key, $pri_key, $length, $mandatory)
	{
		return new ImageType($name, $type, $for_key, $pri_key, $length, $mandatory);
	}
}
?>