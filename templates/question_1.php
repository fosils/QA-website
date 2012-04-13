<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><${{title}}></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
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
	  <div class="information">{{$60 question}}</div>
          <form action="index.php?q=question" method="post">
	    <input type="hidden" name="<C{{STEP_FORM_FIELD}}>" value="2" />
	    <input type="hidden" name="<C{{HASH_FORM_FIELD}}>" value="<{{session_get_form_hash}}>" />
	    <div class="field">
	      <label for="<C{{EMAIL_FORM_FIELD}}>">{{email label}}
		<input type="text" name="<C{{EMAIL_FORM_FIELD}}>" id="<C{{EMAIL_FORM_FIELD}}>" />
	      </label>
	    </div>
	    <div class="field">
	      <label for="<C{{PHONE_FORM_FIELD}}>">{{phone label}}
		<input type="text" name="<C{{PHONE_FORM_FIELD}}>" id="<C{{PHONE_FORM_FIELD}}>" />
	      </label>
	    </div>
	    <div class="field">
	      <label for="<C{{NAME_FORM_FIELD}}>">{{name label}}
		<input type="text" name="<C{{NAME_FORM_FIELD}}>" id="<C{{NAME_FORM_FIELD}}>" />
	      </label>
	    </div>
            <input type="submit" value="{{Submit}}" class="submit">
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
