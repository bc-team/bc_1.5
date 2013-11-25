<?php

session_start();
require_once "include/beContent.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin();
InitGraphic::getInstance()->createGraphic($main);

$team = new Skinlet("team");
$developer = new Content($developerEntity, $imageEntity);
$developer->apply($team, 'dev');

$title = new Skinlet("title");
$partner = new Skinlet("partner");

$sliderTemplate = new Skinlet('widget/flex_slider');
$sliderImage = new Content($sliderEntity, $imageSliderRelation, $imageEntity);
$sliderImage->setFilter('titolo', 'sliderTeam');
$sliderImage->forceSingle();
$sliderImage->apply($sliderTemplate, 'slider');

$team->setContent("partner", $partner->get());
$team->setContent('slider', $sliderTemplate->get());
$main->setContent('title', $title->get());
$main->setContent('body', $team->get());

$main->close();