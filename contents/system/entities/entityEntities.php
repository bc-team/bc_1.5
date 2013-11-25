<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
/**
 * this entity stores in database the schema for other entities, it's useful
 * in debug and website creation
 * @author nicola
 *
 */
class EntityEntities extends Entity
{
	public function __construct($database,$name)
	{
		parent::__construct($database,$name);
		$this->setPresentation("name");
		$this->addPrimaryKey("name", VARCHAR, 50);
		$this->addField("content_name", VARCHAR, 50);
		$this->addField("owner", VARCHAR, 1);
		$this->addField("forum", VARCHAR, 1);
		
	}
}
$entitiesEntity = new EntityEntities($database, "sys_entities");
$entitiesEntity->addReference($groupsEntity, "forum_moderator");
$entitiesEntity->addReference($groupsEntity,"moderator_group");
$entitiesEntity->addReference($groupsEntity,"priviledged_group");