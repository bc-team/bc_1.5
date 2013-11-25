<?php

session_start();

require "include/beContent.inc.php";
require_once "include/content.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin();

InitGraphic::getInstance()->createGraphic($main);

$user = new Content($usersEntity);//-->,$usersGroupsRelation,$groupsEntity);How to?
#$foto->setOrderFields("foto_position");

$main->setContent("body", $user->get());

$main->close();  

?>