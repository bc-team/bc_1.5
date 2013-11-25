<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
class EntitySection extends Entity
{
	public function __construct($database,$name)
	{
		parent::__construct($database,$name);
		$this->setPresentation("name");
		$this->addField("name", VARCHAR, 40);
	}
}
$sectionEntity = new EntitySection($database, "sys_section");