<?php
/**
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 *
 */
require_once realpath(dirname(__FILE__)) .'/core.php';
class EntityService extends Entity
{
	public function __construct($database, $name)
	{
		parent::__construct($database, $name);
		$this->setPresentation("name");
		$this->addField("name", VARCHAR, 100);
		$this->addField("script", VARCHAR, 100);
		$this->addField("entry", VARCHAR, 100);
		$this->addField("visible", VARCHAR, 1);
		$this->addField("des", TEXT);
		$this->addField("position", POSITION);
	}
	
}
$servicesEntity = new EntityService($database,"sys_service");

$servicesEntity->addReference($servicecategoryEntity, "servicecategory");
$servicesEntity->addReference($entitiesEntity, "entities");
$servicesEntity->addReference($groupsEntity, "superuser_group");