<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><${{title}}></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
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
	  <div class="information">{{thanking message}}</div>
	  <div class="information">{{ask new question}}</div>
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
