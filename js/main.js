// Show pages
function showhomepage()
{
	showsearchpage();
}

function showsearchpage()
{
	page_load();
	div_hide('#content_div');
	$.get('searchpage.php', function(data) 
	{ 
		$('#content_div').html(data); 
		div_fadein('#content_div'); 
		page_loaded(); 
	}); 
}

function showsearch(game_type,location)
{
	showsearchpage();
	searchvenue(game_type,location);
}

function setwindowlocation(input)
{
	switch(input)
	{
		case 'game_type_location' :
			var game_type = $('#game_type_input').val();
			var location = $('#location_input').val();
			loc = '?search' + '=' + game_type +'=' + location;
			window.location.replace(loc);
			break;
		default:
			window.location.replace('.');
			break;
	}
}

function showdashboard()
{
	if(typeof session_logged_in != 'undefined')
	{
		if(typeof session_logged_in_as_playground != 'undefined')
		{
			showplaygroundlandingpage();
		}
		else
		{
			showreservations();
		}
	}
}

function showabout()
{
	page_load();
	div_hide('#content_div');
	$.get('about.php', function(data) { $('#content_div').html(data); div_fadein('#content_div'); page_loaded('about'); });
}

function showlogin()
{
	page_load();
	div_hide('#content_div');

	$.get('login.php', function(data)
	{
		$('#content_div').html(data); 
		div_fadein('#content_div');
		page_loaded();

		var user_email = $('#user_email_input').val();
		var user_password = $('#user_password_input').val();

		if(user_email != '' && user_password != '')
		{
			setTimeout(function() { $('#login_form').submit(); }, 250);
		}
		else
		{
			input_focus('#user_email_input');
		}
	});
}
function showplaygroundlogin()
{
	page_load();
	div_hide('#content_div');

	$.get('playgroundlogin.php', function(data)
	{
		$('#content_div').html(data); 
		div_fadein('#content_div');
		page_loaded();

		var playground_email = $('#playground_email_input').val();
		var playground_password = $('#playground_password_input').val();

		if(playground_email != '' && playground_password != '')
		{
			setTimeout(function() { $('#playground_login_form').submit(); }, 250);
		}
		else
		{
			input_focus('#playground_email_input');
		}
	});
}

function shownew_user()
{
	page_load();
	div_hide('#content_div');
	$.get('login.php?new_user', function(data) { $('#content_div').html(data); div_fadein('#content_div'); page_loaded(); input_focus('#user_name_input'); });
	
}

function shownew_playground()
{
	page_load();
	div_hide('#content_div');
	$.get('playgroundlogin.php?new_playground', function(data) { $('#content_div').html(data); div_fadein('#content_div'); page_loaded(); input_focus('#playground_name_input'); });
	
}

function showforgot_password()
{
	page_load();
	div_hide('#content_div');
	$.get('login.php?forgot_password', function(data) { $('#content_div').html(data); div_fadein('#content_div'); page_loaded(); });
	
}

function showreservations()
{
	div_hide('#reservation_result_div');

	$.get('reservation.php', function(data)
	{
		$('#reservation_result_div').html(data);
		div_fadein('#reservation_result_div');
		
		venue_id = window.venue_id;
		
		$.get('reservation.php?week',{'week': global_week_number , 'venue_id' : venue_id}, function(data)
		{
			$('#reservation_table_div').html(data).slideDown('slow', function() { setTimeout(function() { div_fadein('#reservation_table_div'); }, 250); });
			page_loaded();
		});
	}); 
}

function searchvenue(game_type , location)
{
	page_load();
	
	$.get('searchpage.php?search' , {sports_type : game_type, location : location} , 
	function(data) {
			$('#search_results').html(data);
			$('#game_type_input').val(game_type);
			$('#location_input').val(location);
		});
}

function showvenue(id)
{
	page_load();
	div_hide('#content_div');
	$.get('venue.php',{id : id} , 
	function(data) 
	{ 
		window.venue_id = id;
		$('#content_div').html(data); 
		div_fadein('#content_div'); 
		page_loaded(); 
	});
}

