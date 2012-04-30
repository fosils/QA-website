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
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31289213-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div id="container">
  <div id="topmost">
    <a href="#" class="topmostlinks">{{Register}}</a>
    <a href="#" class="topmostlinks">{{Login}}</a>
    <a href="hjaelp.html" class="topmostlinks">{{Help}}</a>
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
<input id="paypalbutton" class="paypal" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="abovefooter"></div>
  <div id="horline"><img src="images/fasvar-home-design-line_44.gif" width="697" height="9" /></div>
  <div id="footer">{{How it works}} {{About}} {{Become an expert}}<br />
  <{{copyright}}></div>
</div>
</body>
</html>
