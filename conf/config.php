<?php
/**
 * @file
 * Configuration for Open-Org web framework.
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

class Config {
  /**
   * @constant INT
   */
  const FIRST = -10;
  const NORMAL = 0;
  const LAST = 10;
  /**
   * @var
   */
  public $site;
  /**
   * @var array
   */
  protected $moduleList = array();
  /**
   * Class constructor.
   *
   */
  protected function __construct() {
    // Register autoloader for modules.
    spl_autoload_register(array($this, 'classLoad'));
    // Load site information.
    $sites = array();
    include 'sites.php';
    $domain = $_SERVER['HTTP_HOST'];
    $siteconf = $sites['default'];
    if (array_key_exists($domain, $sites)) {
      $siteconf = $sites[$domain] + $siteconf;
    }
    $this->site = $siteconf;
    // Load all enabled modules and register callbacks.
    foreach ($siteconf['modules'] as $module) {
      $this->loadModule($module);
    }
    // Initialise template system.
    $this->template = new \Template($this, $siteconf['theme']);
  }

  /**
   * Load module and register callback.
   */
  function LoadModule($module) {
    if (array_key_exists($module, $this->moduleList)) {
      return;
    }
    $class = '\\Module\\' . $module;
    $object = new $class($this);
    $this->moduleList[$module] = $object;
    if (is_callable(array($object, 'registerEvent'))) {
      $events = $object->registerEvent();
      foreach ($events as $event => $callback) {
        if (!isset($this->event[$event])) {
          $this->event[$event] = array();
        }
        $this->event[$event][$module] = $callback;
        // Sort event based on priority.
      }
    }
  }

  /**
   * Load theme
   */
  function loadTheme($name) {
    if (empty($this->theme)) {
      $theme = '\\Theme\\' . $name;
      $this->theme = new $theme($this);
    }
    if (get_class($this->theme) == $name) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Return module object
   *
   * @param string $module
   *   Name of module.
   *
   * @return object
   *   the module object
   */
  function module($module) {
    if (array_key_exists($module, $this->moduleList)) {
      return $this->moduleList[$module];
    }
    return NULL;
  }

  /**
   * Event propogation.
   */
  function propogateEvent($event, $args) {
    $ret = array();
    if (isset($this->event[$event])) {
      if (!array_key_exists('#sorted', $this->event[$event])) {
        self::positionSort($this->event[$event]);
        $this->event[$event]['#sorted'] = TRUE;
      }
      foreach ($this->event[$event] as $module => $callback) {
        if ($module === '#sorted') {
          continue;
        }
        $ret[$module] = call_user_func_array($callback['callback'], $args);
      }
    }
    return $ret;
  }

  /**
   * Autoloader for modules and themes
   *
   * @param string $name
   *   Class name to load.
   */
  protected function classLoad($name) {
    // File names are lowercase.
    $split = explode('\\', $name);
    $type = array_shift($split);
    switch ($type) {
      case 'Module':
        \Module::loadClass($split);
        break;

      case 'Theme':
        \Template::loadClass($split);
        break;
    }
  }

  /**
   * static object invocation
   */
  public static function getInstance() {
    static $object;
    if (empty($object)) {
      $object = new self();
    }
    return $object;
  }

  /**
   * sort array with respect to position
   */
  static function positionSort(&$array) {
    uasort($array,
      function($a, $b) {
        return (isset($a["position"]) ? $a["position"] : Config::NORMAL) > (isset($b["position"]) ? $b["position"] : Config::NORMAL);
      }
          );
  }
}
