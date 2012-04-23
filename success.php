<?php
/**
 * @file
 * Success page
 *
 * Copyright @ Open-org.com, all rights reserved
 *
 */

include_once "definition.php";
include_once "template.php";
include_once 'language.php';
include_once 'menu.php';
include_once 'session.php';
include_once 'function.php';
/**
 * Initialise modules and session
 * see @file function.php
 */
init();
$_path = '/question';
$module = menu_get_module_name($_path);
$_title = menu_get_title($_path);
$controller = new $module();
// Success if user already submitter the data.
$controller->step = 'success';
$controller->dispatch();