function showplaygroundlandingpage()
{
	page_load();
	div_hide('#content_div');

	$.get('playgroundlandingpage.php', function(data)
	{
		$('#content_div').html(data);
		div_fadein('#content_div');
		page_loaded();
	});
}

function showweek(week, option)
{
	if(week == 'next')
	{
		var week = parseInt($('#week_number_span').html()) + 1;
	}
	else if(week == 'previous')
	{
		var week = parseInt($('#week_number_span').html()) - 1;
	}
	else
	{
		var week = parseInt(week);
	}

	if(isNaN(week))
	{
		notify('Invalid week number', 4);
	}
	else
	{
		if(week < 1)
		{
			var week = 52;
		}
		else if(week > 52)
		{
			var week = 1;
		}

		page_load('week');
		div_hide('#reservation_table_div');
			
		venue_id = window.venue_id;

		$.get('reservation.php?week',{'week': week , 'venue_id' : venue_id}, function(data)
		{
			$('#reservation_table_div').html(data);
			$('#week_number_span').html(week);
			div_fadein('#reservation_table_div');
			page_loaded('week');

			if(week != global_week_number)
			{
				$('#reservation_today_button').css('visibility', 'visible');
			}

			if(option == 'today')
			{
				setTimeout(function() { $('#today_span').animate({ opacity: 0 }, 250, function() { $('#today_span').animate({ opacity: 1 }, 250);  }); }, 500);
			}
		});
	}
}

function showcp()
{
	page_load();
	div_hide('#content_div');
	$.get('cp.php', function(data) { $('#content_div').html(data); div_fadein('#content_div'); page_loaded(); });
}

function showhelp()
{
	page_load();
	div_hide('#content_div');
	$.get('help.php', function(data) { $('#content_div').html(data); div_fadein('#content_div'); page_loaded(); });
}

// Page load

function page_load(page)
{
	// All
	setTimeout(function()
	{
		if($('#content_div').css('opacity') == 0)
		{
			notify('Loading...', 300);
		}
	}, 500);

	// Individual
	if(page == 'reservation')
	{
		setTimeout(function()
		{
			if($('#reservation_table_div').is(':hidden'))
			{
				notify('Loading...', 300);
			}
		}, 500);
	}	
	else if(page == 'week')
	{
		setTimeout(function()
		{
			if($('#reservation_table_div').css('opacity') == 0)
			{
				notify('Loading...', 300);
			}
		}, 500);
	}
}

function page_loaded(page)
{
	// All
	$.get('main.php?day_number', function(data)
	{
		if(data != global_day_number)
		{
			notify('Day have changed. Refreshing...', '300');
			setTimeout(function() { window.location.replace('.'); }, 2000);
		}
	});

	setTimeout(function()
	{
		if($('#notification_inner_cell_div').is(':visible') && $('#notification_inner_cell_div').html() == 'Loading...')
		{
			notify();
		}
	}, 1000);

	//read_reservation_details();

	// Individual
	if(page == 'about')
	{
		$('#about_latest_version_p').html('<img src="img/loading.gif" alt="Loading"> Getting latest version...');

		setTimeout(function()
		{
			$.get('main.php?latest_version', function(data)
			{
				if($('#about_latest_version_p').length)
				{
					$('#about_latest_version_p').html(data);
				}
			});
		}, 1000);
	}
}

// User Login

function login()
{
	var user_email = $('#user_email_input').val();
	var user_password = $('#user_password_input').val();

	$('#login_message_p').html('<img src="img/loading.gif" alt="Loading"> Logging in...').slideDown('fast');

	var remember_me_checkbox = $('#remember_me_checkbox').prop('checked');

	if(remember_me_checkbox)
	{
		var user_remember = 1;
	}
	else
	{
		var user_remember = 0;
	}

	$.post('login.php?login', { user_email: user_email, user_password: user_password, user_remember: user_remember }, function(data)
	{
		if(data == 1)
		{
			input_focus();
			setTimeout(function() { window.location.replace('.'); }, 1000);
		}
		else
		{
			if(data == '')
			{
				$('#login_message_p').html('<span class="error_span">Wrong email and/or password</span>');
				$('#user_email_input').val('');
				$('#user_password_input').val('');
				input_focus('#user_email_input');
			}
			else
			{
				$('#login_message_p').html(data);
			}
		}
	});
}

