<?php
include_once('_includes.php');


$playgrounds = $db->Playgrounds;
$reservations = $db->Reservations;

//Create functions

function create_playground($playground_name, $playground_email, $playground_password, $locality , $address, $playground_secret_code)
{
	global $playgrounds;
	
	if(validate_email($playground_email) != true)
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
		$playground_is_admin = '1';

		//$playground_password = encrypt_password($playground_password);

		//Operation : Insert : This will Create a new playground in the database
		$playground = array(
			"Playground_name" => $playground_name, 
			"Playground_email" => $playground_email,
			"Playground_password" => encrypt_password($playground_password),
			"Playground_locality" => $locality , 
			"Playground_address" => $address,
			"Playground_venues" => array(),
			"Playground_reservations" => array()
			);

		$playgrounds->insert($playground);

		//$playground_password = strip_salt($playground_password);

		setcookie(global_cookie_prefix . '_playground_email', $playground_email, time() + 3600 * 24 * intval(global_remember_login_days));
		//setcookie(global_cookie_prefix . '_playground_password', $playground_password, time() + 3600 * 24 * intval(global_remember_login_days));

		return(1);
	}
}


//Get attribute functions

function get_venue_attribute($attribute , $venue_id)
{
	global $playgrounds;
	
	$playgroundQuery = array('Playground_venues.Venue_id' => $venue_id);

	$playgroundprojection = array( 'Playground_venues' => array('$elemMatch' => array('Venue_id' => $venue_id) ) );

	$playground= $playgrounds->findOne($playgroundQuery , $playgroundprojection);
	
	$venues = $playground['Playground_venues'];
	
	return $venues[0][$attribute];
}

function get_playground_attribute($attribute , $id)
{
	global $playgrounds;
	
	$playground = $playgrounds->findOne( array('_id' => $playground_id) , array('Playground_reservations' => false , 'Playground_password' => false) );
		
	return $playground[$attribute];
}



// Playground functions

