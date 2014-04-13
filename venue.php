<?php
 include_once 'main.php';
 
 if(isset($_GET['id']))
 {
	$id = mysql_real_escape_string($_GET['id']);
	echo list_venue_by_id($id);
 }
?>

<div id="reservation_result_div"></div>