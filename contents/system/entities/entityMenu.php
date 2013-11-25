<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
class EntityMenu extends Entity
{
	public function __construct($database,$name)
	{
		parent::__construct($database,$name);
		$this->setPresentation("entry");
		$this->addField("entry", VARCHAR, 100);
		$this->addField("link", VARCHAR, 255);
		$this->addField("position", POSITION);
	}
}
$menuEntity = new EntityMenu($database, "sys_menu");
$menuEntity->addReference($pageEntity, "linked_page");
$menuEntity->addReference($menuEntity, "parent");