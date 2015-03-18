<?php
	// Error reporting
	ini_set('display_errors', 1);
	
	// Main globals
	define('SITE_NAME', "Leaving Early");
	define('SITE_ID', 'leavingearly');
	define('WEB_ROOT', 'http://leavingearlybook.com/');
	define('DOC_ROOT', '/home/tylr99/www2/leavingearlybook.com/');
	//define('DOC_ROOT', 'C:\Users\tyler\Dropbox\dev\leavingearly-mockups\larry2');
	define('LIB_ROOT', '/home/tylr99/www2/libs/');
	
	// Facebook globals
	define('FB_APP_ID', '464524356899345');
	define('FB_SECRET', 'f56690709c3dbc5b5117b84b192202a1');
	
	// Harcode admins into the site.
	$admin_array = array(2, 24, 57);
	
	// MySQL Settings
//	mysql_connect("localhost:8889", "root", "HORSE1234");
//	mysql_select_db(SITE_ID);
	

	// ----------------------------------------------------- //
	// The settings below should be okay without editing
	
	define('S3_ROOT', 'http://' . SITE_ID . '.s3.amazonaws.com');
	define('SITE_EMAIL', 'no-reply@' . SITE_ID . ".com" );	

	require DOC_ROOT . '/inc/functions.php';
	require DOC_ROOT . '/inc/functions_custom.php';
	require DOC_ROOT . '/inc/blacklist.php';
	require DOC_ROOT . '/inc/sessions.php';
	
	// Fix magic quotes
    if(get_magic_quotes_gpc())
    {
        $_POST    = fix_slashes($_POST);
        $_GET     = fix_slashes($_GET);
        $_REQUEST = fix_slashes($_REQUEST);
        $_COOKIE  = fix_slashes($_COOKIE);
    }
?>