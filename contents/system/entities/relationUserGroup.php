<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
require_once realpath(dirname(__FILE__)) .'/entityUser.php';
require_once realpath(dirname(__FILE__)) .'/entityGroup.php';

$usersGroupsRelation = new Relation($usersEntity, $groupsEntity);