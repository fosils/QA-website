<?php
/**
 * @file
 * Request module
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

namespace Module;

class Request extends \Module {
  /**
   * return query string.
   */
  function query($q = NULL) {
    $query = NULL;
    if (isset($_GET) && array_key_exists('q', $_GET)) {
      $query = $_GET['q'];
    }
    if ($q !== NULL) {
      $_GET['q'] = $q;
    }
    return $query;
  }

  /**
   * get request
   */
  function get($name, $default = NULL, $method = 'request') {
    $global = &$this->method($method);
    if (isset ($global) && array_key_exists($name, $global)) {
      $value = &$global[$name];
      if (is_string($value)) {
        return trim($value);
      }
      return $value;
    }
    return $default;
  }

  /**
   * available methods for user input
   */
  function method($method) {
    switch ($method) {
      case 'get':
        return $_GET;
        break;

      case 'post':
        return $_POST;
        break;

      case 'request':
        return $_REQUEST;
        break;
    }
    return NULL;
  } 
}
