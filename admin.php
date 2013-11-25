<?php

session_start();

require_once(realpath(dirname(__FILE__))."/include/beContent.inc.php");
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin('system');

InitGraphic::getInstance()->createSystemGraphic($main);

if (!isset($_SESSION['user'])){
    $body = new Skinlet("admin");
    $main->setContent("body", $body->get());
}
$main->close();