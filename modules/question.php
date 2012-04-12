<?php

/**
 * @file
 * To handle questions
 *
 * Copyright @ Open-org.com, All rights reserved
 * Created as per the task on Open-org.com
 *  http://forum.open-org.com/q10/
 */

class Question {
  /**
   * menu initialiser for module
   */
  static function menu() {
    return array(
      '/question' => array(
        'title' => t('home'),
      ),
    );
  }

  /**
   * despatch function
   */
  function dispatch() {
    $step = 0;
    if (isset($_REQUEST[STEP_FORM_FIELD])) {
      $step = (int) $_REQUEST[STEP_FORM_FIELD];
      switch ($step) {
        case 1:
          if ($this->processStep1() === FALSE) {
            $step = 0;
          }
          break;

        case 2:
          if ($this->processStep2() === FALSE) {
            $step = 0;
          }
          break;

        default:
          $step = 0;
          break;
      }
    }
    $template_file = 'question_' . $step;
    $template = new Template($template_file);
    echo $template->output();
  }

  /**
   * get the user message and send
   */
  function processStep1() {
    if (isset($_REQUEST[QUESTION_FORM_FIELD])) {
      $content = $_REQUEST[QUESTION_FORM_FIELD];
      if ($content != '') {
        session_set_form_hash($content);
        $this->email($content, 'Paid Q&A ' . session_get_form_hash());
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * send mail to mrdavidandersen
   */
  function email($message, $subject = 'Paid Q&A') {
    mail('mrdavidandersen@gmail.com', $subject, $message);
  }

  /**
   * Process stage 2
   */
  function processStep2() {
    if (isset($_REQUEST[HASH_FORM_FIELD])) {
      if (session_set_current_hash($_REQUEST[HASH_FORM_FIELD])) {
        $email = $_REQUEST[EMAIL_FORM_FIELD];
        $phone = $_REQUEST[PHONE_FORM_FIELD];
        $name = $_REQUEST[NAME_FORM_FIELD];
        $pay = @$_REQUEST[PAY_READY_FORM_FIELD];
        if ($pay) {
          $pay = "Client ready pay $60";
          $content = "
	  Name : $name
	  Email : $email
	  Phone : $phone
          Pay : $pay
";
          // Gmail groups the mails by Subject.
          email($content, 'Paid Q&A ' . session_get_form_hash());
        }
        return TRUE;
      }
    }
    return FALSE;
  }
}
