<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/baseType.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
 */
class File2FolderType extends baseType {

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
		$this->type="FILE2FOLDER";  //beContent dependant
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
		$query.= Parser::first_comma("create".$entity_name,", ")."{$this->name}_reference VARCHAR(255) NOT NULL";
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
			$filename_local = md5(uniqid(time()));
			$filename = $_FILES[$this->name]['name'];
			$filesize = $_FILES[$this->name]['size'];
			$filetype = $_FILES[$this->name]['type'];
			if (ereg("\.([[:alnum:]]*)$", $filename, $token)) {
				if (isset($this->exts[$token[1]])) {
					if ($this->exts[$token[1]] == AUTO) {
						$extension = ".{$token[1]}";
					} else {
						$extension = ".{$this->exts[$token[1]]}";
					}
				} else {
					$extension = "";
				}
			}
			$filename_local = $filename_local.$extension;
			move_uploaded_file($_FILES[$this->name]['tmp_name'], "{Config::getInstance()->getConfigurations()['upload_folder']}/{$filename_local}");
		} else {
			$filename_local = "";
			$filename = "";
			$filesize = 0;
			$filetype = "";
		}
		$query .= Parser::first_comma($commaId,", ")."'{$filename_local}'";
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
		
			if (file_exists("{Config::getInstance()->getConfigurations()['upload_folder']}/{$_REQUEST[$this->name."_reference"]}")) {
				unlink("{Config::getInstance()->getConfigurations()['upload_folder']}/{$_REQUEST[$this->name."_reference"]}");
			}
			$query .= Parser::first_comma($commaId,", ")."{$this->name}_reference = ''";
			$query .= ", {$this->name}_filename = ''";
			$query .= ", {$this->name}_size = ''";
			$query .= ", {$this->name}_type = ''";
		
		} else {
			if (is_uploaded_file($_FILES[$this->name]['tmp_name'])) {
		
		
				if ($_REQUEST[$this->name."_reference"] != "") {
					if (file_exists("{Config::getInstance()->getConfigurations()['upload_folder']}/{$_REQUEST[$this->name."_reference"]}")) {
						unlink("{Config::getInstance()->getConfigurations()['upload_folder']}/{$_REQUEST[$this->name."_reference"]}");
					}
				}
		
				$filename_local = md5(uniqid(time()));
				$filename = $_FILES[$this->name]['name'];
				$filesize = $_FILES[$this->name]['size'];
				$filetype = $_FILES[$this->name]['type'];
		
				if (ereg("\.([[:alnum:]]*)$", $filename, $token)) {
		
					if (isset($this['exts'][$token[1]])) {
						if ($this['exts'][$token[1]] == AUTO) {
							$extension = ".{$token[1]}";
						} else {
							$extension = ".{$this['exts'][$token[1]]}";
						}
					} else {
						$extension = "";
					}
		
				}
					
				$filename_local = $filename_local.$extension;
				$config = Config::getInstance()->getConfigurations();
				move_uploaded_file($_FILES[$this->name]['tmp_name'], $config['upload_folder']."/$filename_local");
				if ($this->addslashes) {
					$filename = addslashes($filename);
				}
		
				$query .= Parser::first_comma($commaId,", ")."{$this->name}_reference='{$filename_local}'";
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
class File2FolderTypeFactory implements baseTypeFactory
{
	function create($name, $type, $for_key, $pri_key, $length, $mandatory)
	{
		return new File2FolderType($name, $type, $for_key, $pri_key, $length, $mandatory);
	}
}
?>