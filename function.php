<?php
/**
 * @file
 * User interface functions
 *
 * Copyright @ Open-org.com, All rights reserved
 * Created as per the task on Open-org.com
 *  http://forum.open-org.com/q10/
 */

function init(){
  session_start();
  // Load and initialise modules.
  include_once "modules/question.php";
  menu_add_menu(Question::menu(), 'Question');
  if (!isset($_REQUEST['q'])) {
    $_REQUEST['q'] = '/index';
  }
}

/**
 * return current menu path
 */
function get_current_path() {
  global $_path;
  return $_path;
}

/**
 * copyright text
 */
function copyright() {
  return 'Copyright 2012 ' . t('logo text');
}
