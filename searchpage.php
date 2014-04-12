<?php
include_once('main.php');

if(isset($_GET['search_venue']))
{
	$venue = mysql_real_escape_string(trim($_GET['venue_name']));
	
	echo list_playgrounds_and_venues_by_name($venue);
}
else if(isset($_GET['search']))
{
	$sports_type = mysql_real_escape_string(trim($_GET['sports_type']));
	$location = mysql_real_escape_string(trim($_GET['location']));
	
	echo list_venues_by_sports_location($sports_type , $location);
}
else
{
?>

<h1 class="search blue" >Which game are you gonna play?</h1>
<h2 class="search blue" >Search a play area near you</h2>

<div class="box_div centred_div" id="search_div">
<div class="search_box_body_div">
<form action="." id="new_user_form"><p>

<table>
<tr>
	<td><input type="text" id="game_type_input" class="large_text" placeholder="Game type, ex: badminton"></td>
	<td><input type="text" id="location_input" class="large_text" placeholder="Location" autocapitalize="off"></td>
	<td><input type="submit" value="Search"></td>
</tr>
</table>

</form>



<div id="search_box_results_div">
	<?php echo list_venues_by_sports_location('badminton' , 'bellandur'); ?>
</div> 

</div>
</div>

<?php

}
?>