<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
class EntityLog extends Entity
{
	public function __construct($database,$name)
	{
		parent::__construct($database,$name);
		$this->setPresentation("date", "entity", "operation");
		
		$this->addField("operation", VARCHAR, 20);
		$this->addField("entity", VARCHAR, 100);
		$this->addField("itemid", VARCHAR, 255);
		$this->addField("service", VARCHAR, 100);
		$this->addField("username", VARCHAR, 15);
		$this->addField("date", LONGDATE);
		$this->addField("ip",VARCHAR, 15);
	}
}
$logEntity = new EntityLog($database, "sys_log");
?>