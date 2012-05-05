<?php
/**
 * @file
 * define constants
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

define('OPEN_ORG_INIT', 1);
// Form_fields.
define('QUESTION_FORM_FIELD', 'question');
define('HASH_FORM_FIELD', 'hash');
define('EMAIL_FORM_FIELD', 'email');
define('NAME_FORM_FIELD', 'name');
define('PHONE_FORM_FIELD', 'phone');
define('STEP_FORM_FIELD', 'step');
define('DEADLINE_FORM_FIELD', 'deadline');
define('COMPLEXITY_FORM_FIELD', 'complexity');
// File and paths.
define('SITE_ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('MODULE_PATH', SITE_ROOT . DS . 'modules');
define('MODULE_URL', 'modules');
define('TEMPLATE_PATH', SITE_ROOT . DS . 'templates');
define('TEMPLATE_URL', 'templates');
define('TEMPLATE_EXTENTION', '.php');
define('LANGUAGE_DIRECTORY', SITE_ROOT . DS . 'languages');
define('MODULE_EXTENSION', '.php');
// Language.
define('LANGUAGE', 'da_DK');
