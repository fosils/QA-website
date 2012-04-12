<?php
/**
 * @file
 * session handling
 */

/**
 * get form
 */
function session_set_form_hash($content) {
  $hash = md5($content);
  if (!isset($_SESSION['QA'])) {
    $_SESSION['QA'] = array('available' => array());
  }
  $_SESSION['QA']['current'] = $hash;
  $_SESSION['QA']['available'][$hash] = 1;
}

/**
 * get form hash
 */
function session_get_form_hash() {
  return @$_SESSION['QA']['current'];
}

/**
 * session_get_current_hash
 */
function session_set_current_hash($hash) {
  if (array_key_exists($hash, $_SESSION['QA']['available'])) {
    $_SESSION['QA']['current'] = $hash;
    return TRUE;
  }
  return FALSE;
}
