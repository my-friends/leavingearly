<?php

	// Fixes MAGIC_QUOTES
    function fix_slashes($arr = '')
    {
        if(is_null($arr) || $arr == '') return null;
        if(!get_magic_quotes_gpc()) return $arr;
        return is_array($arr) ? array_map('fix_slashes', $arr) : stripslashes($arr);
    }
	
	function clean_in($foo)
	{
	   $foo = mysql_real_escape_string($foo);
	   return $foo;

	}
	
	function is_admin_exit()
	{
	    global $session_uid;
		global $admin_array;
	
		// put a session check in here so we don't have to check this array everytime
		// a non-admin loads the page
	
		if (in_array($session_uid, $admin_array)) 
		{
	    	$foo = 1;
	    }
	    if ($foo != 1){ exit("No permission."); }
	}

	function is_admin_return()
	{
		global $session_uid;
		global $admin_array;
	
		// put a session check in here so we don't have to check this array everytime
		// a non-admin loads the page
	
		if (in_array($session_uid, $admin_array)) 
		{
	    	$foo = 1;
	    }else{
	    	$foo = 0;
	    }
	    return $foo;
	}

	function substrwords($str, $n) {
	    $len = strlen($str);
	    if ($len > $n) {
	        preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
	        return rtrim($matches[1]."...") ;
	    }
	    else {
	        return $str;
	    }
	}

	function protect()
	{	
		global $me;

	    if (empty($me))
	    { 
	    	header("Location: login.php?error=2");
	    	exit(); 
	    }
	}
	
	function check_modified($current_modified)
	{
		global $me;
		
		// This looks to be working, but there may be an issue with the way the dates are store in the db
		// date vs datetime

		if($current_modified!=date("Y-m-d")) 
		{
			mysql_query("UPDATE user SET modified=now() WHERE id='$me'") or die(mysql_error()); 
		}
	}

	function logged_in()
	{
	    global $s_user;

	    if (empty($s_user))
	    { 
	    	return 0;
	    }else{
			return 1;
		}
	}

	function get_real_ip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
			$ip=$_SERVER['REMOTE_ADDR'];
	    }
		return $ip;
	}


	function avatar_url($user_id, $num)
	{
		echo "http://elw.s3.amazonaws.com/". SITE_ID ."/avatars/".$user_id."-".$num.".jpg";
	}
	
	
	function img_url($id, $num)
	{
		echo "http://elw.s3.amazonaws.com/". SITE_ID ."/imgs/".$id."-".$num.".jpg";
	}
	
	function time_ago($date,$granularity=1) {
	    $date = strtotime($date);
	    $difference = time() - $date;
	    $periods = array('decade' => 315360000,
	        'year' => 31536000,
	        'month' => 2628000,
	        'week' => 604800, 
	        'day' => 86400,
	        'hour' => 3600,
	        'minute' => 60,
	        'second' => 1);
		$retval = '';
		if ($difference < 1) {
			$retval = "a second";
		}else{
			foreach ($periods as $key => $value) {
				if ($difference >= $value) {
					$time = floor($difference/$value);
					$difference %= $value;
					$retval .= ($retval ? ' ' : '').$time.' ';
					$retval .= (($time > 1) ? $key.'s' : $key);
					$granularity--;
				}
				if ($granularity == '0') {
					break;
				}
			}
		}
	    return $retval;      
	}
	
	function time_future($date,$granularity=1) {
	    $date = strtotime($date);
	    $difference = time() - $date;
	    $periods = array('decade' => 315360000,
	        'year' => 31536000,
	        'month' => 2628000,
	        'week' => 604800, 
	        'day' => 86400,
	        'hour' => 3600,
	        'minute' => 60,
	        'second' => 1);
		$retval = '';
		if ($difference < 1) {
			$retval = "a second";
		}else{
			foreach ($periods as $key => $value) {
				if ($difference >= $value) {
					$time = floor($difference/$value);
					$difference %= $value;
					$retval .= ($retval ? ' ' : '').$time.' ';
					$retval .= (($time > 1) ? $key.'s' : $key);
					$granularity--;
				}
				if ($granularity == '0') {
					break;
				}
			}
		}
	    return $retval;      
	}

	function lol_mail($to, $subject, $message)
	{
		$headers = 'From: "PARTY" <noreply@sender.dom>' . PHP_EOL .
	           		'X-Mailer: PHP-' . phpversion() . PHP_EOL;
		mail($to, $subject, $message, $headers);
	}
	
	function swift_mail($email, $username, $subject, $body)
	{
		$site_email = 'tyler@yourstance.com';
		$site_name = "YourStace";
		
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
		  ->setUsername('tylerempty@gmail.com')
		  ->setPassword('franksank7');
		
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance($subject)
		  ->setFrom(array($site_email => $site_name))
		  ->setTo(array($email => $username))
		  ->setBody($body);
		$mailer->send($message);
	}
		
	function go_back()
	{
		$foo = $_SERVER['HTTP_REFERER'];
		header("Location: $foo");
	}

	function birthday ($birthday)
	{
	    list($year,$month,$day) = explode("-",$birthday);
	    $year_diff  = date("Y") - $year;
	    $month_diff = date("m") - $month;
	    $day_diff   = date("d") - $day;
	    if ($day_diff < 0 || $month_diff < 0)
	      $year_diff--;
	    return $year_diff;
	}

	if (!function_exists('print_rr'))
	{
	    function print_rr($data, $return = FALSE)
	    {
	        $output  = '<pre style="background: #fff; border: 1px #333 solid; color: #000; font-size: 16px; font-weight: normal; margin: 10px; padding: 10px; text-align: left;">';
	        $output .= print_r($data, TRUE);
	        $output .= '</pre>';
       
	        if($return)
	            return $output;
	        else
	            print $output;
	    }
	}

