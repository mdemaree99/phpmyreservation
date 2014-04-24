<?php 
include('config.php'); 
echo "<table border=1 >"; 
echo "<tr>"; 
echo "<td><b>Name</b></td>"; 
echo "<td><b>Id</b></td>"; 
echo "<td><b>Sports Type</b></td>"; 
echo "<td><b>Time Slots</b></td>"; 
echo "<td><b>Day Off</b></td>"; 
echo "<td><b>Rate</b></td>"; 
echo "<td><b>Location</b></td>"; 
echo "<td><b>Contact Number</b></td>"; 
echo "<td><b>Playground Id</b></td>"; 
echo "<td><b>Is Active</b></td>"; 
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `phpmyreservation_venues`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['name']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['id']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['sports_type']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['time_slots']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['day_off']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['rate']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['location']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['contact_number']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['playground_id']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['is_active']) . "</td>";  
echo "<td valign='top'><a href=edit.php?id={$row['id']}>Edit</a></td><td><a href=delete.php?id={$row['id']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
echo "<a href=new.php>New Row</a>"; 
?>