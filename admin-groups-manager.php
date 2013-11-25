<?php

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";
require_once 'include/content.inc.php';
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form("dataEntry",$groupsEntity);

$form->addTitleForm("Group Management");
$form->addSection('group details');
$form->addText("name", "Name", 40, MANDATORY);
$form->addEditor("description", "Description", 17, 60);

$form_services = new RelationForm("dataEntry2", $servicesGroupsRelation);
$form_services->addSection("Services");
$form_services->addRelationManager("services", "Services", LEFT);
$form->triggers($form_services);

$form_users = new RelationForm("dataEntry3", $usersGroupsRelation);
$form_users->addSection('Users');
$form_users->addRelationManager("users", "Users", LEFT);
$form->triggers($form_users);

$main->setContent("body", $form->requestAction());

$main->close();

?>