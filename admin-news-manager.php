<?php

/**
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 */

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";
require_once 'include/content.inc.php';
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin("system");
InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form("dataEntry",$newsEntity);

$form->addSection("News Management");
$form->addText("title", "Titolo", 80, MANDATORY);
$form->addLongDate("date", "Data", MANDATORY);

$form->addEditor("body", "Testo", 20, 50);
$form->addCheck("active", "Attiva");

$main->setContent("body", $form->requestAction());

$main->close();
