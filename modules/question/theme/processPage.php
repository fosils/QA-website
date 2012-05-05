<?php
/**
 * @file
 * theme file processPage
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

$n_f = \Module\Question::NAME_FIELD;
$e_f = \Module\Question::EMAIL_FIELD;
$d_f = \Module\Question::DEADLINE_FIELD;
$c_f = \Module\Question::COMPLEXITY_FIELD;
$object = $this->conf->module('Question');
$this->addScript("jQuery(document).ready(function(){
(function($,n,e,d,c){
pageProcess($,$('#'+n),$('#'+e),$('#'+d),$('#'+c),{easy:'KCNK6EQQFCY4S', 'complex':'4BR66UTVC4EGG', 'advice':'DHMCSSJNBPJXA'},n,e,d,c,'" . t('Please Enter Your name to continue') . "','" . t('Please enter your email address to continue') . "' );
})(jQuery,'" . $n_f . "','" . $e_f . "','" . $d_f . "','" . $c_f . "');});");
$this->addScriptTag('processPage.js', 'Question');
ob_start();
?>
<div id="error_msg"></div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalform">
  <div class="field">
    <label for="<?php echo $n_f; ?>"><?php echo t('name label'); ?>
      <input type="text" name="<?php echo $n_f; ?>" id="<?php echo $n_f; ?>" value="<?php echo $name; ?>"/>
    </label>
  </div>
  <div class="field">
    <label for="<?php echo $e_f; ?>"><?php echo t('email label'); ?>
      <input type="text" name="<?php echo $e_f; ?>" id="<?php echo $e_f; ?>" value="<?php echo $email; ?>"/>
    </label>
  </div>
  <div class="field">
    <label for="<?php echo $d_f; ?>"><?php echo t('deadline label'); ?>
      <select name="<?php echo $d_f; ?>" id="<?php echo $d_f; ?>">
	<?php echo $object->deadlineOptions($deadline); ?>
      </select>
    </label>
  </div>
  <div class="field">
    <label for="<?php echo $c_f; ?>"><?php echo t('complexity label'); ?>
      <select name="<?php echo $c_f; ?>" id="<?php echo $c_f; ?>">
	<?php echo $object->complexityOptions($complexity); ?>
      </select>
    </label>
  </div>
  <input type="hidden" name="cmd" value="_s-xclick">
  <input type="hidden" name="hosted_button_id" id="hosted_button_id" value="">
  <br>
  <div class="information"><?php echo t('$60 question'); ?></div>
  <input id="paypalbutton" class="paypal" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
  <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php
echo $object->themeWrapper(ob_get_clean());
