<?php

/**
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 */

require_once realpath(dirname(__FILE__)) .'/core.php';
class EntityNews extends Entity
{
	public function __construct($database,$name, $owner = "")
	{
		parent::__construct($database,$name,$owner);
		$this->setPresentation("title", "active");
		
		$this->addField("title", VARCHAR, 68, MANDATORY);
		$this->addField("lastmod", LONGDATE, MANDATORY);
		$this->addField("creation", LONGDATE, MANDATORY);
		$this->addField("date", LONGDATE, MANDATORY);
		$this->addField("active", VARCHAR, 1);
		$this->addField("body", TEXT);
        //search functionality
		$this->setTextSearchFields("title", "body");
		$this->setTextSearchScript("news.php?sys_news_id=");
		$this->setSearchPresentationHead("title");
		$this->setSearchPresentationBody("body");
	}
	
	public function save($query_conditions)
	{
		$query_conditions["creation"]=date("d/m/y");
		$query_conditions["creation_time"]=date("H:i:s");
		$query_conditions["owner"]=$_SESSION["user"]["username"];
		return parent::save($query_conditions);
	}
	
	public function update($where_conditions, $set_parameters)
	{
		$set_parameters["lastmod"]=date("d/m/y");
		$set_parameters["lastmod_time"]=date("H:i:s");
		return parent::update($where_conditions, $set_parameters);
	}
}
$newsEntity = new EntityNews($database, "sys_news", WITH_OWNER);
