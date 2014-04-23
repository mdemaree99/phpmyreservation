<?php

// Playground validation
function playground_email_exists($playground_email)
{
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_email='$playground_email'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) > 0)
	{
		return(true);
	}
}

// Playground Login

function get_playground_login_data($data)
{
	if($data == 'playground_email' && isset($_COOKIE[global_cookie_prefix . '_playground_email']))
	{
		return($_COOKIE[global_cookie_prefix . '_playground_email']);
	}
	elseif($data == 'playground_password' && isset($_COOKIE[global_cookie_prefix . '_playground_password']))
	{
		return($_COOKIE[global_cookie_prefix . '_playground_password']);
	}
}

function playgroundlogin($playground_email, $playground_password, $playground_remember)
{
	logout();
	
	$playground_password_encrypted = encrypt_password($playground_password);
	$playground_password = add_salt($playground_password);
	
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_email='$playground_email' AND playground_password='$playground_password_encrypted' OR playground_email='$playground_email' AND playground_password='$playground_password'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) == 1)
	{
			$playground = mysql_fetch_array($query);

			$_SESSION['user_id'] = $playground['playground_id'];
			$_SESSION['user_is_admin'] = 1;
			$_SESSION['user_email'] = $playground['playground_email'];
			$_SESSION['user_name'] = $playground['playground_name'];
			$_SESSION['user_reservation_reminder'] = $playground['playground_reservation_reminder'];
			$_SESSION['logged_in'] = '1';
			$_SESSION['logged_in_as_playground'] = '1';
			
			if($playground_remember == '1')
			{
				$playground_password = strip_salt($playground['playground_password']);

				setcookie(global_cookie_prefix . '_playground_email', $playground['playground_email'], time() + 3600 * 24 * intval(global_remember_login_days));
				setcookie(global_cookie_prefix . '_playground_password', $playground_password, time() + 3600 * 24 * intval(global_remember_login_days));
			}

			return(1);
	}
}

function check_playground_login()
{
	if( !isset($_SESSION['logged_in_as_playground']) )
	{
		return false;
	}
	$playground_id = $_SESSION['user_id'];
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_id='$playground_id'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) == 1)
	{
		return(true);
	}
	else
	{
		logout();
		echo '<script type="text/javascript">window.location.replace(\'.\');</script>';
	}
}

function create_playground($playground_name, $playground_email, $playground_password, $locality , $address, $playground_secret_code)
{
	/*if(validate_user_name($playground_name) != true)
	{
		return('<span class="error_span">Name must be <u>letters only</u> and be <u>2 to 12 letters long</u>. If your name is longer, use a short version of your name</span>');
	}*/
	if(validate_user_email($playground_email) != true)
	{
		return('<span class="error_span">Email must be a valid email address and be no more than 50 characters long</span>');
	}
	elseif(validate_user_password($playground_password) != true)
	{
		return('<span class="error_span">Password must be at least 4 characters</span>');
	}
	elseif(global_secret_code != '0' && $playground_secret_code != global_secret_code)
	{
		return('<span class="error_span">Wrong secret code</span>');
	}
	elseif(playground_email_exists($playground_email) == true)
	{
		return('<span class="error_span">Email is already registered. <a href="#forgot_password">Forgot your password?</a></span>');
	}
	else
	{
		$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . "")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		if(mysql_num_rows($query) == 0)
		{
			$playground_is_admin = '1';
		}
		else
		{
			$playground_is_admin = '0';
		}

		$playground_password = encrypt_password($playground_password);

		mysql_query("INSERT INTO " . global_mysql_playgrounds_table . " (playground_is_admin,playground_email,playground_password,playground_name,playground_location,locality,playground_reservation_reminder) VALUES ($playground_is_admin,'$playground_email','$playground_password','$playground_name','$locality', '$address' ,'0')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		$playground_password = strip_salt($playground_password);

		setcookie(global_cookie_prefix . '_playground_email', $playground_email, time() + 3600 * 24 * intval(global_remember_login_days));
		setcookie(global_cookie_prefix . '_playground_password', $playground_password, time() + 3600 * 24 * intval(global_remember_login_days));

		return(1);
	}
}

//Venue functions

