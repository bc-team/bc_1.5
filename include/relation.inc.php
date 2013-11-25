<?php
/**
require_once 'entity.inc.php';


Class Relation extends Entity {
	var
	$entity_1,
	$entity_2;

	function Relation($entity_1, $entity_2, $name = "") {

		$this->entity_1 = $entity_1;
		$this->entity_2 = $entity_2;

		if (!$this->entity_1->name) {
			echo Message::getInstance()->getMessage(MSG_ERROR_UNKNOWN_ENTITY)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		if ($name != "") {
			$this->Entity(DB::getInstance(),"{$name}");
		} else {
			$this->Entity(DB::getInstance(),"{$this->entity_1->name}_{$this->entity_2->name}");
		}

		$this->noKey();
		
		if ($this->entity_1->standardKey) {
			$this->addReference($this->entity_1);
		} else {
			$this->addReference($this->entity_1,$this->entity_1->fields[0]->name);
		}
		
		if ($this->entity_2->standardKey) {
			$this->addReference($this->entity_2);
		} else {
			$this->addReference($this->entity_2,$this->entity_2->fields[0]->name);
		}
	}
	
	
}
*/
?> 