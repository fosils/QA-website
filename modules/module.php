<?php
/**
 * @file
 * Module base class
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

class Module {
  /**
   * contructor
   */
  function __construct($conf) {
    $this->conf = $conf;
  }

  /**
   * Loads module classes
   */
  static function loadClass($names = array()) {
    if (count($names) > 0) {
      $dir = MODULE_PATH . DS ;
      foreach ($names as $name) {
        $name = strtolower($name);
        $dir .= $name . DS;
      }
      $file = $dir . strtolower($name) . MODULE_EXTENSION;
      if (file_exists($file)) {
        include_once $file;
      }
    }
  }

  /**
   * Module path
   */
  static function modulePath($module) {
    $split = explode('\\', $module);
    $dir = MODULE_PATH . DS ;
    foreach ($split as $name) {
      $name = strtolower($name);
      $dir .= $name . DS;
    }
    return $dir;
  }

  /**
   * Module url
   */
  static function moduleUrl($module) {
    $split = explode('\\', $module);
    $path = MODULE_URL ;
    foreach ($split as $name) {
      $name = strtolower($name);
      $path .= '/' . $name;
    }
    return $path . '/';
  }
}
