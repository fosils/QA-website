<?php
/**
 * @file
 * The entry point
 *
 * Copyright @ Open-org.com, all rights reserved
 *
 */

include_once "definition.php";
include_once "template.php";
include_once 'language.php';
include_once 'menu.php';
include_once 'function.php';
/**
 * Initialise modules and session
 * see @file function.php
 */
init();
/**
 * Get the request data
 */
$_path = menu_alias_to_path($_REQUEST['q']);
$module = menu_get_module_name($_path);
$title = menu_get_title($_path);
$controller = new $module();
$controller->dispatch();
