<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
class EntityUser extends Entity
{
	public function __construct($database, $name)
	{
		parent::__construct($database, $name);
		$this->setPresentation("(%username)");
		$this->addPrimaryKey("username", VARCHAR, 50);
		$this->addField("password", PASSWORD);
		$this->addField("email", VARCHAR, 100);
		$this->addField("name", VARCHAR, 50);
		$this->addField("surname", VARCHAR, 50);
		$this->addField("phone", VARCHAR, 20);
		$this->addField("active", VARCHAR, 1);
		$this->addField("active_newsletter", VARCHAR, 1);
		$this->addField("processed", VARCHAR, 1);
	}
}
$usersEntity = new EntityUser($database, "sys_user");