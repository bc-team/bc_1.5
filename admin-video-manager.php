<?php

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";
require_once 'include/content.inc.php';
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form("dataEntry",$videoEntity);
$form->addTitleForm("File to Folder Management");
$form->addText('title', 'Titolo', 255);

//$form->addSection('file details');
$form->addFile("file", "Scegli il file");

$imageForm = new ImageForm('imageEntry',$videoEntity);
$imageForm->addImage('foto','Foto');
$form->triggers($imageForm);

$main->setContent("body", $form->requestAction());

$main->close();