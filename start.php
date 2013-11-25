<?php

session_start();
require_once "include/beContent.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin();
InitGraphic::getInstance()->createGraphic($main);

//$getStartedTemplate = new Skinlet("multiple/bc_lecture_multiple");

$title = new Skinlet("title");
$sideBar = new Skinlet("side_bar");

$player = new Skinlet("widget/video_player");

$video = new Content($lectureEntity, $videoEntity);
//$video->apply($player,'video');

//$getStartedTemplate->setContent("player", $player->get());

$main->setContent('title', $title->get());
$main->setContent('body', $video->get());
$main->setContent('sideBar', $sideBar->get());
//$main->setContent('body', $getStartedTemplate->get());

$main->close();