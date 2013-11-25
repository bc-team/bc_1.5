<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
class EntityServiceCategory extends Entity
{
	public function __construct($database,$name)
	{
		parent::__construct($database, $name);
		$this->setPresentation("name");
		$this->addField("name", VARCHAR, 40);
		$this->addField("position", POSITION);
	}
}
$servicecategoryEntity = new EntityServiceCategory($database, "sys_servicecategory");