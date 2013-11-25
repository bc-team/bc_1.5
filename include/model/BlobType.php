<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/baseType.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
 */
class BlobType extends baseType {

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
		$this->type="BLOB";
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
		$notNull="";
		if($this->mandatory==MANDATORY)
		{
			$notNull="NOT NULL";
		}
		$query= Parser::first_comma("create".$entity_name,", ")."{$this->name} LONGBLOB {$notNull}";
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
		return parent::save($commaId);
	}
}

/**
 * Color type factory
 * @author nicola
 *
 */
class BlobTypeFactory implements baseTypeFactory
{
	function create($name, $type, $for_key, $pri_key, $length, $mandatory)
	{
		return new BlobType($name, $type, $for_key, $pri_key, $length, $mandatory);
	}
}
?>