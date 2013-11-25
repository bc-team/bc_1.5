<?php
/**
 * Created by IntelliJ IDEA.
 * User: daniele
 * Date: 12/09/13
 * Time: 19.02
 * To change this template use File | Settings | File Templates.
 */
require_once realpath(dirname(__FILE__)) . '/core.php';
require_once realpath(dirname(__FILE__)) . '/entityImage.php';
require_once realpath(dirname(__FILE__)) . '/entitySlider.php';

$imageSliderRelation = new Relation($imageEntity, $sliderEntity);