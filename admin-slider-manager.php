<?php

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";
require_once 'include/content.inc.php';
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form("dataEntry", $sliderEntity);

$form->addTitleForm("Slider Management");
$form->addSection('slider details');
$form->addText("titolo", "Titolo", 40, MANDATORY);
$form->addText("descrizione", "Descrizione", 40);
$form->addText("width", "Largezza", 40, MANDATORY);
$form->addText("height", "Altezza",40);

$relationForm = new RelationForm("dataEntry3", $imageSliderRelation);
$relationForm->addSection('Immagini da legare');
$relationForm->addRelationManager("id_sys_image", "Immagine", LEFT);
$form->triggers($relationForm);

$relationPageForm = new RelationForm("dataEntry3", $sliderPageRelation);
$relationPageForm->addSection('Pagine da legare');
$relationPageForm->addRelationManager("id_sys_page", "Pagine");
$form->triggers($relationPageForm);

$main->setContent("body", $form->requestAction());

$main->close();