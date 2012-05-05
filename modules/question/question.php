<?php

/**
 * @file
 * To handle questions
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

namespace Module;

class Question extends \Module {
  /**
   * @constats
   */
  const QUESTION_FIELD = 'question';
  const NAME_FIELD = 'name';
  const EMAIL_FIELD = 'email';
  const DEADLINE_FIELD = 'deadline';
  const COMPLEXITY_FIELD = 'complexity';
  /**
   * @var array
   *   deadline options in days.
   */
  public $deadlines = array();

  /**
   * @var array
   *   Question complexity options.
   */
  public $complexity = array();

  /**
   * @var string
   *   mail body
   */
  protected $mail = "
Status: %status%
Name : %name%
Email : %email%
Deadline: %deadline%
Complexity: %complexity%
Question : 
%question%
";
  /**
   * Constructor
   */
  function __construct($conf) {
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
    $this->complexity = array(
      'easy' => t('combobox simple question'),
      'complex' => t('combobox question'),
      'advice' => t('combobox complex question'),
    );
    parent::__construct($conf);
  }

  /**
   * Register event
   */
  function RegisterEvent() {
    return array(
      'menu' => array(
        'callback' => array($this, 'menu'),
        'position' => \config::NORMAL,
      ),
      'menuAlias' => array(
        'callback' => array($this, 'menuAlias'),
        'position' => \config::FIRST,
      ),
    );
  }

  /**
   * menu initialiser for module
   */
  function menu() {
    return array(
      'question' => array(
        'title' => t('page title'),
        'callback' => array($this, 'questionPage'),
      ),
      'question/register' => array(
        'title' => t('Your details'),
        'callback' => array($this, 'process'),
      ),
      'success' => array(
        'title' => t('Payment Success'),
        'callback' => array($this, 'validatePayment'),
      ),
    );
  }

  /**
   * Register Alias
   */
  function menuAlias() {
    return array(
      '/index' => '/question',
    );
  }

  /**
   * Question Page
   */
  function questionPage() {
    $session = $this->conf->module('Session');
    $request = $this->conf->module('Request');
    $question = $request->get(self::QUESTION_FIELD);
    // If user submited the question validate the question.
    if ($question !== NULL) {
      if ($this->validateQuestion($question)) {
        $this->submitQuestion($question);
      }
    }
    $question = $session->Question->get('question', t('write question here'));
    return $this->conf->template->theme('Question', 'questionPage', array('question' => $question));
  }

  /**
   * Question info
   */
  function process() {
    $session = $this->conf->module('Session');
    $request = $this->conf->module('Request');
    $name = $request->get(self::NAME_FIELD);
    $email = $request->get(self::EMAIL_FIELD);
    $deadline = $request->get(self::DEADLINE_FIELD);
    $complexity = $request->get(self::COMPLEXITY_FIELD);
    $store = $session->Question;
    if ($store->question === NULL) {
      $this->conf->module('Responce')->redirect('question');
    }
    if ($name !== NULL) {
      if ($this->validateProcess($name, $email, $deadline, $complexity)) {
        $this->submitProcess($name, $email, $deadline, $complexity);
      }
    }
    $name = $store->name;
    $email = $store->email;
    $deadline = $store->get('deadline', 14);
    $complexity = $store->get('complexity', 'easy');
    return $this->conf->template->theme('Question', 'processPage', array(
        'name' => $name,
        'email' => $email,
        'deadline' => $deadline,
        'complexity' => $complexity,
      ));
  }

  /**
   * Validation for question page
   */
  function validateQuestion($question) {
    if ($question == '' || $question == t('write question here')) {
      $responce = $this->conf->module('Responce');
      $responce->statusMessage('Invalid question submitted', 'error');
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Validation for process page
   */
  function validateProcess($name, $email, $deadline, $complexity) {
    $responce = $this->conf->module('Responce');
    if ($name == '') {
      $responce->statusMessage('Name required', 'error');
    }
    if (!preg_match('/([^@]+\.)+@([^@]+\.)+/', $email)) {
      $responce->statusMessage('Email is invalid', 'error');
    }
    if (!array_key_exists($deadline, $this->deadlines)) {
      $responce->statusMessage('Deadline is required', 'error');
    }
    if (!array_key_exists($complexity, $this->complexity)) {
      $responce->statusMessage('Please select type of question', 'error');
    }
    if ($responce->errorCount() > 0) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Submit the question
   */
  function submitQuestion($question) {
    $session = $this->conf->module('Session');
    $responce = $this->conf->module('Responce');
    $store = $session->Question;
    if ($store->question != $question) {
      $session->Question->question = $question;
      // Send email.
    }
    $responce->redirect('question/register');
  }

  /**
   * Submit process
   */
  function submitProcess($name, $email, $deadline, $complexity) {
    $session = $this->conf->module('Session');
    $store = $session->Question;
    if ($store->name != $name || $store->email != $email || $store->deadline != $deadline || $store->complexity !== $complexity) {
      $store->name = $name;
      $store->email = $email;
      $store->deadline = $deadline;
      $store->complexity = $complexity;
      // Send Email.
    }
  }

  /**
   * Theme wrapper function for question
   */
  function themeWrapper($content) {
    $this->conf->template->addStylesheet('question.css', 'Question');
    return '<div class="banner"></div>
    <div class="content">
      <div class="contentwrapper">
        <div class="contentwrapper">' . $content . '
        </div>
      </div>
    </div>';
  }

  /**
   * theme function for questionPage
   */
  function themeQuestionPage($variables) {
    $question = $variables['question'];
    // Insert javascript needed.
    $script = "(function($,val){
  $(document).ready(function(){
    $('#" . self::QUESTION_FIELD . "').focus(function(){
      if(this.value == val){
        this.value = '';
      }
    }).focusout(function(){
      if(this.value == ''){
        this.value = val;
      }
    });
  });
})(jQuery, '" . t('write question here') . "');";
    $this->conf->template->addScript($script);
    return $this->themeWrapper('<form method="post"><textarea name="' .
      self::QUESTION_FIELD . '" id="' . self::QUESTION_FIELD . '" cols="45" rows="5" class="searchbox">' .
      $question . '</textarea><input type="submit" value="' . t('Submit') . '" class="submit"></form>');
  }

  /**
   * Create select option list from array
   */
  function selectOptions($data, $default) {
    $ret = array();
    foreach ($data as $key => $value) {
      $ret[] = '<option value="' . $key . '"' . (($key == $default) ? ' selected = "true"' : '') . '>' . $value . '</option>';
    }
    return implode("\n", $ret);
  }

  /**
   * Creating deadline options
   * Template helper.
   */
  function deadlineOptions($default) {
    return $this->selectOptions($this->deadlines, (int) $default);
  }

  /**
   * Question complexity options
   * template helper.
   */
  function complexityOptions($default) {
    return $this->selectOptions($this->complexity, $default);
  }

  /**
   * Create email content
   */
  function emailContent($name, $email, $question, $status, $deadline, $complexity) {
    $keys = array(
      '%status%',
      '%deadline%',
      '%complexity%',
      '%name%',
      '%email%',
      '%question%',
    );
    $values = array(
      $status,
      $deadline,
      $complexity,
      $name,
      $email,
      $question,
    );
    return str_replace($keys, $values, $this->mail);
  }
}
