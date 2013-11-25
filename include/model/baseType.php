<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/Entity.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
 */
class baseType {
	public $name;
	public $type;
	public $foreign_key;
	public $primary_key;
	public $length;
	public $mandatory;
	public $query_line;
	public $localtype;
	public $entity;
	public $reference;
	public $reference_name;
	public $self_reference;
	public $exts;
	public $value;
	public $owner;
	public $multiplicity;


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
		$this->name=$name;
		$this->type=$type;
		$this->foreign_key=$for_key;
		$this->primary_key=$pri_key;
		$this->length=$length;
		$this->mandatory=$mandatory;
	}

	/**
	 * 
	 * @param unknown $entity
	 * @param unknown $reference
	 * @param unknown $self
	 * @param string $relationName
	 * @param string $callbackRelationName
	 */
	public function referenceTo($entity, $reference, $self,$relationName="",$callbackRelationName="") {
		$this->entity=$entity;
		$this->reference=$reference;
		$this->reference_name=$entity->entityName;
		$this->self_reference=$self;
		
		
	}

	/**
	 * 
	 * This method is used to generate the query line to create the column related to the instance of this type
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
		
		$query= Parser::first_comma("create".$entity_name,", ")."{$this->name} {$this->type} {$notNull}";
		return $query;
	}

	/**
	 * 
	 * This method is used to generate the query line to store DATA regarding this type
	 * @access public
	 * @param commaId
	 * @ParamType commaId 
	 */
	public function save($commaId) {
		$query="";
		if (isset($this->owner)) {
		
			/* the user is admin and the script has a selectfromreference for user */
			if (($_SESSION['user']['admin']) and (isset($this->value))) {
				$query .= Parser::first_comma($commaId,", ")."'{$this->value}'";
			} else {
				$query .= Parser::first_comma($commaId,", ")."'{$_SESSION['user']['username']}'";
			}
		} else {
			if (!isset($this->value)) {
				$this->value = "";
			}
			$query .= Parser::first_comma($commaId,", ")."'{$this->value}'";
		}
		return $query;
	}

	/**
	 * 
	 * This method is used to generate the query line to update DATA regarding this type
	 * @access public
	 * @param commaId
	 * @param value
	 * @ParamType commaId 
	 * @ParamType value 
	 */
	public function update($commaId, $value) {
		if (!isset($value)) {
			$value = "";
		}
		$query .= Parser::first_comma($commaId,", ").
		"{$this->name}='{$value}'";
		return $query;
	}

	/**
	 * 
	 * This method generates the specific where condition for the basetype
	 * 
	 * 
	 * 
	 * @access public
	 * @param where_value
	 * @param entity_name
	 * @param commaId
	 * @ParamType where_value 
	 * @ParamType entity_name 
	 * @ParamType commaId 
	 */
	public function generateSelectQueryPart($where_value, $entity_name, $commaId, $postfix="",$conditionType="AND") {
		if($postfix!="")
		{
			$postfix_string="{$postfix}";
		}
		else 
		{
			$postfix_string="";
		}
		
		$where_value=mysql_real_escape_string($where_value);
		$query= Parser::first_comma("select".$commaId,"{$conditionType} ")."{$entity_name}{$postfix_string}.{$this->name} = '{$where_value}' ";
		return $query;
	}
}

/**
 * Specific factory for this type 
 * @author nicola
 *
 */
interface baseTypeFactory
{
	function create($name, $type, $for_key, $pri_key, $length, $mandatory);
}