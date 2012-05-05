<?php

/**
 * @file
 * html page file
 *
 * @author
 * @copyright Open-org.com, All rights reserved
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if (isset($meta)) {
  echo $meta;
}
?>
<title><?php $this->title ?></title>
<?php echo (isset($stylesheet) ? $stylesheet : '');
if (isset($htmlstyle)) {
  echo "<style>\n" . $htmlstyle . "\n</style>";
}
?>
<script type="text/javascript" language="javascript" src="media/js/jquery-1.7.2.min.js"></script>
<?php
echo (isset($script)) ? $script : '';
if (isset($htmlscript)) {
  echo "<script>\n" . $htmlscript . "\n</script>";
}
?>
</head>
<body>
<div id="container">
  <div id="topmost">
  <a href="#" class="topmostlinks"><?php echo t('Register'); ?></a> 
    <a href="#" class="topmostlinks">{{Login}}</a>
    <a href="hjaelp.html" class="topmostlinks">{{Help}}</a>
  </div>
  <div id="logonslogans">
    <div id="logo">
	  <span class="text logotxt">{{logo text}}</span>
	  <div class="text slogan1 slogan1txt">{{slogan text}}</div>
	  <div class="text slogan2 slogan2txt">{{slogan2 text}}</div>
<?php echo isset($logo) ? $logo : ''; ?>
    </div>
  </div>
  <div id="searcharea">
<?php echo (isset($content)) ? $content : ''; ?>
  </div>
  <div id="abovefooter"></div>
  <div id="horline"><img src="images/fasvar-home-design-line_44.gif" width="697" height="9" /></div>
  <div id="footer"><?php echo isset($footer) ? $footer : '' ; ?></div>
</div>
</body>
</html>