//Playground login
function playgroundlogin()
{
	var playground_email = $('#playground_email_input').val();
	var playground_password = $('#playground_password_input').val();

	$('#login_message_p').html('<img src="img/loading.gif" alt="Loading"> Logging in...').slideDown('fast');

	var remember_me_checkbox = $('#remember_me_checkbox').prop('checked');

	if(remember_me_checkbox)
	{
		var playground_remember = 1;
	}
	else
	{
		var playground_remember = 0;
	}

	$.post('playgroundlogin.php?login', { playground_email: playground_email, playground_password: playground_password, playground_remember: playground_remember }, function(data)
	{
		if(data == 1)
		{
			input_focus();
			setTimeout(function() { window.location.replace('.'); }, 1000);
		}
		else
		{
			if(data == '')
			{
				$('#login_message_p').html('<span class="error_span">Wrong email and/or password</span>');
				$('#playground_email_input').val('');
				$('#playground_password_input').val('');
				input_focus('#playground_email_input');
			}
			else
			{
				$('#login_message_p').html(data);
			}
		}
	});
}

function logout()
{
	notify('Logging out...', 300);
	$.get('login.php?logout', function(data) { setTimeout(function() { window.location.replace('.'); }, 1000); });
}

function create_user()
{
	var user_name = $('#user_name_input').val();
	var user_email = $('#user_email_input').val();
	var user_password = $('#user_password_input').val();
	var user_password_confirm = $('#user_password_confirm_input').val();

	if($('#user_secret_code_input').length)
	{
		var user_secret_code =  $('#user_secret_code_input').val();
	}
	else
	{
		var user_secret_code = '';
	}

	if(user_password != user_password_confirm)
	{
		$('#new_user_message_p').html('<span class="error_span">Passwords do not match</span>').slideDown('fast');
		$('#user_password_input').val('');
		$('#user_password_confirm_input').val('');
		input_focus('#user_password_input');
	}
	else
	{
		$('#new_user_message_p').html('<img src="img/loading.gif" alt="Loading"> Creating user...').slideDown('fast');

		$.post('login.php?create_user', { user_name: user_name, user_email: user_email, user_password: user_password, user_secret_code: user_secret_code }, function(data)
		{
			if(data == 1)
			{
				input_focus();

				setTimeout(function()
				{
					$('#new_user_message_p').html('User created successfully! Logging in... <img src="img/loading.gif" alt="Loading">');
					setTimeout(function() { window.location.replace('#login'); }, 2000);
				}, 1000);
			}
			else
			{
				input_focus();
				$('#new_user_message_p').html(data);
			}
		});
	}
}

function create_playground()
{
	var playground_name = $('#playground_name_input').val();
	var playground_email = $('#playground_email_input').val();
	var playground_password = $('#playground_password_input').val();
	var playground_password_confirm = $('#playground_password_confirm_input').val();
	var playground_address = $('#address_input').val();
	var playground_locality = $('#locality_input').val();

	if($('#playground_secret_code_input').length)
	{
		var playground_secret_code =  $('#playground_secret_code_input').val();
	}
	else
	{
		var playground_secret_code = '';
	}

	if(playground_password != playground_password_confirm)
	{
		$('#new_playground_message_p').html('<span class="error_span">Passwords do not match</span>').slideDown('fast');
		$('#playground_password_input').val('');
		$('#playground_password_confirm_input').val('');
		input_focus('#playground_password_input');
	}
	else
	{
		$('#new_playground_message_p').html('<img src="img/loading.gif" alt="Loading"> Creating playground...').slideDown('fast');

		$.post('playgroundlogin.php?create_playground', { playground_name: playground_name, locality_input:playground_locality , address_input: playground_address ,playground_email: playground_email, playground_password: playground_password, playground_secret_code: playground_secret_code }, function(data)
		{
			if(data == 1)
			{
				input_focus();

				setTimeout(function()
				{
					$('#new_playground_message_p').html('playground created successfully! Logging in... <img src="img/loading.gif" alt="Loading">');
					setTimeout(function() { window.location.replace('#playgroundlogin'); }, 2000);
				}, 1000);
			}
			else
			{
				input_focus();
				$('#new_playground_message_p').html(data);
			}
		});
	}
}