function slug($text)
{ 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '', $text);
  // trim
  $text = trim($text, '-');
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // lowercase
  $text = strtolower($text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  if (empty($text))
  {
    return 'n-a';
  }
  return $text;
}

function test_username($text)
{ 
  // Check to see if username is valid

  return true;
}

function check_alert($num, $alerts) {
//0 - forum_posts
//1 - reason agree
//2 - reason_comment
  $foo = substr($alerts, $num, 1);
  if($foo==0){
 	  return false;
 	}else{
 	  return true;
 	}     
}


function make_the_cookie($user_id){
	
	// Create a random number and put it in the cookie and in the db
	$cookie_time = (3600 * 24 * 30); // 30 days
	$cookie_key = uniqid();
	$cookie_key_e = md5($cookie_key);
	$q = mysql_query("UPDATE user SET cookie_key='$cookie_key' WHERE id='$user_id'") or die(mysql_error()); 
	setcookie ("omghi", $cookie_key_e, time()+$cookie_time);
	setcookie ("user", $user_id, time()+$cookie_time);

	
}


function pretty_date($date) {
	echo date('m/d/y', strtotime($date));
	}




function copy_avatar($user_id) {
	// Copy avatar from the avatar user (user #1)
	// First part of avatar filename is the user_id
	// Second part of avatar filename is the type/size of photo
	// More information can be found in avatar_post.php
	
	$s3 = new AmazonS3();
	
	$i = 1;
	while($i <= 4){
		
		$r = $s3->copy_object(
		array( // Source
		'bucket' => SITE_ID,
		'filename' => 'avatars/1-' . $i . '.jpg'
		),
		array( // Destination
		'bucket' => SITE_ID,
		'filename' => 'avatars/' . $user_id . '-' . $i . '.jpg'
		),
		array( //Options
		'acl' => AmazonS3::ACL_PUBLIC
		) 
		);
		$i++;
	}

}

?>