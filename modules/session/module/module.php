<?php
/**
 * @file
 * session data handler for modules
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

namespace Module\Session;

class Module {
  /**
   * @var
   */
  protected $data = array();
  protected $name = '';

  /**
   * constructor
   */
  function __construct($name) {
    $this->name = $name;
    $this->data = &$_SESSION['modules'][$name];
  }

  /**
   * getter
   */
  function __get($name) {
    // exit($name);
    if (array_key_exists($name, $this->data)) {
      return $this->data[$name];
    }
    return NULL;
  }

  /**
   * Setter
   */
  function __set($name, $value) {
    $this->data[$name] = $value;
  }

  /**
   * generic get method
   */
  function get($name, $default = NULL) {
    $ret = $this->__get($name);
    if ($ret === NULL) {
      return $default;
    }
    return $ret;
  }
}
