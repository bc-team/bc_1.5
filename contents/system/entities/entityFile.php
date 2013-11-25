<?php
/**
 * Class EntityFile
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 */

class EntityFile extends Entity
{
	public function __construct($database, $name,$owner="")
	{
		parent::__construct($database,$name,$owner);
		$this->addField("filename",VARCHAR,255, MANDATORY);
		$this->addField("data",BLOB,null,MANDATORY);
		$this->addField("size",INT,5);
		$this->addField("filetype",VARCHAR,255,MANDATORY);
	}
}
$fileEntity=new EntityFile($database,"sys_file");