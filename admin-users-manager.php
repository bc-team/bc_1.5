<?php


session_start();

require "include/beContent.inc.php";
require_once 'include/content.inc.php';
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');
require "include/auth.inc.php";

/* LOCAL START */

Class UserForm extends Form {

	function UserForm($database, $resource, $method = "GET") {
		$this->__construct($database,$resource,$method);
	}

	function editItem_postDeletion() {

	}

	function addItem_preInsertion() {

		$password = substr(md5(time()),0,8);
		echo $password;
		$_REQUEST['password'] = $password;

	}

	function addItem_postInsertion() {


		/* controllare reload */

		$skin = new Skin("handling");
		$mail = new Skinlet("user.mail");


		$mail->setContent("name", $_REQUEST['name']);
		$mail->setContent("username", $_REQUEST['username']);
		$mail->setContent("password", $_REQUEST['password']);
		$mail->setContent("message", $_REQUEST['message']);
		$mail->setContent("email", $_REQUEST['email']);

		if(isset($GLOBALS['homeEntity']))
		{
			if (isset($_REQUEST['home'])) {
				$mail->setContent("home", "http://www.di.univaq.it/home.php?username={$_REQUEST['username']}");

				$GLOBALS['homeEntity']->insertItem(NULL,
						"{$_REQUEST['username']}",
						date('YmdHi'),
						date('YmdHi'),
						"Generale",
						"General",
						"Home",
						"Home",
						"Pagina provvisoria di {$_REQUEST['name']} {$_REQUEST['surname']}",
						"Temporary page of {$_REQUEST['name']} {$_REQUEST['surname']}",
						"*",
						1);
			}

			Parser::mail($_REQUEST['email'],"{Config::getInstance()->getConfigurations()['website']['name']} Login data", $mail->get(), Config::getInstance()->getConfigurations()['website']['email']);
		}
	}
}


/* LOCAL END */

$main = new Skin("system");

InitGraphic::getInstance()->createSystemGraphic($main);

$form1 = new UserForm("dataEntry",$usersEntity);

$form1->addSection("User Management");

$form1->addText("username", "Username", 50, MANDATORY);
$form1->addPassword("password", "Password");

$form1->addSection("personal data");

$form1->addText("email", "Email", 50, MANDATORY);
$form1->addText("name", "Name", 40, MANDATORY);
$form1->addText("surname", "Surname", 40, MANDATORY);
$form1->addCheck("active", "Active");
$form1->addCheck("active_newsletter","Newsletter");

$form2 = new RelationForm("dataEntry2", $usersGroupsRelation);

$form1->addSection("usergroups");
$form2->addRelationManager("groups", "Groups");
$form1->triggers($form2);

$main->setContent("body",$form1->requestAction());


$main->close();

?>