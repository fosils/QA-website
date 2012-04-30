<?php
/**
 * @file
 * Thanking message
 */

ob_start();
?>
	  <div class="information">{{thanking message}}</div>
	  <div class="information">{{ask new question}}</div>
<?php
$content = ob_get_clean();
include 'question.template.php';
//end
