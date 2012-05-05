<?php
/**
 * @file
 * Session handling
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

namespace Module;

class Session extends \Module {
  /**
   * Register
   */
  function registerEvent() {
    return array(
      'init' => array(
        'callback' => array($this, 'init'),
        'order' => \config::FIRST,
      ),
    );
  }

  /**
   * Session Initialisation
   */
  function init() {
    session_start();
  }

  /**
   * get Module data
   */
  function __get($name) {
    if (isset($_SESSION)) {
      if (!array_key_exists('modules', $_SESSION)) {
        $_SESSION['modules'] = array();
      }
      if (!array_key_exists($name, $_SESSION['modules'])) {
        $_SESSION['modules'][$name] = array();
      }
      return new Session\Module($name);
    }
    return NULL;
  }
}
