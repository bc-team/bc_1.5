<?php

session_start();
require_once "include/beContent.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin();
InitGraphic::getInstance()->createGraphic($main);

$home = new Skinlet("home");

$slider = new Skinlet("slider");
$partner = new Skinlet("partner");

$projectContent = new Content($projectEntity, $imageEntity);
$projectContent->apply($home, "project");

$home->setContent("partner", $partner->get());
$main->setContent('slider', $slider->get());
$main->setContent('body', $home->get());


$main->close();