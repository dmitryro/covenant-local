<?php

/**
 * @package			Origin Tracking Class
 * @link			http://www.sankyinc.com/
 * @author			Richard Castera
 * @datecreated		10/08/2009
 * @copyright 		Sanky Communications 2009 � Copyright.
 * @version			Version - 1.0
 * @access			Public
 * ---------------------------------------------------------
 * @datemodified	10/21/2009 - Richard Castera
 * @comments		Added cookies to hold origin data for 7 days
 * ----------------------------------------------------------
 **/


class SankyOrigins {
	
	
	/**
     * @uses	A whole number in minutes for the cookie to expire.
     * @access	private
	 * @var		Integer 
     **/ 
	private $cookieExpire = 7;
	
	
	/**
     * @uses	A string containing a unique cookie variable.
     * @access	private
	 * @var		String 
     **/ 
	private $origin_key = 'sanky_origins';
	
	
	
	
	
	/**
     * @uses	Constructor.
     * @access	public 
     * @param	none.
     * @return  none.
     **/ 
	public function __construct() {
		session_start();
	}
	
	
	/**
     * @uses	Destructor.
     * @access	public
     * @param	none. 
     * @return  none.
     **/ 
	public function __destruct() {
		unset($this);
	}
	
	
	/**
     * @uses	Tracks Origins.
     * @access	public
	 * @param	none. 
     * @return  none.
     * @example	$OriginTracking->track();
     **/ 
	public function track() {
		if(isset($_GET['origin']) && !empty($_GET['origin'])) {	
			// Clean the origin code.
			$originCode = strip_tags(stripslashes(trim($_GET['origin'])));
			
			// Add this origin to a cookie
			$this->setCookie($originCode);
		}
		
		// Set our session variable to hold tracking data.
		$_SESSION['tracking'] = array(
			'origin'=>$this->getCookie(),
			'ip'=>$_SERVER['REMOTE_ADDR'],
			'referer'=>$_SERVER['HTTP_REFERER']
		);
	}
	
	
	/**
     * @uses	Get Origin Tracking info.
     * @access	public
	 * @param	none. 
     * @return  Array.
     * @example	$OriginTracking->getOriginInformation();
     **/ 
	public function getOriginInformation() {
		if(isset($_SESSION['tracking'])) {			
			return $_SESSION['tracking'];	
		}
		else {
			return '';
		}
	}

	
	/**
     * @uses	Gets origin values stored in a cookie.
     * @access	public
	 * @param	none. 
     * @return  Array if there is a cookie set for origins or empty string if not.
     * @example	$this->getCookie();
     **/ 
	private function getCookie() {
		if (isset($_COOKIE[$this->origin_key])) {
			return $_COOKIE[$this->origin_key];
		}
		else {
			return '';
		}
	}
	
	
	/**
     * @uses	Sets origin values in a cookie.
     * @access	public
	 * @param	String $origin - new origin code. 
     * @return  none.
     * @example	$this->setCookie();
     **/ 
	private function setCookie($origin) {
		// Get existing origin codes stored in cookie.
		$existingCookies = $this->getCookie();
		$originCodes = '';
		$newOriginCodes = '';
		
		// If there are origin codes already stored in the cookie
		// retrieve them. The origin codes are separated by pipe (|).
		if($existingCookies != '') {
			$originCodes = explode('|', $existingCookies);
      foreach ( array_keys($originCodes, $origin, TRUE) as $key ) {
        unset($originCodes[$key]);
      }
      $originCodes[] = $origin;
			
			$newOriginCodes = implode('|', $originCodes);
		}
		else {
			$newOriginCodes = $origin;
		}
		
		// Destroy the cookie.
		setcookie($this->origin_key, '', time()-3600, '/', $_SERVER['SERVER_NAME']);
		
		// Expires in 7 days.
		$expire=time()+60*60*24*$this->cookieExpire;
		
		// Set a new cookie with additional origin code.
		setcookie($this->origin_key, $newOriginCodes, $expire, '/', $_SERVER['SERVER_NAME']);
    
    // Make the cookie data available to other functions immediately (instead of next page load)
    $_COOKIE[$this->origin_key] = $newOriginCodes;
	}
}