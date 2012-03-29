<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
   <title>Ask Question</title>
  </head>
  <body>
    <div id="wrapper">
      <div id="header"></div>
      <div id="content">
	<div>
	  <div id="form">
	    <form id="userform" method="post">
	      <div id="formtop">
<?php
  if ($step == 2){
?>
    <!-- Thanks message here -->
<?php
  }
  else if ($step == 1){
?>
    <!-- Ask user weather user is ready to pay 60$ for an answer -->
<?php
  }
?>
	      </div>
<?php
  if ($step < 2 ){
?>
	      <div id="formmenu">
   <!-- form menu here -->
	      </div>
	      <div id="formfields">
<?php
    if ($step == 0){
?>
   <!-- form fields to enter users question -->
<?php
    }
    else{
?>
   <!-- form fields to enter user details -->
<?php
    }
?>
   <!-- submit button here -->
	      </div>
<?php
  }
?>
	    </form>
	  </div>
	  <div id="info">
   <!-- Enter the information if any here -->
	  </div>
	</div>
      </div>
      <div id="footer"></div>
    </div>
  </body>
</html>
