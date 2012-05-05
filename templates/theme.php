<?php
/**
 * @file
 * Theme base file
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

class Theme {
  /**
   * construct
   */
  function __construct($conf) {
    $this->conf = $conf;
  }

  /**
   * return blocks this theme supports
   */
  function blocks() {
    return array(
      'htmlscript' => TRUE,
      'htmlstyle' => TRUE,
      'script' => TRUE,
      'stylesheet' => TRUE,
      'content' => 'content',
    );
  }

  /**
   * render a page
   *
   * @param array $blocks
   *   assosiative array of blocks content.
   */
  function page($blocks) {
    $theme_path = $this->conf->template->getThemePath();
    foreach ($blocks as $block => $data) {
      $function = 'renderBlock' . ucfirst($block);
      $file = $theme_path . 'block_' . $block . TEMPLATE_EXTENTION;
      // Use wrapper function for block if it exists.
      if (method_exists($this, $function)) {
        $data = $this->$function($data);
      }
      // Use wrapper file for block if it exists.
      elseif (file_exists($file)) {
        $data = $this->conf->template->loadThemeFile($file, $data);
      }
      // Use generic wrapper function.
      elseif (method_exists($this, 'renderBlock')) {
        $data = $this->renderBlock($data);
      }
      // Use generic wrapper file.
      elseif (file_exists($theme_path . 'block' . TEMPLATE_EXTENTION)) {
        $data = $this->conf->template->loadThemeFile($file, $data);
      }
      if (is_array($data)) {
        $blocks[$block] = implode("\n", $data);
      }
      else {
        $blocks[$block] = $data;
      }
    }
    $ret = $blocks;
    if (method_exists($this, 'renderPage')) {
      $ret = $this->renderPage($blocks);
    }
    elseif (file_exists($theme_path . 'page' . TEMPLATE_EXTENTION)) {
      $ret = $this->conf->template->loadThemeFile($theme_path . 'page' . TEMPLATE_EXTENTION, $blocks);
    }
    else {
      // Page formation is impossible.
    }
    if (is_array($ret)) {
      return implode('', $ret);
    }
    return $ret;
  }

  /**
   * Render Stylesheets
   */
  function renderBlockStylesheet($vars) {
    $ret = array();
    foreach ($vars as $vals) {
      $url = explode("://", $vals[0]);
      $module = $vals[1];
      $type = $vals[2];
      $schema = NULL;
      if (count($url) > 1) {
        $schema = array_shift($url);
      }
      $url = implode("://", $url);
      if ($schema === NULL) {
        $url = $this->getPath($url, $module);
        if ($url === NULL) {
          continue;
        }
      }
      $ret[] = '<link rel="stylesheet" type="' . $type . '" href="' . $url . '" />';
    }
    return implode("\n", $ret);
  }

  /**
   * Render Script urls
   */
  function renderBlockScript($vars) {
    $ret = array();
    foreach ($vars as $vals) {
      $url = explode("://", $vals[0]);
      $module = $vals[1];
      $type = $vals[2];
      $language = $vals[3];
      $schema = NULL;
      if (count($url) > 1) {
        $schema = array_shift($url);
      }
      $url = implode("://", $url);
      if ($schema === NULL) {
        $url = $this->getPath($url, $module);
        if ($url === NULL) {
          continue;
        }
      }
      else {
        $url = $schema . '://' . $url;
      }
      $ret[] = '<script type="' . $type . '" language="' . $language . '" src="' . $url . '" /></script>';
    }
    return implode("\n", $ret);
  }

  /**
   * Get path of the file.
   */
  function getPath($file, $module) {
    static $theme_path = NULL;
    static $theme_url = NULL;
    static $module_path = array();
    static $module_url = array();
    $url = str_replace(DS, '/', $file);
    if ($theme_path === NULL) {
      $theme_path = $this->conf->template->getThemePath();
      $theme_url = $this->conf->template->getThemeUrl();
    }
    if ($module === NULL) {
      if (file_exists($theme_path . $file)) {
        return $theme_url . $url;
      }
    }
    else {
      if (!array_key_exists($module, $module_path)) {
        $module_path[$module] = \Module::ModulePath($module);
        $module_url[$module] = \Module::ModuleUrl($module);
      }
      if (file_exists($theme_path . 'modules' . DS . $module . DS . $file)) {
        return $theme_url . 'modules/' . $module . '/' . $file;
      }
      elseif (file_exists($module_path[$module] . $file)) {
        return $module_url[$module] . $url;
      }
    }
    return NULL;
  }
}
