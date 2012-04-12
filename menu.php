<?php
/**
 * @file
 * Menu handling functions
 *
 * Copyright @ Open-org.com, all rights reserved
 *
 */

$_menu = array(
  'submenu' => array(),
  'menu' => array(
    'module' => 'Question',
    // Set default path to default front page menu.
    'path' => '/question',
    'title' => 'q1',
  ),
);
$_menu_alias = array();

/**
 * get menu for a path
 *
 * @param string $menu
 *   menu path
 */
function menu_get_menu_from_path($menu) {
  global $_menu;
  $menu = explode("/", $menu);
  array_shift($menu);
  $parent = $_menu;
  foreach ($menu as $item) {
    if (array_key_exists($item, $parent['submenu'])) {
      $parent = $parent['submenu'][$item];
    }
    else {
      return $parent['menu'];
    }
  }
  return $parent['menu'];
}
/**
 * get menu entry for aliase
 *
 * @param string $alias
 *   menu path
 *
 * @return string
 *   menu path
 */
function menu_alias_to_path($alias) {
  global $_menu;
  global $_menu_alias;
  if (array_key_exists($alias, $_menu_alias)) {
    $path = $_menu_alias[$alias];
    if (array_key_exists($path, $_menu)) {
      return $path;
    }
  }
  else {
    $menu = menu_get_menu_from_path($alias);
    return $menu['path'];
  }
}

/**
 * get handling module name for a menu
 *
 * @param string $menu
 *   menu path
 */
function menu_get_module_name($menu) {
  global $_menu;
  if (array_key_exists($menu, $_menu)) {
    return $_menu[$menu]['module'];
  }
  $menu = menu_get_menu_from_path($menu);
  return $menu['module'];
}

/**
 * Insert new menu Item
 *
 * @param array $menu
 *   menu defenition
 * @param string $module
 *   module to handle the menu
 *
 */
function menu_add_menu($menu, $module) {
  global $_menu;
  foreach ($menu as $key => $item) {
    $keys = explode('/', $key);
    array_shift($keys);
    $parent = &$_menu;
    $path = '';
    foreach ($keys as $value) {
      $path .= '/' . $value;
      if (!array_key_exists($value, $parent['submenu'])) {
        $parent['submenu'][$value] = array(
          'submenu' => array(),
          'menu' => array(
            'module' => $module,
            'path' => $path,
          ),
        );
      }
      $parent = &$parent['submenu'][$value];
    }
    $parent['menu'] += $item;
  }
}

/**
 * Add menu alias
 *
 * @param string $menu
 *   menu path
 * @param string $alias
 *   menu alias
 */
function menu_add_alias($menu, $alias) {
  global $_menu_alias;
  $current = menu_get_menu_from_path($menu);
  if ($current['path'] == $menu) {
    $_menu_alias[$alias] = $menu;
    return TRUE;
  }
  return FALSE;
}

/**
 * Function get menu_aliase($menu)
 *
 * @param string $menu
 *   menu path
 *
 * @return string
 *   menu aliase if one exists
 */
function get_menu_alias($menu) {
  global $_menu_aliase;
  $ret = array_search($menu, $_menu_aliase);
  if ($ret) {
    return $ret;
  }
  return $menu;
}

/**
 * Function menu get Title
 *
 * @param string $menu
 *   menu path
 *
 * @return string
 *   the title of menu item
 */
function menu_get_title($menu) {
  $menu = menu_get_menu_from_path($menu);
  return $menu['title'];
}

/**
 * Creat tab menu
 *
 */
function menu_tab($args, $menus = NULL) {
  $args += array(
    'class' => '',
    'active' => '',
    'has_submenu' => '',
  );
  if (empty($menus)) {
    $menus = array(
      '/index' => array(
        'text' => t('q1'),
      ),
      '/question' => array(
        'text' => t('q2'),
      ),
    );
  }
  $ret = array();
  foreach ($menus as $key => $menu) {
    $attr = array($args['class']);
    if (get_current_path() == $key) {
      $attr[] = $args['active'];
    }
    $item = $menu['text'];
    if (isset($menu['children'])) {
      $attr[] = $args['has_submenu'];
      $item .= menu_tab($args, $menu['children']);
    }
    $ret[] = '<li class="' . implode(" ", $attr) . '"><span><a href="./index.php?q=' . $key . '">' . $item . '</a></span></li>';
  }
  return '<ul class="menu">' . implode("\n", $ret) . '</ul>' ;
}
