<?php
/**
 * @file
 * The entry point
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 *
 */

error_reporting(E_ALL);

include_once "definition.php";
include_once 'conf/config.php';
include_once "template.php";
include_once 'language.php';
include_once 'modules/module.php';
include_once 'templates/theme.php';

$config = Config::getInstance();
/**
 * Process
 */
$config->propogateEvent('init', array());
