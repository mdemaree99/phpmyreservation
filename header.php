<?php include_once('main.php'); ?>

<div id="header_inner_div"><div id="header_inner_left_div">

<a href=".">Home</a> | <a href="#about">About</a>

<?php

if(isset($_SESSION['logged_in']))
{
	echo ' | <a href="#help">Help</a>';
}

?>

</div><div id="header_inner_center_div">



<?php
/*
if(isset($_SESSION['logged_in']))
{
	echo '<b>Week ' . global_week_number . ' - ' . global_day_name . ' ' . date('jS F Y') . '</b>';
}
*/
?>

</div><div id="header_inner_right_div">

<?php

if(isset($_SESSION['logged_in']))
{
	echo '<a href="#dashboard">Dashboard</a> | <a href="#cp">Control panel</a> | <a href="#logout">Logout</a>';
}
else
{
	//echo 'Not logged in';
	echo '<a href="#userlogin">User Login</a> | <a href="#playgroundlogin">Playground Login</a>';
}

?>

</div></div>
