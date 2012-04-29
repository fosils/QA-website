<?php
/**
 * @file
 * session handling
 */

/**
 * get form hash
 *
 * @param string $content
 *   content for generating the hash.
 *
 * @return boolean
 *   TRUE for new content, and FALSE for existing content
 */
function session_set_form_hash($content) {
  $hash = md5(session_id() . $content);
  $ret = TRUE;
  if (!isset($_SESSION['QA'])) {
    $_SESSION['QA'] = array('available' => array());
  }
  elseif ($_SESSION['QA']['current'] == $hash) {
    $ret = FALSE;
  }
  $_SESSION['QA']['current'] = $hash;
  $_SESSION['QA']['available'][$hash] = 1;
  return $ret;
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

/**
 * set variable
 */
function session_set($name, $value) {
  $_SESSION[$name] = $value;
}

/**
 * get variable
 */
function session_get($name, $default = NULL) {
  if (isset($_SESSION[$name])) {
    return $_SESSION[$name];
  }
  return $default;
}
