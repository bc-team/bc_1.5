<?php

session_start();

require "include/beContent.inc.php";
require_once 'include/content.inc.php';
require "include/auth.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form("dataEntry",$menuEntity);

$form->addSection("Menu Management");

$form->addText("entry", "Entry", 40, MANDATORY,60,true);
$form->addText("link", "Link", 60);

$form->addSelectFromReference($pageEntity, "linked_page", "Page") ;
$form->addHierarchicalPosition("parent", "Menu padre");

$content = new Content($menuEntity, $menuEntity);
$content->setOrderFields("sys_menu_entry","sys_menu0_entry");
$form->setReportContent($content);

if (!isset($_REQUEST['action'])) {
	$_REQUEST['action'] = "report";
}

$main->setContent("body",$form->requestAction());


$main->close();

?> 
