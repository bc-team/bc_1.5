<?php

require_once(realpath(dirname(__FILE__)) . '/../../include/model/Entity.php');

/**
 * Class Relation
 * Gestione delle relazioni n-m
 */
Class Relation extends Entity {
	var
	$entity_1,
	$entity_2,
	$roleName1,
	$roleName2;

    /**
     * @param Entity $entity_1
     * @param Entity $entity_2
     * @param string $name
     * @property $name nome della tabella sul db
     * @param null $roleName1
     * @param null $roleName2
     */
    function __construct($entity_1, $entity_2, $name = "",$roleName1=null,$roleName2=null) {

		$this->entity_1 = $entity_1;
		$this->entity_2 = $entity_2;

		if (!$this->entity_1->name) {
			echo Message::getInstance()->getMessage(MSG_ERROR_UNKNOWN_ENTITY)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		if(isset($roleName1))
			$this->roleName1=$roleName1;
		else
			$this->roleName1=$this->entity_1->fields[0]->name."_".$this->entity_1->entityName;
		
		if(isset($roleName2))
			$this->roleName2=$roleName2;
		else
			$this->roleName2=$this->entity_2->fields[0]->name."_".$this->entity_2->entityName;
		
		
		if ($name != "") {
			parent::__construct(DB::getInstance(),"{$name}");
		} else {
			parent::__construct(DB::getInstance(),"{$this->entity_1->entityName}_{$this->entity_2->entityName}");
		}

		/**
		*
		*Relations do not have any primary key.
		*
		*/
        $this->addReference($this->entity_1,$this->roleName1);
        $this->addReference($this->entity_2,$this->roleName2);
	}
	
	
	/**
	 * Performs a deep linking between retrieved instances
	 * @param unknown $join_entities
	 */
	protected function linkInstances($join_entities)
	{
		parent::linkInstances($join_entities);
	}
}
?>