function create_venue()
{
	var venue_id = '';
	if($('#venue_id_input').length)
	{
		venue_id = $('#venue_id_input').val();
	}
	var venue_name = $('#venue_name_input').val();
	var venue_sports_type = $('#venue_sports_type_input').val();
	var venue_time = $('#venue_time_input').val();
	var venue_rate = $('#venue_rate_input').val();
	var venue_location = $('#venue_location_input').val();
	var venue_contact_number = $('#venue_contact_number_input').val();
	
	$('#new_venue_message_p').html('<img src="img/loading.gif" alt="Loading"> Creating Venue...').slideDown('fast');

	$.post('playgroundlandingpage.php?create_venue', { venue_name: venue_name, venue_sports_type: venue_sports_type, venue_time_slots: venue_time, rate_per_time_slot: venue_rate, venue_location: venue_location, venue_contact_number: venue_contact_number }, function(data)
	{
		if(data == 1)
		{
			input_focus();

			setTimeout(function()
			{
				$('#new_venue_message_p').html('venue created successfully!');
				location.reload();
			}, 1000);
		}
		else
		{
			input_focus();
			$('#new_venue_message_p').html(data);
		}
	});
}

// Reservation

function toggle_reservation_time(id, week, day, time, from)
{
	venue_id = window.venue_id;
	
	if(session_user_is_admin == '1')
	{
		if(week < global_week_number || week == global_week_number && day < global_day_number)
		{
			notify('You are reserving back in time. You can do that because you\'re an admin', 4);
		}
		else if(week > global_week_number + global_weeks_forward)
		{
			notify('You are reserving more than '+global_weeks_forward+' weeks forward in time. You can do that because you\'re an admin', 4);
		}
	}

	var user_name = $(id).html();

	if(user_name == '')
	{
		$(id).html('Wait...'); 

		$.post('reservation.php?make_reservation', { venue_id: venue_id, week: week, day: day, time: time }, function(data) 
		{
			if(data == 1)
			{
				setTimeout(function() { read_reservation(id, week, day, time); }, 1000);
			}
			else
			{
				notify(data, 4);
				setTimeout(function() { read_reservation(id, week, day, time); }, 2000);			
			}
		});
	}
	else
	{
		if(offclick_event == 'mouseup' || from == 'details')
		{
			if(user_name == 'Wait...')
			{
				notify('One click is enough', 4);
			}
			else if(user_name == session_user_name || session_user_is_admin == '1')
			{
				if(user_name != session_user_name && session_user_is_admin == '1')
				{
					var delete_confirm = confirm('This is not your reservation, but because you\'re an admin you can remove other users\' reservations. Are you sure you want to do this?');
				}
				else
				{
					var delete_confirm = true;
				}

				if(delete_confirm)
				{
					$(id).html('Wait...');

					$.post('reservation.php?delete_reservation', { venue_id: venue_id, week: week, day: day, time: time }, function(data)
					{
						if(data == 1)
						{
							setTimeout(function() { read_reservation(id, week, day, time); }, 1000);
						}
						else
						{
							notify(data, 4);
							setTimeout(function() { read_reservation(id, week, day, time); }, 2000);
						}
					});
				}
			}
			else
			{
				notify('You can\'t remove other users\' reservations', 2);
			}

			if($('#reservation_details_div').is(':visible'))
			{
				read_reservation_details();
			}
		}
	}
}

function read_reservation(id, week, day, time)
{
	venue_id = window.venue_id;
	
	$.post('reservation.php?read_reservation', { venue_id:venue_id, week: week, day: day, time: time }, function(data) { $(id).html(data); });
}

