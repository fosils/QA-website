<?php
/**
 * @file
 * define language and translation functions.
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

/**
 * Translation function
 *
 * @param string $word
 *   word to translate
 * @param array $data
 *   array of values to replace from the translated string.
 *   for readability and to minimise side effects,
 *   append '@' before variable names in string to translate
 */
function t($word, $data = array()) {
  global $language;
  $ret = $word;
  if (empty($language)) {
    $language = array();
  }
  if (array_key_exists($word, $language)) {
    $ret = $language[$word];
  }
  /*
   * translation is still exact, means the string to translate needs to be in
   *  translation file.
   * but now it allow to put some arbitrary value to translated string
   */
  if (count($data) > 0) {
    return str_replace(array_keys($data), array_values($data), $ret);
  }
  return $ret;
}

include_once LANGUAGE_DIRECTORY . DS . LANGUAGE . '.php';
