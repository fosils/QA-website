<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><${{title}}></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="media/js/jquery-1.7.2.min.js"></script>
<script>
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
    <div class="banner"></div>
    <div class="content">
      <div class="contentwrapper">
        <div class="contentwrapper">
          <form action="index.php?q=question" method="post">
	    <input type="hidden" name="<C{{STEP_FORM_FIELD}}>" value="1">
	      <textarea name="<C{{QUESTION_FORM_FIELD}}>" id="<C{{QUESTION_FORM_FIELD}}>" cols="45" rows="5" class="searchbox"><${{question}}></textarea>
            <input type="submit" value="{{Submit}}" class="submit">
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="abovefooter"></div>
  <div id="horline"><img src="images/fasvar-home-design-line_44.gif" width="697" height="9" /></div>
  <div id="footer">{{How it works}} {{About}} {{Become an expert}}<br /><br />
  <{{copyright}}></div>
</div>
</body>
</html>
