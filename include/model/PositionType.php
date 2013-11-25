<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/baseType.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
 */
class PositionType extends baseType {

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
		$this->type="POSITION";  //beContent dependant
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
		if ($this->primary_key) {
			$query= Parser::first_comma("create".$entity_name,", ")."{$this->name} INT UNSIGNED AUTO_INCREMENT";
		} else {
			$query= Parser::first_comma("create".$entity_name,", ")."{$this->name} INT UNSIGNED NOT NULL";
		}
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
		$query .= Parser::first_comma($commaId,", ")."'{$this->value}'";
		
		$this->positions[$this->name]['index'] = $i;
		$this->positions[$this->name]['all'] = $_REQUEST["{$this->name}_all"];
		$this->positions[$this->name]['value'] = $this->value;
		
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
		if(empty($value))
		{
			$value=0;
		}
		$query .= Parser::first_comma($commaId,", ").
		"{$this->name}='{$value}'";
		$this->positions[$this->name]['index'] = $i;
		$this->positions[$this->name]['all'] = $_REQUEST["{$this->name}_all"];
		$this->positions[$this->name]['value'] = $value;
		return $query;
	}
}

/**
 * Color type factory
 * @author nicola
 *
 */
class PositionTypeFactory implements baseTypeFactory
{
	function create($name, $type, $for_key, $pri_key, $length, $mandatory)
	{
		return new PositionType($name, $type, $for_key, $pri_key, $length, $mandatory);
	}
}
?>