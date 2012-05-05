<?php
/**
 * @file
 * content handler
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

namespace Module;

class Responce extends \Module {
  /**
   * @var
   */
  protected $allowExtension = TRUE;

  /**
   * @VAR
   */
  protected $headers = array();
  /**
   * Register callback
   */
  function registerEvent() {
    return array(
      'init' => array(
        'callback' => array($this, 'process'),
        'position' => \Config::LAST + 1000,
      ),
    );
  }

  /**
   * process the content creation
   * and invoke template to process the output
   */
  function process() {
    $menu = $this->conf->module('Menu');
    $query = $menu->query;
    $callback = $query['#data']['callback'];
    $content = call_user_func_array($callback, array());
    $this->conf->template->addBlock('content', $content);
    $this->conf->template->setTitle($query['#data']['title']);
    // Allow any output processing function to add data to template;
    if ($this->allowExtension) {
      $this->conf->propogateEvent('content', array($this->conf->template));
    }
    $data = $this->conf->template->dispatch();
    echo $data;
  }

  /**
   * goto some other url
   */
  function redirect($path) {
    $menu = $this->conf->module('Menu');
    $path = $menu->route($path);
    header('Location: ' . $path);
    $this->conf->propogateEvent('exit', array());
    exit;
  }

  /**
   * set status message
   */
  function statusMessage($message, $type = 'info') {
    $this->status[] = array('message' => $message, 'type' => $type);
  }

  /**
   * return the error count
   */
  function errorCount() {
    $count = 0;
    foreach ($this->status as $status) {
      if ($status['type'] == 'error') {
        $count++;
      }
    }
    return $count;
  }

  /**
   * disable extension loading
   * usful for any responce only contain the out put from menu callback
   */
  function DisableExtension() {
    $this->allowExtension = FALSE;
  }

}