function read_reservation_details(id, week, day, time)
{
	venue_id = window.venue_id;
		
	if(typeof id != 'undefined' && $(id).html() != '' && $(id).html() != 'Wait...')
	{
		if($('#reservation_details_div').is(':hidden'))
		{
			var position = $(id).position();
			var top = position.top + 50;
			var left = position.left - 100;

			$('#reservation_details_div').html('Getting details...');
			$('#reservation_details_div').css('top', top+'px').css('left', left+'px');
			$('#reservation_details_div').fadeIn('fast');

			reservation_details_id = id;
			reservation_details_week = week;
			reservation_details_day = day;
			reservation_details_time = time;

			$.post('reservation.php?read_reservation_details', { venue_id: venue_id, week: week, day: day, time: time }, function(data)
			{
				setTimeout(function()
				{
					if(data == 0)
					{
						$('#reservation_details_div').html('This reservation no longer exists. Wait...');
						
						setTimeout(function()
						{
							if($('#reservation_details_div').is(':visible') && $('#reservation_details_div').html() == 'This reservation no longer exists. Wait...')
							{
								read_reservation(reservation_details_id, reservation_details_week, reservation_details_day, reservation_details_time);
								read_reservation_details();
							}
						}, 2000);
					}
					else
					{
						$('#reservation_details_div').html(data);

						if(offclick_event == 'touchend')
						{
							if($(reservation_details_id).html() == session_user_name || session_user_is_admin == '1')
							{
								var delete_link_html = '<a href="." onclick="toggle_reservation_time(reservation_details_id, reservation_details_week, reservation_details_day, reservation_details_time, \'details\'); return false">Delete</a> | ';
							}
							else
							{
								var delete_link_html = '';
							}

							$('#reservation_details_div').append('<br><br>'+delete_link_html+'<a href="." onclick="read_reservation_details(); return false">Close this</a>');
						}
					}
				}, 500);
			});
		}
	}
	else
	{
		$('div#reservation_details_div').fadeOut('fast');
	}
}

// Admin control panel

function list_users()
{
	$.get('cp.php?list_users', function(data) { $('#users_div').html(data); });
}

function reset_user_password()
{
	if(typeof $(".user_radio:checked").val() !='undefined')
	{
		var user_id = $(".user_radio:checked").val();

		$('#user_administration_message_p').html('<img src="img/loading.gif" alt="Loading"> Resetting password...').slideDown('fast');

		$.post('cp.php?reset_user_password', { user_id: user_id }, function(data)
		{
			if(data == 0)
			{
				$('#user_administration_message_p').html('<span class="error_span">You can change your password at the bottom of this page</span>').slideDown('fast');
			}
			else
			{
				setTimeout(function() { $('#user_administration_message_p').html(data); }, 1000);
			}
		});
	}
	else
	{
		$('#user_administration_message_p').html('<span class="error_span">You must pick a user</span>').slideDown('fast');
	}
}

function change_user_permissions()
{
	if(typeof $(".user_radio:checked").val() !='undefined')
	{
		var user_id = $(".user_radio:checked").val();

		$('#user_administration_message_p').html('<img src="img/loading.gif" alt="Loading"> Changing permissions...').slideDown('fast');

		$.post('cp.php?change_user_permissions', { user_id: user_id }, function(data)
		{
			if(data == 1)
			{
				setTimeout(function()
				{
					list_users();
					$('#user_administration_message_p').html('Permissions changed successfully. The user must re-login to get the new permissions');
				}, 1000);
			}
			else
			{
				$('#user_administration_message_p').html(data);
			}
		});
	}
	else
	{
		$('#user_administration_message_p').html('<span class="error_span">You must pick a user</span>').slideDown('fast');
	}
}

function delete_user_data(delete_data)
{
	if(typeof $(".user_radio:checked").val() !='undefined')
	{
		var delete_confirm = confirm('Are you sure?');

		if(delete_confirm)
		{
			var user_id = $(".user_radio:checked").val();

			$('#user_administration_message_p').html('<img src="img/loading.gif" alt="Loading"> Deleting...').slideDown('fast');

			$.post('cp.php?delete_user_data', { user_id: user_id, delete_data: delete_data }, function(data)
			{
				if(data == 1)
				{
					setTimeout(function()
					{
						$('#user_administration_message_p').slideUp('fast', function()
						{
							if(delete_data == 'reservations')
							{
								list_users();
								get_usage();
							}
							else if(delete_data == 'user')
							{
								list_users();
							}
						});
					}, 1000);
				}
				else
				{
					$('#user_administration_message_p').html(data);
				}
			});
		}
	}
	else
	{
		$('#user_administration_message_p').html('<span class="error_span">You must pick a user</span>').slideDown('fast');
	}
}

