<?php
require_once realpath(dirname(__FILE__)) .'/core.php';
require_once realpath(dirname(__FILE__)) .'/entityService.php';
require_once realpath(dirname(__FILE__)) .'/entityGroup.php';

$servicesGroupsRelation = new Relation($servicesEntity, $groupsEntity);