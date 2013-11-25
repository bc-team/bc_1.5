<?php
require_once realpath(dirname(__FILE__)) .'/core.php';

class EntityPage extends Entity
{
	public function __construct($database,$name, $owner = "")
	{
		parent::__construct($database,$name,$owner);
		$this->setPresentation("title");
		$this->addField("title", VARCHAR, 100);
		$this->addField("description", TEXT);
		$this->addField("subtitle", VARCHAR, 100);
		$this->addField("body", TEXT);
		$this->addField("position", POSITION);
		$this->addField("link", VARCHAR, 100);
        //search functionality
        $this->setTextSearchFields("title", "body");
        $this->setTextSearchScript("page.php?sys_page_id=");
        $this->setSearchPresentationHead("title");
        $this->setSearchPresentationBody("body");
	}

    public function save($query_conditions)
    {
        $query_conditions["owner"]=$_SESSION["user"]["username"];
        return parent::save($query_conditions);
    }
}
$pageEntity = new EntityPage($database, "sys_page", WITH_OWNER);
$pageEntity->addReference($sectionEntity, "section");
$pageEntity->addReference($pageEntity, "father");
$pageEntity->addReference($imageEntity,"foto");