function playground_email_exists($playground_email)
{
	$playgroundQuery = array('Playground_email' => $playground_email);
	
	global $playgrounds;

	return $playgrounds->count($playgroundQuery);
}

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
	//logout();
	if(isset($_SESSION['logged_in']))
	{
		return 1;
	}
	
	global $playgrounds;
	
	$playground_password_encrypted = encrypt_password($playground_password);
	$playground_password = add_salt($playground_password);
	
	$playgroundQuery = array('Playground_email' => $playground_email , 'Playground_password' => $playground_password_encrypted);
	
	$count = $playgrounds->count($playgroundQuery);

	if($count == 1)
	{
			$playground = $playgrounds->findOne(array('Playground_email' => $playground_email) , array('Playground_venues' => false , 'Playground_Reservations' => false));

			$_SESSION['user_id'] = $playground['_id'];
			$_SESSION['user_is_admin'] = 1;
			$_SESSION['user_email'] = $playground['Playground_email'];
			$_SESSION['user_name'] = $playground['Playground_name'];
			$_SESSION['logged_in'] = '1';
			$_SESSION['logged_in_as_playground'] = '1';
			
			if($playground_remember == '1')
			{
				$playground_password = strip_salt($playground['Playground_password']);

				setcookie(global_cookie_prefix . '_playground_email', $playground['Playground_email'], time() + 3600 * 24 * intval(global_remember_login_days));
				//setcookie(global_cookie_prefix . '_playground_password', $playground_password_encrypted, time() + 3600 * 24 * intval(global_remember_login_days));
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
	return true;
}


function list_playground_by_id ($id)
{
	global $playgrounds;
	
	$playground = $playgrounds->findOne(array('_id' => $id) , array('Playground_reservations' => false));
	
	return $playground;
}

//Venue functions

function create_or_update_venue($venue_name, $venue_sports_type, $venue_time_slots, $rate_per_time_slot, $venue_location, $venue_contact_number,$venue_day_off, $venue_id='')
{
	global $playgrounds;
	
	$id = $_SESSION['user_id'];
	
	$playground = $playgrounds->findOne( array('_id' => $id) , array('Playground_reservations' => false , 'Playground_venues' => false) );
	
	$venue = array(
				'Venue_id' => str_replace(' ', '', $playground['Playground_name'].$playground['Playground_locality'].$venue_name) ,
				'Venue_name' => $venue_name,
				'Venue_sports_type' => $venue_sports_type,
				'Venue_time_slots' => $venue_time_slots,
				'Venue_rate_per_time_slot' => $rate_per_time_slot,
				'Venue_location' => $venue_location,
				'Venue_contact_number' => $venue_contact_number,
				'Venue_day_off' => $venue_day_off
	);
	
	if($venue_id == '')
	{
		$playgrounds->update(array('_id' => $id),array('$push' => array('Playground_venues' => $venue)));
	}
	else
	{
	//Update
	}
	return 1;
}

function delete_venue_data($venue_id , $data)
{
	//Todo
	return(1);
}

function list_venues($playground_id = '')
{
	global $playgrounds;
	
	if($playground_id == '')
	{
		$playground_id = $_SESSION['user_id'];
	}

	$playground = $playgrounds->findOne( array('_id' => $playground_id) , array('Playground_reservations' => false ) );
	
	$playground_venues = $playground['Playground_venues'];

	if(sizeof($playground_venues) < 1)
	{
		return('<span class="error_span">You have not added any venues. Add one below.</span>');
	}
	
	$venues = '<table id="venues_table"><tr><th>Venue Name</th><th>Venue sports type</th><th>Venue time slots</th><th>Rate</th><th>Venue Location</th><th>Contact Number</th><th></th></tr>';

	for($i=0; $i < sizeof($playground_venues) ;$i++)
	{
		$venue = $playground_venues[$i];
		
		$venues .= '<tr id="venue_tr_' . $venue['Venue_id'] .'"><td>';
		$venues .= '<label for="venue_radio_' . $venue['Venue_name'] . '">' . $venue['Venue_name'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['Venue_sports_type'] . '">' . $venue['Venue_sports_type'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['Venue_time_slots'] . '">' . $venue['Venue_time_slots'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['Venue_rate_per_time_slot'] . '">' . $venue['Venue_rate_per_time_slot'] . '</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['Venue_location'] . '">' . $venue['Venue_location'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['Venue_contact_number'] . '">' . $venue['Venue_contact_number'] .'</label></td><td>';
		$venues .= '<input type="radio" name="venue_radio" class="venue_radio" id="venue_radio_' . $venue['Venue_id'] . '" value="' . $venue['Venue_id'] . '">';
		$venues .= '</td></tr>';
	}

	$venues .= '</table>';

	return($venues);
}

function list_playgrounds_and_venues_by_name($name)
{
	//Todo
}

function list_venues_by_sports_location( $sports_type , $location)
{
	global $playgrounds;
	
	if($location == '' )
	{
		return('<span class="error_span">Please enter a location to search</span>');
	}
	//regex to search by location
	$locationregex = new MongoRegex("/$location/i");
	
	if($sports_type != '')
	{
		//regex to search by sports type 
		$sportsregex = new MongoRegex("/$sports_type/i"); 
		$playgroundQuery = array('Playground_locality' => $locationregex , 'Playground_sports_type' => $sportsregex);
	}
	else
	{
		$playgroundQuery = array('Playground_locality' => $locationregex);
	}
	
	$playgroundprojection = array('Playground_reservations' => false); //Projection is used to hide attributes from collection. In this case Playground_reservations will not be shown

	$cursor = $playgrounds->find($playgroundQuery , $playgroundprojection);
	
	$venues = array();

	foreach ($cursor as $playground) {
		foreach($playground['Playground_venues'] as $venue)
		{
			$index = array_push( $venues , $venue );
			$index --;
			$venues[$index]['Venue_playground_name'] = $playground['Playground_name'] ;
			$venues[$index]['Venue_playground_locality'] = $playground['Playground_locality'] ;
			$venues[$index]['Venue_playground_address'] = $playground['Playground_address'] ;
		}
	}
	
	return($venues);
}

function list_venue_by_id($id)
{
	global $playgrounds;
	
	$playgroundprojection = array( 
							'Playground_name' => true,
							'Playground_locality' => true,
							'Playground_address' => true,
							'Playground_venues' => array(
													'$elemMatch' => array(
																'Venue_id' => $id
																		) 
														)
								);
	
	$playground = $playgrounds->findOne(array('Playground_venues.Venue_id' => $id) , $playgroundprojection);
	
	$venue = $playground['Playground_venues'][0];
	$venue['Venue_playground_name'] = $playground['Playground_name'] ;
	$venue['Venue_playground_locality'] = $playground['Playground_locality'] ;
	$venue['Venue_playground_address'] = $playground['Playground_address'] ;
	
	/* $venue['Venue_reservations'] = array();
	
	foreach($playground['Playground_reservations'] as $reservation)
	{
		array_push($venue['Venue_reservations'] , $reservation);
	} */
	
	$_SESSION['venue'] = $venue; 
	
	return($venue);
}



// Reservations

function highlight_day($day)
{
	$day = str_ireplace(global_day_name, '<span id="today_span">' . global_day_name . '</span>', $day);
	return $day;
}

function read_reservation($venue_id, $week, $day, $time)
{
	$day_off = $_SESSION['venue']['Venue_day_off'];
	
	//Check day offs
	$pos = strpos($day_off,(string)$day);
			
	if($pos !== false)
	{
		//If booking not allowed for that day
		return ("Booking not allowed");
	}
	
	//If booking allowed for that day , search if already booked
	$reservations = $_SESSION['venue']['Venue_reservations'];
	
	foreach($reservations as $reservation)
	{
		if($reservation['Reservation_week'] == $week && $reservation['Reservation_day'] == $day && $reservation['Reservation_time'] == $time)
		{
			return "Booked";
		}
	}
	
	return "";
}

function prepare_reservation_chart_week($week)
{
	//For each week prepare chart
	
	$venue_times = explode(';', $_SESSION['venue']['Venue_time_slots']);
	$day_off = $_SESSION['venue']['Venue_day_off'];
	
	
	//Fill the chart with blank values : O(time_slots * 7) = O(time_slots)
	$chart = array();
	foreach($venue_times as $time)
	{
		$chart[$time] = array();
		for($i=1;$i<=7;$i++)
		{
			//Check day offs
			$pos = strpos($day_off,(string)$i);
					
			if($pos !== false)
			{
				//If booking not allowed for that day
				$chart[$time][$i] = "Booking not allowed";
			}
			else
			{
				$chart[$time][$i] = "";
			}
		}
	}
	
	//Get reservations for that week
	global $playgrounds;
	global $reservations;
	
	$cursor = $reservations->find(array(
					'Reservation_venue_id' => $_SESSION['venue']['Venue_id'] ,
					'Reservation_week' => $week
				));
	
	//for each $cursor fill the $chart matrix	: O(time_slots * 7) = O(time_slots)
	foreach($cursor as $reservation)
	{
		$chart[$reservation['Reservation_time']][$reservation['Reservation_day']] = "Booked" ;
	}
	
	
	return $chart;
	
	//Total running time : O(time_slots)
}

function read_reservation_from_database($venue_id, $week, $day, $time)
{
	$day_off = $_SESSION['venue']['Venue_day_off'];
	
	//Check day offs
	$pos = strpos($day_off,(string)$day);
			
	if($pos !== false)
	{
		//If booking not allowed for that day
		return ("Booking not allowed");
	}
	
	//If booking allowed for that day , search if already booked
	
	
	global $reservations;
	
	$count = $reservations->count(
				array(
					'Reservation_venue_id' => $venue_id ,
					'Reservation_week' => $week  ,
					'Reservation_day' => $day,
					'Reservation_time' => $time
					) 
				);
	
	if($count > 0)
	{
		return "Booked";
	}
		
	return "";
}


function read_reservation_details($venue_id, $week, $day, $time)
{
	//Allow this only for the owner of the venue
	/*
	if( !isset($_SESSION['logged_in_as_playground']) )
	{
		return 0;
	}
	$playground_id = $_SESSION['user_id'];
	if($playground_id  != get_venue_attribute('playground_id', $venue_id))
	{
		return 0;
	}
	
	$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_venue_id='$venue_id'  AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	$reservation = mysql_fetch_array($query);

	if(empty($reservation))
	{
		return(0);	
	}
	else
	{
		return('<b>Reservation made:</b> ' . $reservation['reservation_made_time'] . '<br><b>User\'s email:</b> ' . $reservation['reservation_user_email']);
	}
	*/
}

function make_reservation($venue_id, $week, $day, $time)
{
	$user_id = $_SESSION['user_id'];
	$user_email = $_SESSION['user_email'];
	$user_name = $_SESSION['user_name'];
	
	//Check if day is allowed at venue
	
	//get day off
	$day_off = $_SESSION['venue'][''];
	//Check day offs
	$pos = strpos($day_off,(string)$day);
	if($pos !== false)
	{
		return('This day is not available at the venue');
	}
	
	//Check if time it is allowed at the venue
	
	//get time slots
	$time_slots = get_venue_attribute('time_slots',$venue_id);
	//check time slot
	$pos = strpos($time_slots, $time);
	if($pos === false)
	{
		return('This time slot is not available at the venue');
	}
	
	//Get price from the venue details
	$price = get_venue_attribute('rate',$venue_id);
	
	if($week == '0' && $day == '0' && $time == '0')
	{
		//Currently not allowing this
		return('You can\'t register a booking like this');
		/*
		mysql_query("INSERT INTO " . global_mysql_reservations_table . " (reservation_venue_id,reservation_made_time,reservation_week,reservation_day,reservation_time,reservation_price,reservation_user_id,reservation_user_email,reservation_user_name) VALUES ('$venue_id',now(),'$week','$day','$time','$price','$user_id','$user_email','$user_name')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		return(1);
		*/
	}
	elseif($week < global_week_number && $_SESSION['user_is_admin'] != '1' || $week == global_week_number && $day < global_day_number && $_SESSION['user_is_admin'] != '1')
	{
		return('You can\'t reserve back in time');
	}
	elseif($week > global_week_number + global_weeks_forward && $_SESSION['user_is_admin'] != '1')
	{
		return('You can only reserve ' . global_weeks_forward . ' weeks forward in time');
	}
	else
	{
		$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_venue_id = '$venue_id' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		if(mysql_num_rows($query) < 1)
		{
			$year = global_year;

			mysql_query("INSERT INTO " . global_mysql_reservations_table . " (reservation_venue_id,reservation_made_time,reservation_year,reservation_week,reservation_day,reservation_time,reservation_price,reservation_user_id,reservation_user_email,reservation_user_name) VALUES ('$venue_id',now(),'$year','$week','$day','$time','$price','$user_id','$user_email','$user_name')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

			return(1);
		}
		else
		{
			return('Someone else just reserved this time');
		}
	}
}

function delete_reservation($venue_id, $week, $day, $time)
{
	if($week < global_week_number && $_SESSION['user_is_admin'] != '1' || $week == global_week_number && $day < global_day_number && $_SESSION['user_is_admin'] != '1')
	{
		return('You can\'t reserve back in time');
	}
	elseif($week > global_week_number + global_weeks_forward && $_SESSION['user_is_admin'] != '1')
	{
		return('You can only reserve ' . global_weeks_forward . ' weeks forward in time');
	}
	else
	{
		$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE  reservation_venue_id = '$venue_id' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
		$user = mysql_fetch_array($query);

		if($user['reservation_user_id'] == $_SESSION['user_id'] || $_SESSION['user_is_admin'] == '1')
		{
			mysql_query("DELETE FROM " . global_mysql_reservations_table . " WHERE  reservation_venue_id = '$venue_id' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

			return(1);
		}
		else
		{
			return('You can\'t remove other users\' reservations');
		}
	}
}

?>