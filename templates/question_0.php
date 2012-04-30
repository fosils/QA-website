<?php
/**
 * @file
 * The theme for welcome screen
 */

ob_start();
?>
//Used to clear the content of the textarea when that area gets clicked
(function($,val){
  $(document).ready(function(){
    $('#<C{{QUESTION_FORM_FIELD}}>').focus(function(){
      if(this.value == val){
        this.value = '';
      }
    }).focusout(function(){
      if(this.value == ''){
        this.value = val;
      }
    });
  });
})(jQuery, '{{write question here}}');
<?php
$script = ob_get_clean();
ob_start();
?>
          <form action="index.php?q=question" method="post">
	    <input type="hidden" name="<C{{STEP_FORM_FIELD}}>" value="1">
	      <textarea name="<C{{QUESTION_FORM_FIELD}}>" id="<C{{QUESTION_FORM_FIELD}}>" cols="45" rows="5" class="searchbox"><${{question}}></textarea>
            <input type="submit" value="{{Submit}}" class="submit">
          </form>
<?php
$content = ob_get_clean();
include 'question.template.php';
