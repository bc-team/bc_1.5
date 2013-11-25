<?php
/**
 * This class is an Instance of the entity that is passed in the constructor
 * @author nicola
 *
 */
class Instance
{
	public $fields;
	public $presentation;
	public $entityName;
	public $linkingFields;
	public $keyFieldName;
	
	public function Instance(Entity $entity)
	{
		$this->entityName=$entity->name;
		foreach($entity->fields as $k=>$v)
		{
			$this->fields[$v->name]=TypeBuilder::getInstance()->create($v->name, $v->type, $v->foreign_key, $v->primary_key, $v->length, $v->mandatory);
			if(isset($v->reference))
			{
				$this->fields[$v->name]->reference=$v->reference;
				$this->linkingFields[$v->name]=$this->fields[$v->name];
			}
			if($v->primary_key==true)
			{
				$this->keyFieldName=$v->name;
			}
			$this->{$v->name}="";
		}
	}

	public function getKeyField()
	{
		$turnback=null;
		
		if(isset($this->fields[$this->keyFieldName]))
			$turnback=$this->fields[$this->keyFieldName];
		
		return $turnback;
	}
	
	
	public function getKeyFieldValue()
	{
		$turnback=null;
		
		if(isset($this->{$this->keyFieldName}))
			$turnback=$this->{$this->keyFieldName};
		
		return $turnback;
	}
	
	public function setFieldValue($name,$value)
	{

			$this->fields[$name]->value=$value;
			$this->{$name}=$value;
	}

	public function addReference($name,$instance)
	{
		$alreadyLinked=false;
		if(!isset($this->{$name})||!is_array($this->{$name}))
		{
			$this->{$name}=array();
		}
		else{
			if(isset($this->{$name}[$instance->getKeyFieldValue()]))
				$alreadyLinked=true;
		}
		
		if(!$alreadyLinked)
			$this->{$name}[$instance->getKeyFieldValue()]=$instance;
	}


	public function getFieldValue($name)
	{
		$turnback=null;
	
		if(isset($this->fields[$name]))
 			$turnback = $this->fields[$name]->value;
		
		return $turnback;
	}
	
	public function getField($name)
	{
		$turnback=null;

 		if(isset($this->fields[$name]))
 			$turnback = $this->fields[$name];
 		
 		
		return $turnback;
	}
	
	
	public function link()
	{
		if(is_array($this->linkingFields))
		foreach($this->linkingFields as $k=>$v)
		{
			if(isset($v->reference) && $v->reference->loaded)
			{
 				$alreadyLinked=false;
 				if(!isset($this->{$v->name})||!is_array($this->{$v->name}))
 				{
 					$this->{$v->name}=array();
 				}
 				else{
 						//if(isset($this->{$v->name}))
 							//$alreadyLinked=true;
 				}

 				if(!$alreadyLinked)
 				{
					$instanceToBeLinked=$v->reference->getInstance($v->value);
					if(isset($instanceToBeLinked))
					{
						$this->{$v->name}=$v->reference->getInstance($v->value);
						$v->reference->getInstance($v->value)->addReference($this->entityName,$this);
					}
				}
			}
		}
	}
	
}
?>