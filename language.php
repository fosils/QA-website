<?php
/**
 * @file
 * define language
 *
 * copyright @ Open-org.com all rights reserved.
 */

/**
 * Translation function
 */
function t($word) {
  global $language;
  if (empty($language)) {
    $language = array();
  }
  if (array_key_exists($word, $language)) {
    return $language[$word];
  }
  return $word;
}

include_once LANGUAGE_DIRECTORY . DS . LANGUAGE . '.php';
