<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
/**
 * plural naming schema only for retro-compatibility changing candidate
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 *
 */
class EntityGroup extends Entity
{
	public function __construct($database,$name)
	{
		parent::__construct($database,$name);
		$this->setPresentation("name");
		$this->addField("name", VARCHAR, 50);
		$this->addField("description", TEXT);
	}
}

$groupsEntity=new EntityGroup($database,"sys_group");