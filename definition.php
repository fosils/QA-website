<?php
/**
 * @file
 * define constants
 *
 * copyright @ Open-org.com all rights reserved.
 */

define('OPEN_ORG_INIT', 1);
// Form_fields.
define('QUESTION_FORM_FIELD', 'question');
define('HASH_FORM_FIELD', 'hash');
define('EMAIL_FORM_FIELD', 'email');
define('NAME_FORM_FIELD', 'name');
define('PHONE_FORM_FIELD', 'phone');
define('STEP_FORM_FIELD', 'step');
// File and paths.
define('ROOT_DIRECTORY', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('TEMPLATE_DIRECTORY', ROOT_DIRECTORY . DS . 'templates');
define('TEMPLATE_EXTENTION', '.php');
define('LANGUAGE_DIRECTORY', ROOT_DIRECTORY . DS . 'languages');
// Language.
define('LANGUAGE', 'en_GB');
