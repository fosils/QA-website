<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><${{title}}></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="media/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" language="javascript" src="media/js/paypal.js"></script>
<script type="text/javascript">
  (function ($){
  $(document).ready(function(){
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
  $('#paypalform').submit();
  //ping to server
  $('#searcharea').load('index.php?q=question #searcharea',{
  <C{{STEP_FORM_FIELD}}>:$('#<C{{STEP_FORM_FIELD}}>')[0].value,
  <C{{HASH_FORM_FIELD}}>:$('#<C{{HASH_FORM_FIELD}}>')[0].value,
  <C{{NAME_FORM_FIELD}}>:$('#<C{{NAME_FORM_FIELD}}>')[0].value,
  <C{{EMAIL_FORM_FIELD}}>:$('#<C{{EMAIL_FORM_FIELD}}>')[0].value
  });
  })})})(jQuery);
</script>
</head>
<body>
<div id="container">
  <div id="topmost">
    <a href="#" class="topmostlinks">{{Register}}</a> | 
    <a href="#" class="topmostlinks">{{Login}}</a> |
    <a href="#" class="topmostlinks">{{Help}}</a>
  </div>
  <div id="logonslogans">
    <div id="logo">
	  <span class="text logotxt">{{logo text}}</span>
	  <div class="text slogan1 slogan1txt">{{slogan text}}</div>
	  <div class="text slogan2 slogan2txt">{{slogan2 text}}</div>
	  <div class="sloganbar">
	    <div class="text slogan3 slogan3txt">{{slogan3 text}}</div>
	    <div class="text slogan4 slogan4txt">{{slogan4 text}}</div>
	  </div>
    </div>
  </div>
  <div id="searcharea">
    <div class="tabs">
      <{{menu_tab, class:tab, active:active, has_submenu:nested}}>
    </div>
    <div class="banner"></div>
    <div class="content">
      <div class="contentwrapper">
        <div class="contentwrapper">
	  <div id="error_msg"></div>
	  <div class="information">{{$60 question}}</div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalform" target="_blank">
<!--          <form action="index.php?q=question" method="post"> -->
	    <input type="hidden" name="<C{{STEP_FORM_FIELD}}>" id="<C{{STEP_FORM_FIELD}}>" value="2" />
	    <input type="hidden" name="<C{{HASH_FORM_FIELD}}>" id="<C{{HASH_FORM_FIELD}}>" value="<{{session_get_form_hash}}>" />
	    <div class="field">
	      <label for="<C{{NAME_FORM_FIELD}}>">{{name label}}
		<input type="text" name="<C{{NAME_FORM_FIELD}}>" id="<C{{NAME_FORM_FIELD}}>" />
	      </label>
	    </div>
	    <div class="field">
	      <label for="<C{{EMAIL_FORM_FIELD}}>">{{email label}}
		<input type="text" name="<C{{EMAIL_FORM_FIELD}}>" id="<C{{EMAIL_FORM_FIELD}}>" />
	      </label>
	    </div>
<!--
	    <div class="field">
	      <label for="<C{{PHONE_FORM_FIELD}}>">{{phone label}}
		<input type="text" name="<C{{PHONE_FORM_FIELD}}>" id="<C{{PHONE_FORM_FIELD}}>" />
	      </label>
	    </div>
-->
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="YDH8D48XA98YE">
<input id="paypalbutton" class="paypal" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="abovefooter"></div>
  <div id="horline"><img src="images/fasvar-home-design-line_44.gif" width="697" height="9" /></div>
  <div id="footer">{{How it works}} | {{About}} | {{Become an expert}}<br />
  <{{copyright}}></div>
</div>
</body>
</html>
