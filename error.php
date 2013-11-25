<?php
session_start();
DEFINE("LOGIN_ERROR", "loginError");
DEFINE("PRIVILEDGE_ERROR", "priviledgeError");
DEFINE("DATAFILTERING_ERROR", "dataFiltering");
DEFINE("NOTIFICATION", "notification");
DEFINE("NOTIFICATION_ERROR", "notification_error");

require "include/beContent.inc.php";
require_once "include/content.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

  

$main = new Skin();

InitGraphic::getInstance()->createGraphic($main);

switch ($_REQUEST['id']) {
	case LOGIN_ERROR:
		$body = new Skinlet("error");
		$body->setContent("message", "Username or password unknown.");
		unset($_SESSION['user']);
		$_SESSION['HTTP_LOGIN'] = false;
	break;
	case PRIVILEDGE_ERROR:
		$body = new Skinlet("error");
		$body->setContent("message", "Warning: you are not permitted to use this service!");
	break;
	case DATAFILTERING_ERROR:
		$body = new Skinlet("error");
		$body->setContent("message", "Warning: you are not permitted to modify this item!");
	break;
	case "pageNotFound":
		$body = new Template( Settings::getSkin()."/error.html");
		$body->setContent("message", "Warning: page not found!");
	break;
	case NOTIFICATION:
		$main = new Skin("orange"); 
		$body = new Skinlet("password_notification");
		break;
	case NOTIFICATION_ERROR:
		$main = new Skin("handling"); 
		$body = new Skinlet("password_notification_error");
		$body->setContent("ip", $_SERVER['REMOTE_ADDR']);
		break;
}

session_destroy();
$main->setContent("body",$body->get());
$main->close();

?>