<?php

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');


$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form("dataEntry",$servicesEntity);

$form->addSection("Service Management");

$form->addText("name", "Name", 100, MANDATORY,40,true);
$form->addText("script", "Script", 100, MANDATORY);
$form->addEditor("des", "Description", 15, 40);

$form->addSection("Menu");

$form->addText("entry", "Menu Entry", 100, MANDATORY);

$form->addHierarchicalPosition("servicecategory", "Position", MANDATORY, $servicecategoryEntity);    


$form->addSelectFromReference2($entitiesEntity, "id_entities", "Entity");


$form->addSelectFromReference2($groupsEntity, "superuser_group", "Superuser Group");

$form_groups = new RelationForm("dataEntry2", $servicesGroupsRelation);

$form->addSection("Groups");
$form_groups->addRelationManager("groups", "Groups");
$form->triggers($form_groups);

if (!isset($_REQUEST['action'])) {
	$_REQUEST['action'] = "edit";
}

$main->setContent("body",$form->requestAction());

$main->close();


?> 