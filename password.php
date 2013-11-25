<?php

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');


/* LOCAL START */

Class UserForm extends Form {
	
	function UserForm($database, $resource, $method = "GET") {
		$this->FORM($database,$resource,$method);
	}
	
	function addItem_preInsertion() {
		
		$password = substr(md5(time()),0,8);
		$_REQUEST['password'] = $password;
		
	}
	
	function addItem_postInsertion() {
		
		
		/* controllare reload */
		
		$mail = new Template( Settings::getSkin()."/user.mail");
		
		$mail->setContent("name", $_REQUEST['name']);
		$mail->setContent("username", $_REQUEST['username']);
		$mail->setContent("password", $_REQUEST['password']);
		$mail->setContent("message", $_REQUEST['message']);
		
		mail("{$_REQUEST['email']}","{Config::getInstance()->getConfigurations()['website']['name']} Login data", $mail->get(), "From: {{Config::getInstance()->getConfigurations()['website']['email']}}");
		
		
	}
	
}


/* LOCAL END */


#if (isset($_SESSION['registered-user'])) {
#	$main = new Template("dtml_{$_SESSION['language']}/frame-public-2.html");
#} else {
#	$main = new Template("dtml/frame-private.html");
#}


$main = new Skin(); 

$form = new Form("dataEntry",$usersEntity);

$form->addSection("Modifica Password");

#$form1->addText("username", "username", 20, MANDATORY);

#$form1->addSection("personal data");

$form->addPassword("password", Parser::lingual("Nuova Password", "New Password", "Nuova Password"));

if (!isset($_REQUEST['page'])) {
	$_REQUEST['page'] = 1;
	$_REQUEST['value'] = $_SESSION['user']['username'];
}

$main->setContent("body",$form->editItem(NO_DELETE));
	
$main->close();

?> 