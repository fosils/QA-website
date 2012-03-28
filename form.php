<?php

define('QUESTION_FORM_FIELD', 'question');
define('HASH_FORM_FIELD', 'hash');
define('EMAIL_FORM_FIELD', 'email');
define('NAME_FORM_FIELD', 'name');
define('PHONE_FORM_FIELD', 'phone');
define('STEP_FORM_FIELD', 'step');
//incase translation is required
//default language file languageGB.php
function translate($word, $lang_code = 'GB'){
  static $language;
  if ($language === NULL){
    @include_once './language' . $lang_code . '.php';
    if($language === NULL){
      $language = array();
    }
  }
  if (array_key_exists($word, $language)){
    return $language[$word];
  }
  return $word;
}
//send mail to mrdavidandersen
function email($message, $subject = 'Paid Q&A'){
  mail('mrdavidandersen@gmail.com', $subject, $message);
}

//get the user message and send
function process_step1(){
  if (isset($_REQUEST[QUESTION_FORM_FIELD])){
    $content = $_REQUEST[QUESTION_FORM_FIELD];
    if ($content != ''){
      session_set_form_hash($content);
      email($content, 'Paid Q&A ' . session_get_form_hash());
      return true;
    }
  }
  return false;
}

function process_step2(){
  if (isset($_REQUEST[HASH_FORM_FIELD])){
    if (session_set_current_hash($_REQUEST[HASH_FORM_FIELD])){
      $email = $_REQUEST[EMAIL_FORM_FIELD];
      $phone = $_REQUEST[PHONE_FORM_FIELD];
      $name = $_REQUEST[NAME_FORM_FIELD];
      $pay = @$_REQUEST[PAY_READY_FORM_FIELD];
      if($pay){
	$pay = "Client ready pay $60";
	$content = "
	  Name : $name
	  Email : $email
	  Phone : $phone
          Pay : $pay
";
	/**
	 * Gmail groups the mails by Subject
	 */
	email($content, 'Paid Q&A ' . session_get_form_hash());
      }
      return true;
    }
  }
  return false;
}
/**
 * Start processing
 */
session_start();
if (isset($_REQUEST[STEP_FORM_FIELD])){
  $step = (int) $_REQUEST[STEP_FORM_FIELD];
  switch ($step){
  case 1:
    if (process_step1() === FALSE){
      $step = 0;
    }
    break;
  case 2:
    if (process_step2() === FALSE){
      $step = 0;
    }
    break;
  default:
    $step = 0;
  }
}

function session_set_form_hash($content){
  $hash = md5($content);
  if (!isset($_SESSION['QA'])){
    $_SESSION['QA'] = array('available'=>array());
  }
  $_SESSION['QA']['current'] = $hash;
  $_SESSION['QA']['available'][$hash] = 1;
}

function session_get_form_hash(){
  return @$_SESSION['QA']['current'];
}

function session_set_current_hash($hash){
  if (array_key_exists($hash, $_SESSION['QA']['available'])){
    $_SESSION['QA']['current'] = $hash;
    return TRUE;
  }
  return FALSE;
}
//include theme file;
include 'theme.php';
