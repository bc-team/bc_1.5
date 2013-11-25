<?php
require_once realpath(dirname(__FILE__)) .'/entityGroup.php';
require_once realpath(dirname(__FILE__)) .'/entityEntities.php';
require_once realpath(dirname(__FILE__)) .'/entityUser.php';
require_once realpath(dirname(__FILE__)) .'/relationUserGroup.php';
require_once realpath(dirname(__FILE__)) .'/entityServiceCategory.php';
require_once realpath(dirname(__FILE__)) .'/entityService.php';
require_once realpath(dirname(__FILE__)) .'/relationServiceGroup.php';
require_once realpath(dirname(__FILE__)) .'/entityLog.php';
require_once realpath(dirname(__FILE__)) .'/entitySection.php';
require_once realpath(dirname(__FILE__)) .'/entityFile.php';
require_once realpath(dirname(__FILE__)) .'/entityImage.php';
require_once realpath(dirname(__FILE__)) .'/entityPage.php';
require_once realpath(dirname(__FILE__)) .'/entityMenu.php';
require_once realpath(dirname(__FILE__)) .'/entityNews.php';
require_once realpath(dirname(__FILE__)) .'/entitySlider.php';
require_once realpath(dirname(__FILE__)) .'/entityFileToFolder.php';
require_once realpath(dirname(__FILE__)) .'/entityVideo.php';
require_once realpath(dirname(__FILE__)) .'/relationImageSlider.php';
require_once realpath(dirname(__FILE__)) .'/relationSliderPage.php';

$groupsEntity->connect();
$entitiesEntity->connect();
$usersEntity->connect();
$usersGroupsRelation->connect();
$servicecategoryEntity->connect();
$servicesEntity->connect();
$servicesGroupsRelation->connect();
$logEntity->connect();
$sectionEntity->connect();
$pageEntity->connect();
$menuEntity->connect();
$newsEntity->connect();
$fileEntity->connect();
$imageEntity->connect();
$sliderEntity->connect();
$fileToFolderEntity->connect();
$videoEntity->connect();

$imageSliderRelation->connect();
$sliderPageRelation->connect();

require_once realpath(dirname(__FILE__)) .'/init.php';