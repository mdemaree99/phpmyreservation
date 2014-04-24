<?php 
include('config.php'); 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "INSERT INTO `phpmyreservation_venues` ( `name` ,  `sports_type` ,  `time_slots` ,  `day_off` ,  `rate` ,  `location` ,  `contact_number` ,  `playground_id` ,  `is_active`  ) VALUES(  '{$_POST['name']}' ,  '{$_POST['sports_type']}' ,  '{$_POST['time_slots']}' ,  '{$_POST['day_off']}' ,  '{$_POST['rate']}' ,  '{$_POST['location']}' ,  '{$_POST['contact_number']}' ,  '{$_POST['playground_id']}' ,  '{$_POST['is_active']}'  ) "; 
mysql_query($sql) or die(mysql_error()); 
echo "Added row.<br />"; 
echo "<a href='index.php'>Back To Listing</a>"; 
} 
?>

<form action='' method='POST'> 
<p><b>Name:</b><br /><input type='text' name='name'/> 
<p><b>Sports Type:</b><br /><input type='text' name='sports_type'/> 
<p><b>Time Slots:</b><br /><input type='text' name='time_slots'/> 
<p><b>Day Off:</b><br /><input type='text' name='day_off'/> 
<p><b>Rate:</b><br /><input type='text' name='rate'/> 
<p><b>Location:</b><br /><input type='text' name='location'/> 
<p><b>Contact Number:</b><br /><input type='text' name='contact_number'/> 
<p><b>Playground Id:</b><br /><input type='text' name='playground_id'/> 
<p><b>Is Active:</b><br /><input type='text' name='is_active'/> 
<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