function delete_all(delete_data)
{
	if(delete_data == 'reservations')
	{
		var delete_confirm = confirm('Are you sure you want to delete ALL reservations? Database backup is a good idea!');
	}
	else if(delete_data == 'users')
	{
		var delete_confirm = confirm('Are you sure you want to delete ALL users? Database backup is a good idea!');
	}
	else if(delete_data == 'everything')
	{
		var delete_confirm = confirm('Are you sure you want to delete EVERYTHING (including you)? The first user created afterwards will become admin. Database backup is a good idea!');
	}

	if(delete_confirm)
	{
		$('#database_administration_message_p').html('<img src="img/loading.gif" alt="Loading"> Deleting...').slideDown('fast');

		$.post('cp.php?delete_all', { delete_data: delete_data }, function(data)
		{
			if(data == 1)
			{
				setTimeout(function()
				{
					if(delete_data == 'everything')
					{
						window.location.replace('#logout');
					}
					else
					{
						list_users();
						$('#database_administration_message_p').slideUp('fast');
					}
				}, 1000);
			}
			else
			{
				$('#database_administration_message_p').html(data);
			}
		});
	}
}

function save_system_configuration()
{
	var price = $('#price_input').val();

	$('#system_configuration_message_p').html('<img src="img/loading.gif" alt="Loading"> Saving...');
	$('#system_configuration_message_p').slideDown('fast');

	$.post('cp.php?save_system_configuration', { price: price }, function(data)
	{
		if(data == 1)
		{
			input_focus();

			setTimeout(function()
			{
				$('#system_configuration_message_p').slideUp('fast', function()
				{
					get_usage();
				});
			}, 1000);
		}
		else
		{
			input_focus('#price_input');
			$('#system_configuration_message_p').html(data);
		}
	});
}

// User control panel

function get_usage()
{
	$.get('cp.php?get_usage', function(data) { $('#usage_div').html(data); });
}

function get_reservation_reminders()
{
	$.get('cp.php?get_reservation_reminders', function(data) { $('#reservation_reminders_span').html(data); });
}

function add_one_reservation()
{		
	venue_id = window.venue_id;
	
	$('#usage_message_p').html('<img src="img/loading.gif" alt="Loading"> Saving...').slideDown('fast');

	$.post('reservation.php?make_reservation', { venue_id: venue_id, week: '0', day: '0', time: '0' }, function(data)
	{
		if(data == 1)
		{
			setTimeout(function()
			{
				if($('#users_div').length)
				{
					list_users();
				}

				get_usage();
				$('#usage_message_p').slideUp('fast');
			}, 1000);
		}
		else
		{
			$('#usage_message_p').html(data);
		}
	});
}

function toggle_reservation_reminder()
{
	$('#settings_message_p').html('<img src="img/loading.gif" alt="Loading"> Saving...').slideDown('fast');

	$.post('cp.php?toggle_reservation_reminder', function(data)
	{
		if(data == 1)
		{
			setTimeout(function()
			{
				if($('#users_div').length)
				{
					list_users();		
				}

				get_reservation_reminders();
				$('#settings_message_p').slideUp('fast');
			}, 1000);
		}
		else
		{
			$('#settings_message_p').html(data);
		}
	});
}

function change_user_details()
{
	var user_name = $('#user_name_input').val();
	var user_email = $('#user_email_input').val();
	var user_password = $('#user_password_input').val();
	var user_password_confirm = $('#user_password_confirm_input').val();

	if(user_password != user_password_confirm)
	{
		$('#user_details_message_p').html('<span class="error_span">Passwords do not match</span>').slideDown('fast');
		$('#user_password_input').val('');
		$('#user_password_confirm_input').val('');
		input_focus('#user_password_input');
	}
	else
	{	
		$('#user_details_message_p').html('<img src="img/loading.gif" alt="Loading"> Saving and refreshing...').slideDown('fast');

		$.post('cp.php?change_user_details', { user_name: user_name, user_email: user_email, user_password: user_password }, function(data)
		{
			if(data == 1)
			{
				input_focus();
				setTimeout(function() { window.location.replace('.'); }, 1000);
			}
			else
			{
				input_focus();
				$('#user_details_message_p').html(data);
			}
		});
	}
}

