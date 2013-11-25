<?php
/**
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 */
require_once realpath(dirname(__FILE__)) . '/core.php';
require_once realpath(dirname(__FILE__)) . '/entityPage.php';
require_once realpath(dirname(__FILE__)) . '/entitySlider.php';

$sliderPageRelation = new Relation($sliderEntity, $pageEntity);