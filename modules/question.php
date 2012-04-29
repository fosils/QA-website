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
  public $deadlines = array();

  /**
   * Constructor
   */
  function __construct() {
    $this->deadlines = array(
      '1' => t('@day day', array('@day' => 1)),
      '2' => t('@day days', array('@day' => 2)),
      '3' => t('@day days', array('@day' => 3)),
      '4' => t('@day days', array('@day' => 4)),
      '7' => t('@day week', array('@day' => 1)),
      '14' => t('@day weeks', array('@day' => 2)),
      '21' => t('@day weeks', array('@day' => 3)),
      '30' => t('@day month', array('@day' => 1)),
    );
  }

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
      // Allow browser to cache the form for 10 min.
      header("Cache-Control: max-age=600\r\n");
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
      $_name = session_get('name');
      $_email = session_get('email');
      if (isset($_name) && isset($_email)) {
        $_question = session_get('question');
        $_deadline = session_get('deadline');
        $step = "success";
        $content = "
      Status: Payment Confirmed
      Name : $_name
      Email : $_email
      Deadline: $_deadline Day(s)
      Question : $_question
";
        $this->email($content, 'Paid Q&A ' . session_get_form_hash());
        $this->clearSessionData();
      }
    }
    $template_file = 'question_' . $step;
    $template = new Template($template_file);
    $template->setVariable('question', session_get('question', t('write question here')));
    $template->setVariable('name', session_get('name', ''));
    $template->setVariable('email', session_get('email', ''));
    // Default value of deadline set to 14 days.
    $template->setVariable('deadline', session_get('deadline', 14));
    echo $template->output($this);
  }

  /**
   * get the user message and send
   */
  function processStep1() {
    if (isset($_REQUEST[QUESTION_FORM_FIELD])) {
      $content = $_REQUEST[QUESTION_FORM_FIELD];
      if ($content != '') {
        // Do not send email if it send already.
        if (session_set_form_hash($content)) {
          $this->email($content, 'Paid Q&A ' . session_get_form_hash());
          session_set('oldquestion', FALSE);
          session_set('question', $content);
        }
        else {
          session_set('oldquestion', TRUE);
        }
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
        $question = session_get('question');
        if (session_get('oldquestion', FALSE) && session_get('name') === $name
          && session_get('email') === $email && session_get('deadline') === $deadline) {
          // Do nothing, the information is already send.
        }
        else {
          $content = "
      Status: Payment pending
      Name : $name
      Email : $email
      Deadline: $deadline Day(s)
      Question : $question
";
          // Gmail groups the mails by Subject.
          $this->email($content, 'Paid Q&A ' . session_get_form_hash());
          session_set('name', $name);
          session_set('email', $email);
          session_set('deadline', $deadline);
          // Do not send email next time user click the pay button.
          session_set('oldquestion', TRUE);
        }
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Creating deadline options
   */
  function deadlineOptions($default) {
    $default = (int) $default;
    $ret = array();
    foreach ($this->deadlines as $key => $value) {
      $ret[] = '<option value="' . $key . '"' . (($key == $default) ? ' selected = "true"' : '') . '>' . $value . '</option>';
    }
    return implode("\n", $ret);
  }

  /**
   * Clear session data
   */
  fUnction clearSessionData() {
    session_set('name', NULL);
    session_set('email', NULL);
    session_set('question', NULL);
    session_set('deadline', NULL);
  }
}