// Venue

function delete_venue_data(delete_data)
{
	if(typeof $(".venue_radio:checked").val() !='undefined')
	{
		var delete_confirm = confirm('Are you sure?');

		if(delete_confirm)
		{
			var venue_id = $(".venue_radio:checked").val();

			$('#venue_administration_message_p').html('<img src="img/loading.gif" alt="Loading"> Deleting...').slideDown('fast');

			$.post('playgroundlandingpage.php?delete_venue_data', { venue_id: venue_id, delete_data: delete_data }, function(data)
			{
				if(data == 1)
				{
					location.reload();
				}
				else
				{
					$('#venue_administration_message_p').html(data);
				}
			});
		}
	}
	else
	{
		$('#venue_administration_message_p').html('<span class="error_span">You must pick a venue</span>').slideDown('fast');
	}
}


// UI

function div_fadein(id)
{
	setTimeout(function()
	{
		if(global_css_animations == 1)
		{
			$(id).addClass('div_fadein');
		}
		else
		{
			$(id).animate({ opacity: 1 }, 250);
		}
	}, 1);
}

function div_hide(id)
{
	$(id).removeClass('div_fadein');
	$(id).css('opacity', '0');
}

function notify(text, time)
{
	if(typeof text != 'undefined')
	{
		if(typeof notify_timeout != 'undefined')
		{
			clearTimeout(notify_timeout);
		}

		$('#notification_inner_cell_div').css('opacity', '1');

		if($('#notification_div').is(':hidden'))
		{
			$('#notification_inner_cell_div').html(text);
			$('#notification_div').slideDown('fast');
		}
		else
		{
			$('#notification_inner_cell_div').animate({ opacity: 0 }, 250, function() { $('#notification_inner_cell_div').html(text); $('#notification_inner_cell_div').animate({ opacity: 1 }, 250); });
		}

		notify_timeout = setTimeout(function() { $('#notification_inner_cell_div').animate({ opacity: 0 }, 250, function() { $('#notification_div').slideUp('fast'); }); }, 1000 * time);
	}
	else
	{
		if($('#notification_div').is(':visible'))
		{
			$('#notification_inner_cell_div').animate({ opacity: 0 }, 250, function() { $('#notification_div').slideUp('fast'); });
		}
	}
}

function input_focus(id)
{
	if(offclick_event == 'touchend')
	{
		$('input').blur();
	}
	if(typeof id != 'undefined')
	{
		$(id).focus();
	}
}

// Document ready

