<?php
/**
 * @file
 * The customer info and payment selection
 */

ob_start();
//javascript
?>
  (function ($){
    var button = {easy:'KCNK6EQQFCY4S', 'complex':'4BR66UTVC4EGG', 'advice':'DHMCSSJNBPJXA'};
  $(document).ready(function(){
    (function(id){
      id.change(function(){
        $('#hosted_button_id').val(button[this.value]);
      });
      $('#hosted_button_id').val(button[id.val()]);
    })($('#<C{{COMPLEXITY_FORM_FIELD}}>'));
  $('#paypalbutton').click(function(e){
  //validate
  e.preventDefault();
  var error = [];
  if ($('#<C{{NAME_FORM_FIELD}}>')[0].value == '') {
  error.push("{{Please Enter Your name to continue}}");
  $('#<C{{NAME_FORM_FIELD}}>').addClass('error');
  }
  else{
  $('#<C{{NAME_FORM_FIELD}}>').removeClass('error');
  }
  if (!$('#<C{{EMAIL_FORM_FIELD}}>')[0].value.match(/^[^@]+@[^@\.]+\.[^@]+$/)){
  error.push("{{Please enter your email address to continue}}");
  $('#<C{{EMAIL_FORM_FIELD}}>').addClass('error');
  }
  else{
  $('#<C{{EMAIL_FORM_FIELD}}>').removeClass('error');
  }
  if(error.length){
  $('#error_msg').html( error.join('<br />'));
  return;
  }
  //ping to server
  $.ajax({
    url:'index.php?q=question #searcharea>div',
	type: 'POST',
	data:{
  <C{{STEP_FORM_FIELD}}>:$('#<C{{STEP_FORM_FIELD}}>')[0].value,
  <C{{HASH_FORM_FIELD}}>:$('#<C{{HASH_FORM_FIELD}}>')[0].value,
  <C{{NAME_FORM_FIELD}}>:$('#<C{{NAME_FORM_FIELD}}>')[0].value,
  <C{{EMAIL_FORM_FIELD}}>:$('#<C{{EMAIL_FORM_FIELD}}>')[0].value,
  <C{{DEADLINE_FORM_FIELD}}>:$('#<C{{DEADLINE_FORM_FIELD}}>')[0].value,
  <C{{COMPLEXITY_FORM_FIELD}}>:$('#<C{{COMPLEXITY_FORM_FIELD}}>')[0].value,
  }}).done( function(){
  $('#paypalform').submit();
  });
  })})})(jQuery);
<?php

$script = ob_get_clean();
ob_start();
// Main content.
?>
	  <div id="error_msg"></div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalform">
<!--          <form action="index.php?q=question" method="post"> -->
	    <input type="hidden" name="<C{{STEP_FORM_FIELD}}>" id="<C{{STEP_FORM_FIELD}}>" value="2" />
	    <input type="hidden" name="<C{{HASH_FORM_FIELD}}>" id="<C{{HASH_FORM_FIELD}}>" value="<{{session_get_form_hash}}>" />
	    <div class="field">
	      <label for="<C{{NAME_FORM_FIELD}}>">{{name label}}
		<input type="text" name="<C{{NAME_FORM_FIELD}}>" id="<C{{NAME_FORM_FIELD}}>" value="<${{name}}>"/>
	      </label>
	    </div>
	    <div class="field">
	      <label for="<C{{EMAIL_FORM_FIELD}}>">{{email label}}
		<input type="text" name="<C{{EMAIL_FORM_FIELD}}>" id="<C{{EMAIL_FORM_FIELD}}>" value="<${{email}}>"/>
	      </label>
	    </div>
	    <div class="field">
	      <label for="<C{{DEADLINE_FORM_FIELD}}>">{{deadline label}}
		<select name="<C{{DEADLINE_FORM_FIELD}}>" id="<C{{DEADLINE_FORM_FIELD}}>">
		  <{{deadlineOptions,<${{deadline}}>}}>
		</select>
	      </label>
	    </div>
	    <div class="field">
	      <label for="<C{{COMPLEXITY_FORM_FIELD}}>">{{complexity label}}
		<select name="<C{{COMPLEXITY_FORM_FIELD}}>" id="<C{{COMPLEXITY_FORM_FIELD}}>">
		  <{{complexityOptions,<${{complexity}}>}}>
		</select>
	      </label>
	    </div>
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" id="hosted_button_id" value="">
		</br>
		<div class="information">{{$60 question}}</div>
		<input id="paypalbutton" class="paypal" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
          </form>
<?php

$content = ob_get_clean();
include 'question.template.php';
//end
