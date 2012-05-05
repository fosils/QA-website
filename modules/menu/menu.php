<?php
/**
 * @file
 * Menu Handler
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

namespace Module;

class Menu extends \Module {
  /**
   * @var array
   */
  protected $menu = array();
  protected $alias = array();
  /**
   * Event registration
   */
  function registerEvent() {
    return array(
      'init' => array(
        'callback' => array($this, 'menuHook'),
        // Let this callback called after critical system callbacks
        // like session initialisation.
        'priority' => \Config::NORMAL,
      ),
    );
  }

  /**
   * menu loader
   */
  function menuHook() {
    // Collect menu as defined by modules.
    $menus = $this->conf->propogateEvent('menu', array());
    foreach ($menus as $module => $menu) {
      $this->addMenu($menu, $module);
    }
    // Build menu tree.
    $this->build();
    // Menu alias.
    $aliases = $this->conf->propogateEvent('menuAlias', array());
    foreach ($aliases as $alias) {
      $this->addAlias($alias);
    }
    $request = $this->conf->module('Request');
    $query = $request->query();
    if ($query === NULL) {
      $query = '/index';
    }
    $this->query = $this->getMenuFromAlias($query);
  }

  /**
   * Add new menu item
   */
  protected function addMenu($menu) {
    foreach ($menu as $path => $value) {
      if (!array_key_exists($path, $this->menu)) {
        $this->menu[$path] = $value;
      }
      else {
        // Error through exception.
      }
    }
  }

  /**
   * Add menu alias
   */
  protected function addAlias($menu) {
    $this->alias = $menu + $this->alias;
  }

  /**
   * Build menu tree
   */
  function build() {
    // Sort Menu.
    ksort($this->menu);
    $tree = array();
    foreach ($this->menu as $path => $value) {
      $split = explode('/', $path);
      $current = &$tree;
      foreach ($split as $fragment) {
        if ($fragment !== '') {
          if (!array_key_exists($fragment, $current)) {
            $current[$fragment] = array();
          }
          $current = &$current[$fragment];
        }
      }
      if ($current !== $tree) {
        $current['#data'] = $value;
        $current['#path'] = $path;
      }
    }
    $this->tree = $tree;
    unset($this->menu);
  }

  /**
   * get Path from alias.
   */
  function getMenuFromAlias($alias) {
    if (array_key_exists($alias, $this->alias)) {
      $alias = $this->alias[$alias];
    }
    return $this->getMenu($alias);
  }

  /**
   * get Defined path of menu entry
   */
  function getMenu($menu) {
    $split = explode('/', $menu);
    if ($split[0] == '') {
      array_shift($split);
    }
    $current = $this->tree;
    foreach ($split as $fragment) {
      if (array_key_exists($fragment, $current)) {
        $current = $current[$fragment];
      }
      else {
        break;
      }
    }
    if (array_key_exists('#data', $current)) {
      return array('#data' => $current['#data'],'#path' => $current['#path']);
    }
    return NULL;
  }

  /**
   * router
   */
  function route($path) {
    return './?q=' . $path;
  }
}