$(document).ready( function()
{
	// Detect touch support
	if('ontouchstart' in document.documentElement)
	{
		onclick_event = 'touchstart';
		offclick_event = 'touchend';
	}
	else
	{
		onclick_event = 'mousedown';
		offclick_event = 'mouseup';
	}

	// Visual feedback on click
	$(document).on(onclick_event, 'input:submit, input:button, .reservation_time_div', function() { $(this).css('opacity', '0.5'); });
	$(document).on(offclick_event+ ' mouseout', 'input:submit, input:button, .reservation_time_div', function() { $(this).css('opacity', '1.0'); });

	// Buttons
	$(document).on('click', '#reservation_today_button', function() { showweek(global_week_number, 'today'); });
	$(document).on('click', '#reset_user_password_button', function() { reset_user_password(); });
	$(document).on('click', '#change_user_permissions_button', function() { change_user_permissions(); });
	$(document).on('click', '#delete_user_reservations_button', function() { delete_user_data('reservations'); });
	$(document).on('click', '#delete_user_button', function() { delete_user_data('user'); });
	$(document).on('click', '#delete_venue_button', function() { delete_venue_data('venue'); });
	$(document).on('click', '#delete_all_reservations_button', function() { delete_all('reservations'); });
	$(document).on('click', '#delete_all_users_button', function() { delete_all('users'); });
	$(document).on('click', '#delete_everything_button', function() { delete_all('everything'); });
	$(document).on('click', '#add_one_reservation_button', function() { add_one_reservation(); });

	// Checkboxes
	$(document).on('click', '#reservation_reminders_checkbox', function() { toggle_reservation_reminder(); });

	// Forms
	$(document).on('submit', '#login_form', function() { login(); return false; });
	$(document).on('submit', '#new_user_form', function() { create_user(); return false; });
	$(document).on('submit', '#playground_login_form', function() { playgroundlogin(); return false; });
	$(document).on('submit', '#new_playground_form', function() { create_playground(); return false; });
	$(document).on('submit', '#system_configuration_form', function() { save_system_configuration(); return false; });
	$(document).on('submit', '#user_details_form', function() { change_user_details(); return false; });
	$(document).on('submit', '#new_venue_form', function() { create_venue(); return false; });
	$(document).on('submit', '#game_search_form', function() { setwindowlocation('game_type_location'); return false; });

	// Links
	$(document).on('click mouseover', '#user_secret_code_a', function() { div_fadein('#user_secret_code_div'); return false; });
	$(document).on('click', '#previous_week_a', function() { showweek('previous'); return false; });
	$(document).on('click', '#next_week_a', function() { showweek('next'); return false; });
	$(document).on('click', '#venue_check_reservation', function() { showreservations(); return false; });

	// Divisions
	$(document).on('mouseout', '.reservation_time_cell_div', function() { read_reservation_details(); });

	$(document).on('click', '.reservation_time_cell_div', function()
	{
		var array = this.id.split(':');
		toggle_reservation_time(this, array[1], array[2], array[3], array[0]);
	});

	$(document).on('mousemove', '.reservation_time_cell_div', function()
	{
		var array = this.id.split(':');
		read_reservation_details(this, array[1], array[2], array[3]);
	});

	// Mouse pointer
	$(document).on('mouseover', 'input:button, input:submit, .reservation_time_div', function() { this.style.cursor = 'pointer'; });
});

// Hash change

function hash()
{
	var hash = window.location.hash.slice(1);
	var query = window.location.search.slice(1);
	
	if(hash=='' && query != '')
	{
		handlequery(query);
		return;
	}
	
	switch(hash)
	{
		case '' :
			showhomepage();
			break;
		case 'search' :
			showsearchpage();
			break;
		case 'venue' :
			showvenue();
			break;
		case 'dashboard' :
			showdashboard();
			break;
		case 'userlogin' :
			showlogin();
			break;
		case 'new_user':
			shownew_user();
			break;
		case 'forgot_password':
			showforgot_password();
			break;
		case 'playgroundlanding' :
			showplaygroundlandingpage();
			break;
		case 'playgroundlogin' :
			showplaygroundlogin();
			break;
		case 'new_playground' :
			shownew_playground();
			break;
		case 'cp' :
			showcp();
			break;
		case 'logout' :
			logout();
			break;
		case 'about':
			showabout();
			break;
		case 'help':
			showhelp();
			break;
		default:
			window.location.replace('.');
	}
}

function handlequery(query)
{
	query_arr = query.split("="); 
	query_string = query_arr[0];
	
	switch(query_string)
	{
		case 'venue' :
			query_id = query_arr[1];
			showvenue(query_id);
			break;
		case 'search' :
			showsearch(query_arr[1],query_arr[2]);
			break;
		default:
			window.location.replace('.');
	}
}

// Window load

$(window).load(function()
{
	// Make sure cookies are enabled
	$.cookie(global_cookie_prefix+'_cookies_test', '1');
	var test_cookies_cookie = $.cookie(global_cookie_prefix+'_cookies_test');

	if(test_cookies_cookie == null)
	{
		window.location.replace('error.php?error_code=3');
	}
	else
	{
		$.cookie(global_cookie_prefix+'_cookies_test', null);

		hash();
		
		$(window).bind('hashchange', function ()
		{
			hash();
		});
	}
	
	var images = new Array();
	images[0] = "img/3522242574_93e1c43174.jpg";
	images[1] = "img/Soccer_match_-_Rochester_vs_Carolina.JPG";
	images[2] = "img/Badminton_Semifinal_Pan_2007.jpg";
	
	var i = (Math.floor(Math.random()*10))%3;		
	$.backstretch([images[i]]);

});

// Settings

$(document).ready( function()
{
	$.ajaxSetup({ cache: true });
});
