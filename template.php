<?php
/**
 * @file
 * Template class for QA website
 *
 * Copyright @ Open-org.com, All rights reserved
 * Created as per the task on Open-org.com
 *  http://forum.open-org.com/q10/
 */

defined('OPEN_ORG_INIT') OR die('RESTRICTED ACCESS');

class Template {

  /**
   * Constructor
   *
   * @param string $template
   *   The template file name
   */
  function __construct($template) {
    $this->template = $template;
  }

  /**
   * return the output of template
   */
  function output() {
    $file = TEMPLATE_DIRECTORY . DS . $this->template . TEMPLATE_EXTENTION;
    $content = '';
    if (file_exists($file)) {
      // Allow any php codes in template to execute.
      ob_start();
      include $file;
      $content = ob_get_clean();
      // Replace function mappings.
      $content = preg_replace_callback('/<{{([a-zA-Z0-9,:_ ]+)}}>/', array($this, 'replaceFunction'), $content);
      // Replace defined constants.
      $content = preg_replace_callback('/<C{{([A-Z_]+)}}>/', array($this, 'replaceConstant'), $content);
      // Replace the translation strings.
      $content = preg_replace_callback('/{{([a-zA-Z0-9 ]+)}}/', array($this, 'translate'), $content);
    }
    else {
      throw new Exception("The file " . $file . " Not fount");
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
    if (!function_exists($function)) {
      return '';
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
    $ret = call_user_func_array($function, $nonamearg);
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
   * Callback for handling translation
   */
  function translate($data) {
    if (isset($data[1])) {
      return t($data[1]);
    }
    return '';
  }
}
