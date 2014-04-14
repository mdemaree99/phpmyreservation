<?php
 include_once 'main.php';
 
 if(isset($_GET['id']))
 {
	$id = mysql_real_escape_string($_GET['id']);
	$venue = list_venue_by_id($id);
	
	if(!is_array($venue))
	{
	 echo '<span class="error_span">No results obtained please modify your search query</span>';
	 return;
	}
?>


	<div class="flat_box_div centred_div">
	<div class="flat_box_body_div ">
		<h3><a href="<?php echo "?venue=$venue[id]" ?>"><?php echo $venue['name'] ?></a></h3>
		
		<span class="soft">Time slots : <?php echo $venue['time_slots'] ?></span>
		<br/>
		<span class="soft">Rate : </span><?php echo $venue['rate'] ?> per slot
		<span class="soft">Contact : <?php echo $venue['contact_number'] ?></span>
		<br/>
		<a href="">Reviews</a> | <a href='' id='venue_check_reservation'>Show Reservations</a>
	</div>	
</div>

<?php
 }
?>

<div id="reservation_result_div"></div>