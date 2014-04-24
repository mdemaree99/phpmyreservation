<?php 
include('config.php'); 
if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `phpmyreservation_venues` SET  `name` =  '{$_POST['name']}' ,  `sports_type` =  '{$_POST['sports_type']}' ,  `time_slots` =  '{$_POST['time_slots']}' ,  `day_off` =  '{$_POST['day_off']}' ,  `rate` =  '{$_POST['rate']}' ,  `location` =  '{$_POST['location']}' ,  `contact_number` =  '{$_POST['contact_number']}' ,  `playground_id` =  '{$_POST['playground_id']}' ,  `is_active` =  '{$_POST['is_active']}'   WHERE `id` = '$id' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
echo "<a href='index.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `phpmyreservation_venues` WHERE `id` = '$id' ")); 
?>

<form action='' method='POST'> 
<p><b>Name:</b><br /><input type='text' name='name' value='<?= stripslashes($row['name']) ?>' /> 
<p><b>Sports Type:</b><br /><input type='text' name='sports_type' value='<?= stripslashes($row['sports_type']) ?>' /> 
<p><b>Time Slots:</b><br /><input type='text' name='time_slots' value='<?= stripslashes($row['time_slots']) ?>' /> 
<p><b>Day Off:</b><br /><input type='text' name='day_off' value='<?= stripslashes($row['day_off']) ?>' /> 
<p><b>Rate:</b><br /><input type='text' name='rate' value='<?= stripslashes($row['rate']) ?>' /> 
<p><b>Location:</b><br /><input type='text' name='location' value='<?= stripslashes($row['location']) ?>' /> 
<p><b>Contact Number:</b><br /><input type='text' name='contact_number' value='<?= stripslashes($row['contact_number']) ?>' /> 
<p><b>Playground Id:</b><br /><input type='text' name='playground_id' value='<?= stripslashes($row['playground_id']) ?>' /> 
<p><b>Is Active:</b><br /><input type='text' name='is_active' value='<?= stripslashes($row['is_active']) ?>' /> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<?php } ?> 
