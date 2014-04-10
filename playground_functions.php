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
	$playground_password_encrypted = encrypt_password($playground_password);
	$playground_password = add_salt($playground_password);
	
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_email='$playground_email' AND playground_password='$playground_password_encrypted' OR playground_email='$playground_email' AND playground_password='$playground_password'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) == 1)
	{
			$playground = mysql_fetch_array($query);

			$_SESSION['user_id'] = $playground['playground_id'];
			$_SESSION['user_is_admin'] = $playground['playground_is_admin'];
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

function create_playground($playground_name, $playground_email, $playground_password, $playground_secret_code)
{
	if(validate_user_name($playground_name) != true)
	{
		return('<span class="error_span">Name must be <u>letters only</u> and be <u>2 to 12 letters long</u>. If your name is longer, use a short version of your name</span>');
	}
	elseif(validate_user_email($playground_email) != true)
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
	/*
	elseif(playground_name_exists($playground_name) == true)
	{
		return('<span class="error_span">Name is already in use. If you have the same name as someone else, use another spelling that identifies you</span>');
	}*/
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

		mysql_query("INSERT INTO " . global_mysql_playgrounds_table . " (playground_is_admin,playground_email,playground_password,playground_name,playground_reservation_reminder) VALUES ($playground_is_admin,'$playground_email','$playground_password','$playground_name','0')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		$playground_password = strip_salt($playground_password);

		setcookie(global_cookie_prefix . '_playground_email', $playground_email, time() + 3600 * 24 * intval(global_remember_login_days));
		setcookie(global_cookie_prefix . '_playground_password', $playground_password, time() + 3600 * 24 * intval(global_remember_login_days));

		return(1);
	}
}

function list_venues()
{
$query = mysql_query("SELECT * FROM " . global_mysql_users_table . " ORDER BY user_is_admin DESC, user_name")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	$users = '<table id="users_table"><tr><th>Venue Name</th><th>Venue sports type</th><th>Venue time slots</th><th>Rate per time slot</th><th>Venue Location</th><th>Usage</th><th>Contact Number</th><th></th></tr>';

	while($user = mysql_fetch_array($query))
	{
		$users .= '<tr id="user_tr_' . $user['user_id'] . '"><td><label for="user_radio_' . $user['user_id'] . '">' . $user['user_id'] . '</label></td><td>' . $user['user_is_admin'] . '</td><td><label for="user_radio_' . $user['user_id'] . '">' . $user['user_name'] . '</label></td><td><label for="user_radio_' . $user['user_id'] . '">' . $user['user_email'] . '</label></td><td>' . $user['user_reservation_reminder'] . '</td><td>' . count_reservations($user['user_id']) . '</td><td>' . cost_reservations($user['user_id']) . ' ' . global_currency . '</td><td><input type="radio" name="user_radio" class="user_radio" id="user_radio_' . $user['user_id'] . '" value="' . $user['user_id'] . '"></td></tr>';
	}

	$users .= '</table>';

	return($users);
	/*$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_is_admin='1' ORDER BY playground_name")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) < 1)
	{
		return('<span class="error_span">There are no admins</span>');
	}
	else
	{
		$return = '<table id="forgot_password_table"><tr><th>Name</th><th>Email</th></tr>';

		$i = 0;

		while($playground = mysql_fetch_array($query))
		{
			$i++;

			$return .= '<tr><td>' . $playground['playground_name'] . '</td><td><span id="email_span_' . $i . '"></span></td></tr><script type="text/javascript">$(\'#email_span_' . $i . '\').html(\'<a href="mailto:\'+$.base64.decode(\'' . base64_encode($playground['playground_email']) . '\')+\'">\'+$.base64.decode(\'' . base64_encode($playground['playground_email']) . '\')+\'</a>\');</script>';
		}

		$return .= '</table>';

		return($return);
	}*/
}

?>