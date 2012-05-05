<?php
/**
 * @file
 * Template class for QA website
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

class Template {
  /**
   * @var
   */
  protected $theme;
  protected $conf;
  protected $loaded = FALSE;
  protected $blocks = array();
  protected $blockdata = array();
  protected $title = '';
  /**
   * Constructor
   *
   * @param \Config $conf
   *   configuration Object.
   * @param string $theme
   *   The name of theme.
   */
  function __construct($conf, $theme) {
    $this->theme = $theme;
    $this->conf = $conf;
  }

  /**
   * set Current theme
   */
  function setTheme($theme) {
    if ($this->loaded) {
      return FALSE;
    }
    $this->theme = $theme;
  }

  /**
   * Load theme
   */
  function load() {
    if (!$this->loaded) {
      if (!($this->loaded = $this->conf->loadTheme($this->theme))) {
        // Error exception.
      }
    }
    return TRUE;
  }

  /**
   * The theming function
   * theam allow either theme function, html-php file defined in theme folder,
   *  module function or html-php file defined in module to generate the output.
   */
  function theme($module, $template, $variables) {
    if (!$this->loaded) {
      $this->load();
    }
    // Final Override: search for theme file in theme folder.
    $themepath = $this->getThemePath();
    $themefile = $this->themeFile($module, $template, $themepath);
    if (file_exists($themefile)) {
      return $this->loadThemeFile($themefile, $variables);
    }
    // Second Override:  search for theme override of module implementation.
    $theme = $this->theme;
    $callable = array($theme, $this->themeFunction($module, $template));
    if (is_callable($callable)) {
      return call_user_func_array($callable, array($variables));
    }
    // First Override:  search for module defined theme file.
    $module_path = \Module::modulePath($module);
    $module_theme_file = $this->moduleThemeFile($template, $module_path);
    if (file_exists($module_theme_file)) {
      return $this->loadThemeFile($module_theme_file, $variables);
    }
    // Default: search for module defined theme function.
    $object = $this->conf->module($module);
    $callable = array($object, $this->moduleThemeFunction($template));
    if (is_callable($callable)) {
      return call_user_func_array($callable, array($variables));
    }
    return '';
  }

  /**
   * Get the theme path
   */
  function getThemePath() {
    $theme = $this->theme;
    $split = explode('\\', $theme);
    $dir = TEMPLATE_PATH . DS;
    foreach ($split as $name) {
      $name = strtolower($name);
      $dir .= $name . DS;
    }
    return $dir;
  }

  /**
   * get the theme url
   */
  function getThemeUrl() {
    $theme = $this->theme;
    $split = explode('\\', $theme);
    $path = TEMPLATE_URL;
    foreach ($split as $name) {
      $name = strtolower($name);
      $path .= '/' . $name;
    }
    return $path . '/';
  }

  /**
   * Get the theme file
   */
  function themeFile($module, $template, $path) {
    return $path . strtolower($module) . DS . $template . TEMPLATE_EXTENTION;
  }

  /**
   * Module defined theme file
   */
  function moduleThemeFile($template, $path) {
    return $path . 'theme' . DS . $template . TEMPLATE_EXTENTION;
  }

  /**
   * theme function
   */
  function themeFunction($module, $template) {
    return strtolower($module) . ucfirst($template);
  }

  /**
   * Module defined theme function
   */
  function moduleThemeFunction($template) {
    return 'theme' . ucfirst($template);
  }

  /**
   * Add block data to template
   */
  function addBlock($name, $data) {
    if (!$this->loaded) {
      $this->load();
    }
    if (empty($this->blocks)) {
      $this->blocks = $this->conf->theme->blocks();
      foreach ($this->blocks as $block => $status) {
        if ($status) {
          $this->blockdata[$block] = array();
        }
      }
    }
    if (array_key_exists($name, $this->blockdata)) {
      $this->blockdata[$name][] = $data;
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Set Title
   */
  function setTitle($title) {
    $this->title = $title;
  }

  /**
   * Loads theme classes
   */
  static function loadClass($names = array()) {
    if (count($names) > 0) {
      $dir = TEMPLATE_PATH . DS ;
      foreach ($names as $name) {
        $name = strtolower($name);
        $dir .= $name . DS;
      }
      $file = $dir . 'theme' . TEMPLATE_EXTENTION;
      if (file_exists($file)) {
        include_once $file;
      }
    }
  }

  /**
   * dispatch function
   */
  function dispatch() {
    return $this->conf->theme->page($this->blockdata);
  }

  /**
   * Add script declarations
   */
  function addScript($script) {
    $this->addBlock('htmlscript', $script);
  }

  /**
   * Add style declarations
   */
  function addStyle($style) {
    return $this->addBlock('htmlstyle', $style);
  }

  /**
   * Add script url
   */
  function addScriptTag($url, $module = NULL, $type = "text/javascript", $language = "javascript") {
    return $this->addBlock('script', array($url, $module, $type, $language));
  }

  /**
   * Add stylesheet
   */
  function addStylesheet($url, $module = NULL, $type = "text/css") {
    return $this->addBlock('stylesheet', array($url, $module, $type));
  }

  /**
   * Load the theme file so that it will get the template as $this
   */
  function loadThemeFile($__template_vars_path, $__template_vars_variables) {
    foreach ($__template_vars_variables as $__template_prop_name => $__template_prop_value) {
      ${$__template_prop_name} = $__template_prop_value;
    }
    ob_start();
    include $__template_vars_path;
    return ob_get_clean();
  }

  /**
   * return the output of template
   */
  function output($module = NULL) {
    $this->module = $module;
    $this->file = TEMPLATE_DIRECTORY . DS . $this->template . TEMPLATE_EXTENTION;
    if (file_exists($this->file)) {
      // Allow any php codes in template to execute.
      ob_start();
      include $this->file;
      $content = ob_get_clean();
      // Replace defined variables.
      $content = preg_replace_callback('/<\${{([a-z_]+)}}>/', array($this, 'replaceVariable'), $content);
      // Replace function mappings.
      $content = preg_replace_callback('/<{{([a-zA-Z0-9,:_ ]+)}}>/', array($this, 'replaceFunction'), $content);
      // Replace defined constants.
      $content = preg_replace_callback('/<C{{([A-Z_]+)}}>/', array($this, 'replaceConstant'), $content);
      // Replace the translation strings.
      $content = preg_replace_callback('/{{([\$a-zA-Z0-9 ]+)}}/', array($this, 'translate'), $content);
    }
    else {
      throw new Exception("The file " . $this->file . " Not fount");
    }
    return $content;
  }

  /**
   * Call back hanldler for handling functions in template
   */
  function replaceFunction($data) {
    if (!isset($data[1])) {
      return '';
    }
    $args = explode(",", $data[1]);
    $function = array_shift($args);
    $callback = array($this->module, $function);
    if (!method_exists($this->module, $function)) {
      $callback = $function;
      if (!function_exists($function)) {
        return '';
      }
    }
    $namedarg = array();
    $nonamearg = array();
    foreach ($args as $arg) {
      $arg = trim($arg);
      $tokens = explode(":", $arg);
      if (count($tokens) > 1) {
        $namedarg[$tokens[0]] = $tokens[1];
      }
      else {
        $nonamearg[] = $arg;
      }
    }
    if (count($namedarg) > 0) {
      $nonamearg[] = $namedarg;
    }
    $ret = call_user_func_array($callback, $nonamearg);
    if ($ret !== FALSE) {
      return $ret;
    }
    return '';
  }

  /**
   * Callback for handling constants
   */
  function replaceConstant($data) {
    if (isset($data[1]) && defined($data[1])) {
      return constant($data[1]);
    }
    return '';
  }

  /**
   * Callback for handling variables
   */
  function replaceVariable($data) {
    if (isset($data[1])) {
      if (array_key_exists($data[1], $this->variables)) {
        return $this->variables[$data[1]];
      }
      if (array_key_exists('_' . $data[1], $GLOBALS)) {
        if (is_string($GLOBALS['_' . $data[1]])) {
          return $GLOBALS['_' . $data[1]];
        }
      }
    }
    return '';
  }

  /**
   * Set template Variable
   */
  function setVariable($name, $value) {
    if (!isset($this->variables)) {
      $this->variables = array();
    }
    $this->variables[$name] = $value;
  }

  /**
   * Callback for handling translation
   */
  function translate($data) {
    if (isset($data[1])) {
      return t($data[1]);
    }
    return '';
  }
}
