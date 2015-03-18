<?php
	session_start();
	
	// If no session variable set, but we have a remember cookie
	// Check the db to see if they are valid
	if(empty($_SESSION['me']) && isset($_COOKIE['omghi'])) 
	{
		// Check the cookie against the db
		// If it matches, log them in
		// If it does not match, delete the cookie
		$user = mysql_query("SELECT cookie_key, id, modified FROM user WHERE id='$_COOKIE[user]'");
		$user 			= mysql_fetch_assoc($user);		
		$cookie_key_e 	= md5($user['cookie_key']);
		if($cookie_key_e == $_COOKIE['omghi'])
		{			
			$_SESSION['me'] 			= $user['id'];
			$_SESSION['s_modified'] 	= $user['modified'];
		}else
		{
			// Delete cookies
			setcookie ("omghi", "", time()-60000);
			setcookie ("user", "", time()-60000);
		}
	}

	// If we do have a session, create some easy to use variables
	if(isset($_SESSION['me'])) 
	{
		$me		 		= $_SESSION['me'];
	}
	


?>