function create_or_update_venue($venue_name, $venue_sports_type, $venue_time_slots, $rate_per_time_slot, $venue_location, $venue_contact_number,$venue_day_off, $venue_id='')
{
	$playground_id = $_SESSION['user_id'];
	
	if($venue_id == '')
	{
	mysql_query("INSERT INTO " . global_mysql_venues_table . " (name,sports_type,time_slots,rate,location,contact_number,day_off,playground_id ) VALUES ('$venue_name', '$venue_sports_type', '$venue_time_slots', '$rate_per_time_slot', '$venue_location', '$venue_contact_number','$venue_day_off', '$playground_id')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	}
	else
	{
	//Update
	}
	return 1;
}

function delete_venue_data($venue_id , $data)
{
	$playground_id = $_SESSION['user_id'];
	
	//Check if venue , belongs to logged in playground
	$query = mysql_query("SELECT * FROM " . global_mysql_venues_table . " WHERE id = $venue_id AND playground_id = $playground_id")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) < 1)
	{
		return('<span class="error_span">You have not added any venues. Add one below.</span>');
	}

	mysql_query("DELETE from " . global_mysql_venues_table . " WHERE id = $venue_id")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	return(1);
}

function list_venues($playground_id = '')
{
	if($playground_id == '')
	{
		$playground_id = $_SESSION['user_id'];
	}

$query = mysql_query("SELECT * FROM " . global_mysql_venues_table . " WHERE playground_id = $playground_id")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) < 1)
	{
		return('<span class="error_span">You have not added any venues. Add one below.</span>');
	}
	
	$venues = '<table id="venues_table"><tr><th>Venue Name</th><th>Venue sports type</th><th>Venue time slots</th><th>Rate</th><th>Venue Location</th><th>Contact Number</th><th></th></tr>';

	while($venue = mysql_fetch_array($query))
	{
		$venues .= '<tr id="venue_tr_' . $venue['id'] .'"><td>';
		$venues .= '<label for="venue_radio_' . $venue['name'] . '">' . $venue['name'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['sports_type'] . '">' . $venue['sports_type'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['time_slots'] . '">' . $venue['time_slots'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['rate'] . '">' . $venue['rate'] . '</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['location'] . '">' . $venue['location'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['contact_number'] . '">' . $venue['contact_number'] .'</label></td><td>';
		$venues .= '<input type="radio" name="venue_radio" class="venue_radio" id="venue_radio_' . $venue['id'] . '" value="' . $venue['id'] . '">';
		$venues .= '</td></tr>';
	}

	$venues .= '</table>';

	return($venues);
}

function list_playgrounds_and_venues_by_name($name)
{
	$query_statement = "SELECT * from ".global_mysql_playgrounds_table . " WHERE playground_name LIKE '%$name%'";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	while($playground = mysql_fetch_array($result))
	{
		echo $playground['playground_name'];
		echo list_venues($playground['playground_id']);
	}

}

function list_venues_by_sports_location( $sports_type , $location)
{
	if($location == '' )
	{
		return('<span class="error_span">Please enter a location to search</span>');
	}
	
	$query_statement = "SELECT *  FROM " . global_mysql_playgrounds_table . " as playground ," . global_mysql_venues_table . " as venue ";
	$query_statement .= " WHERE venue.`sports_type` LIKE '%$sports_type%' AND playground.`locality` LIKE '%$location%' AND venue.playground_id = playground.playground_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($result) < 1)
	{
		return 0;
	}
	
	$venues = array();
	
	while($venue = mysql_fetch_array($result))
	{
		array_push( $venues , $venue );
	}
	
	return($venues);
}

function list_venue_by_id($id)
{
	//$query_statement = "SELECT * from " .global_mysql_venues_table. " WHERE id = $id";
	$query_statement = "SELECT playground_name,name,sports_type,time_slots,day_off,rate,locality,playground_location,location,contact_number from ". global_mysql_venues_table." as venues,".global_mysql_playgrounds_table. " as playgrounds where id =$id and playgrounds.playground_id = venues.playground_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	$venue = mysql_fetch_array($result);
	
	return $venue;
}

function get_venue_attribute($attribute , $venue_id)
{
	$query_statement = "SELECT $attribute from " .global_mysql_venues_table. " WHERE id = $venue_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	$venue = mysql_fetch_array($result);
	
	return $venue[$attribute];
}
?>