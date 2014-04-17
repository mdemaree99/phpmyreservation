<?php
 include_once 'main.php';
 
 if(isset($_GET['getprice']))
 {
	$id = mysql_real_escape_string($_GET['id']);
	echo get_venue_attribute('rate',$id);
	return;
 }
 if(isset($_GET['getname']))
 {
	$id = mysql_real_escape_string($_GET['id']);
	echo get_venue_attribute('name',$id);
	return;
 }
 else if(isset($_GET['id']))
 {
	$id = mysql_real_escape_string($_GET['id']);
	$venue = list_venue_by_id($id);
	
	if(!is_array($venue))
	{
	 echo '<span class="error_span">No results obtained please modify your search query</span>';
	 return;
	}
?>


	<div class="box_div centred_div">
	<div class="search_box_body_div ">
		<h2><?php echo $venue['name'] ?></h2>
		<hr/>
		<table>
			<tr>
			<td><b>Address : </b></td><td>Outer Ring Road , Bellandur</td>
			</tr>
			<tr>
			<td><b>Time slots : </b></td><td><?php echo $venue['time_slots'] ?></td>
			</tr>
			<tr>
			<td><b>Rate : </b></td><td><?php echo $venue['rate'] ?> per slot</td>
			</tr>
			<tr>
			<td><b>Contact Number: </b></td><td><?php echo $venue['contact_number'] ?></td>
			</tr>
		</table>
		<hr/>
		<p class="bold_p">Venue Images</p>
		<a href="#"><img src="http://www.bimboosoft.com/DMT/images/play1.jpg" alt="Smiley face" height="50" width="50"></a>
		<a href="#"><img src="http://www.bimboosoft.com/DMT/images/play1.jpg" alt="Smiley face" height="50" width="50"></a>
		<a href="#"><img src="http://www.bimboosoft.com/DMT/images/play1.jpg" alt="Smiley face" height="50" width="50"></a>
		<a href="#"><img src="http://www.bimboosoft.com/DMT/images/play1.jpg" alt="Smiley face" height="50" width="50"></a>
		<a href="#"><img src="http://www.bimboosoft.com/DMT/images/play1.jpg" alt="Smiley face" height="50" width="50"></a>
		
		<br/>
		<br/>
		<a href="">Read Reviews</a> 
	</div>	
	</div>

	<div id="reservation_result_div"></div>
<?php
 }
 
 
?>



