<?php
/**
 * @file
 * Payment confirmation page
 */

ob_start();
?>
	  <div class="information">{{confirmation message}}</div>
	  <div class="information">{{ask new question}}</div>
<?php
$content = ob_get_clean();
ob_start();
// Google tracking code.
?>
  <!-- Google Code for Success.php Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1007542086;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "hNhECJqp1AIQxr634AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1007542086/?label=hNhECJqp1AIQxr634AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php
$googlecode = ob_get_clean();
include 'question.template.php';
//end
