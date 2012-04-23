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
   * @var array
   */
  public $deadlines = array(
    '0' => 'Please Select',
    '1' => '1 Day',
    '2' => '2 Days',
    '3' => '3 Days',
    '4' => '4 Days',
    '5' => '5 Days',
    '10' => '10 Days',
    '15' => '15 Days',
    '20' => '20 Days',
    '25' => '25 Days',
  );
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
    global $_name, $_email, $_question, $_deadline;
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
    elseif (isset($this->step) && $this->step == 'success') {
      if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
        $GLOBALS['_name'] = $_SESSION['name'];
        $GLOBALS['_email'] = $_SESSION['email'];
        $GLOBALS['_question'] = $_SESSION['question'];
        $GLOBALS['_deadline'] = $_SESSION['deadline'];
        $step = "success";
        $content = "
      Status: Payment Confirmed
      Name : $_name
      Email : $_email
      Deadline: $_deadline Day(s)
      Question : $_question
";
        $this->email($content, 'Paid Q&A ' . session_get_form_hash());
        unset($_SESSION['name']);
      }
    }
    $template_file = 'question_' . $step;
    $template = new Template($template_file);
    echo $template->output($this);
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
        $_SESSION['question'] = $content;
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
        // $phone = $_REQUEST[PHONE_FORM_FIELD];
        $name = $_REQUEST[NAME_FORM_FIELD];
        $deadline = $_REQUEST[DEADLINE_FORM_FIELD];
        $question = $_SESSION['question'];
        $content = "
      Status: Payment pending
      Name : $name
      Email : $email
      Deadline: $deadline Day(s)
      Question : $question
";
        // Gmail groups the mails by Subject.
        $this->email($content, 'Paid Q&A ' . session_get_form_hash());
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['deadline'] = $deadline;
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Creating deadline options
   */
  function deadlineOptions() {
    $ret = array();
    foreach ($this->deadlines as $key => $value) {
      $ret[] = '<option value="' . $key . '">' . $value . '</option>';
    }
    return implode("\n", $ret);
  }
}
