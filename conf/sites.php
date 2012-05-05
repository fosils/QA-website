<?php
/**
 * @file
 * Multi site configuration file
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

$sites = array(
  // Default configuration.
  'default' => array(
    // Default theme for configuration.
    'theme' => 'paidqa',
    // Enabled modules.
    'modules' => array(
      'Session',
      'Request',
      'Menu',
      'Question',
      'Responce',
    ),
  ),
);
