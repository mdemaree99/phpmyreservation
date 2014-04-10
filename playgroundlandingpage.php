<?php

include_once('main.php');

//if(check_playground_login() != true) { exit; }


?>
<div class="box_div" id="login_div"><div class="box_top_div"><a href="#">Start</a> &gt; Add venue</div><div class="box_body_div">
	<div id="new_user_div"><div>

	<form action="." id="new_user_form"><p>

	<label for="venue_name_input">Venue name</label><br>
	<input type="text" id="venue_name_input"><br><br>
	<label for="venue_type_input">Venue sports type</label><br>
	<input type="text" id="venue_type_input"><br><br>
	<label for="venue_time_input">Venue time slots</label><br>
	<textarea id="venue_time_input"></textarea><br><br>
	<label for="venue_rate_input">Rate per time slot</label><br>
	<input type="text" id="venue_rate_input"><br><br>
	<label for="venue_location_input">Venue Location</label><br>
	<input type="text" id="venue_location_input"><br><br>
	<label for="venue_contact_number_input">Venue contact number</label><br>
	<input type="text" id="venue_contact_number_input"><br><br>
	<input type="submit" value="Add Venue">

	</p></form>

	</div><div>
	
	<p class="blue_p bold_p">Information:</p>
	<ul>
	<li>Venue name is the court name , example : "Badminton court 1"</li>
	<li>Venue sports type example : badminton , tennis , cricket , football etc</li>
	<li>Enter all the time slots seperated by semicolon(;) , example:-<br/> 9AM-10AM;10AM-11AM;11AM-12PM;12AM-1PM;1AM-2PM <br/>or <br/> 10AM to 12PM;2PM to 4PM;6PM to 8PM <br/> etc</li>
	</ul>

	<div id="user_secret_code_div">Secret code is used to only allow certain people to create a new user. Contact the webmaster by email at <span id="email_span"></span> to get the secret code.</div>

	<script type="text/javascript">$('#email_span').html('<a href="mailto:'+$.base64.decode('<?php echo base64_encode(global_webmaster_email); ?>')+'">'+$.base64.decode('<?php echo base64_encode(global_webmaster_email); ?>')+'</a>');</script>

	</div></div>
	
	<div id=""><?php echo list_venues(); ?></div>
