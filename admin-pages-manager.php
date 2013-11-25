<?php

session_start();

require 'include/beContent.inc.php';
require_once 'include/content.inc.php';
require 'include/auth.inc.php';
require_once(realpath(dirname(__FILE__)).'/include/view/template/InitGraphic.php');

$main = new Skin('system');

InitGraphic::getInstance()->createSystemGraphic($main);

$form = new Form('dataEntry',$pageEntity);

$form->addSection('Page Management');

$form->addText('title', 'Titolo', 60,null,60,true);
//$form->addTextarea('description', 'Description', 10, 50);
$form->addText('subtitle', 'Sottotitolo', 60);
$form->addText('link', 'Script Collegato',255);
$form->addEditor('body', 'Corpo', 50, 50);
$form->addSelectFromReference($pageEntity, 'father','Padre');

//$form->addHierarchicalPosition('section', 'Sezione padre',MANDATORY,$sectionEntity);

$imageForm=new ImageForm('imageEntry',$pageEntity);
$imageForm->addImage('foto','Foto');
$form->triggers($imageForm);

if (!isset($_REQUEST['action'])) {
	$_REQUEST['action'] = 'edit';
}

$main->setContent('body',$form->requestAction());

$main->close();
