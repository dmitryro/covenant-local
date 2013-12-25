<?php

/**
 * @package		Wrapper Class for Kintera
 * @link		http://www.blackbaud.com/
 * @author		Richard Castera
 * @date		10/08/2009
 * @copyright 	Richard Castera 2009 © Copyright.
 * @version		Version - 1.0
 * @access		Public
 **/

class SankyKintera {

	
	/**
	 * @uses	Soap object.
	 * @access	Private
	 * @var		Object
	 **/
	private $soap = 		NULL;
	
	
	
	
	
	/**
     * @uses	Constructor.
     * @access	public
     * @param	String $nusoap.
	 * @param	String $wsdl. 
     * @return  none.
     **/ 
	public function __construct($nusoap = '', $wsdl = '') {
		if(file_exists($nusoap) && $nusoap != '') {
			require_once($nusoap);	
		}
		else {
			echo('Soap Library not found.');
		}
		
		if(file_exists($wsdl) && $wsdl != '') {
			$this->soap = new soapclientw($wsdl, TRUE);
  			$this->soap->soap_defencoding = 'UTF-8';
        	$this->soap->decode_utf8 = FALSE;	
		}
		else {
			echo('WSDL File not found.');
		}		
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
     * @uses	Connects to Kintera.
     * @access	public
     * @param	String $username.
	 * @param	String $password. 
	 * @param	String $clientId. 
     * @return  Boolean.
     * @example	$KinteraWrapper->Connect('username', 'password', 'clientId');
     **/ 
	public function Connect($username = '', $password = '', $clientId = '') {
		$username = strip_tags(stripslashes(trim($username)));
		$password = strip_tags(stripslashes(trim($password)));
		$clientId = strip_tags(stripslashes(trim($clientId)));
		
		if($username == '' && $password == '') {
			return FALSE;
		}
		else {
			$loginRequest = array(
				'LoginName'=>$username,
				'Password'=>$password
			);
  			
  			if($clientId != '') {
  				$loginRequest['UserID'] = $clientId;
  			}

            $loginResult = $this->soap->call('Login', array('parameters'=>array('request'=>$loginRequest)));	            
			$sessionID = $loginResult['LoginResult']['SessionID'];
            $sessionHeader = "<SessionHeader xmlns=\"http://schema.kintera.com/API/\"><SessionID>" . $sessionID . "</SessionID></SessionHeader>";
            $this->soap->setHeaders($sessionHeader);
            
            if($this->getError()) {
            	return FALSE;
            }
            else {
            	return TRUE;
            }            
		}  	
	}
	
	
	/**
     * @uses	Queries Kintera to see if the contact exists.
     * @access	public
     * @param	String $email.
     * @return  False on error or doesn't Exist. Array if found.
     * @example	$KinteraWrapper->contactExists('rcastera@sankyinc.com');
     **/ 
	public function contactExists($email = '') {
		$email = strip_tags(stripslashes(trim($email)));
		
		if($email == '') {
			return FALSE;
		}
		else {
			// Prepare query request to search all contacts whose last name starts with "S"
	        $queryCondition = array(
	        	'QueryText'=>"SELECT ContactID FROM ContactProfile WHERE Email = '$email'",
	            'PageSize'=>1, // Set the return batch size to be 1 record, and returns the first record
	            'PageNumber'=>1
	         );
			
			// Make server Query call
            $queryRequest = new soapval('request', 'QueryRequest', $queryCondition, false, 'tns');
            $param = array('request'=>$queryRequest);
            $queryResponse = $this->soap->call('Query', array('parameters'=>$param));
            
            // Get the result
            $queryResult = $queryResponse['QueryResult'];
  			
  			// If the contact was found, return the contact id.
            if($queryResult['Total'] > 0){
				return $queryResult['Records']['Record']['ContactID'];
            }
			else {
				return FALSE;
			}	 	
		}
	}
	
	
	/**
     * @uses	Adds a contact to Kintera.
     * @access	public
     * @param	Array $fields. 
     * @param	Boolean $individual - true for individual, false for organization. 
     * @return  Boolean - False if failed, ID of the new contact if successfull.
     * @example	Create a new contact
            	$contactProfile = array(
            		'FirstName' => 'First Name',
            		'LastName' => 'Last Name',
            		'Email' => 'abc@foo.com',
           			'Gender' => 'Male', //Male|Female|Unknown
            		'EmailFormat' => 'HTML' //HTML|Text
            	);
            	
            	$KinteraWrapper->addContact($contactProfile);
     **/ 
	public function addContact($fields = '', $individual = TRUE) {
		if(is_array($fields) && ($fields != '')) {
			
			if($individual) {
				$fields['IsIndividualFlag'] = '1'; // Individual
			}
			else {
				$fields['IsIndividualFlag'] = '0'; // Organization
			}
			
			// Make service call
        	$param = array('entity'=> new soapval('entity', 'ContactProfile', $fields, FALSE, 'tns'));
        	$createResult = $this->soap->call('Create', array('parameters'=>$param));
        	
        	if($createResult) {
        		// Return the ID of the created Contact
        		return $createResult['CreateResult']['ContactID'];	
        	}
        	else {
        		return FALSE;
        	}
		}
		else {
			return FALSE;
		}
	}
	
            
	/**
     * @uses	Updates a contact to Kintera.
     * @access	public
     * @param	Array $fields. 
     * @return  Boolean - False if failed, True if successfull.
     * @example	Create a new contact
            	$contactProfile = array(
            		'ContactID' => 'id',
            		'FirstName' => 'First Name',
            		'LastName' => 'Last Name',
            		'Email' => 'abc@foo.com',
           			'Gender' => 'Male', //Male|Female|Unknown
            		'EmailFormat' => 'HTML' //HTML|Text
            	);
            	
            	$KinteraWrapper->updateContact($contactProfile);
     **/ 
	public function updateContact($fields = '', $individual = TRUE) {
		if(is_array($fields) && ($fields != '')) {
			
			if($individual) {
				$fields['IsIndividualFlag'] = '1'; // Individual
			}
			else {
				$fields['IsIndividualFlag'] = '0'; // Organization
			}
			
			$entity = new soapval('entity', 'ContactProfile', $fields, FALSE, 'tns');
  			$param = array('entity'=>$entity);
        	$result = $this->soap->call('Update', array('parameters'=>$param));
        	
        	if($result == '' || is_null($result)) {
        		return TRUE;
        	}
        	else {
        		return FALSE;
        	}
    	}
    	else {
    		return FALSE;
    	}
	}
	
	
	/**
     * @uses	Updates a contact custom field to Kintera.
     * @access	public
     * @param	Array $fields. 
     * @return  Boolean - False if failed, True if successfull.
     * @example	Create a new contact
            	$customFields = array(
            		'ContactID' => 'id',
            		'FieldID' => 'First Name',
            		'Value' => 'Last Name'
            	);
            	
            	$KinteraWrapper->updateCustomFields($customFields);
     **/ 
	public function updateCustomFields($fields = '') {
		if(is_array($fields) && ($fields != '')) {
			
			$entity = new soapval('entity', 'ContactCustomProfileField', $fields, FALSE, 'tns');
  			$param = array('entity'=>$entity);
        	$result = $this->soap->call('Update', array('parameters'=>$param));
        	        	
        	if($result) {
        		return TRUE;
        	}
        	else {
        		return FALSE;
        	}
    	}
    	else {
    		return FALSE;
    	}
	}
	
	
	/**
     * @uses	Deletes a contact in Kintera.
     * @access	public
     * @param	Integer $contactID. 
     * @return  Boolean.
     * @example	$KinteraWrapper->deleteContact(5);
     **/
	public function deleteContact($contactID = -1) {
		if($contactID != -1) {
			$contactID = (int)$contactID;
			$id = new soapval('id', 'ContactProfileIdentifier', array('ContactID'=>$contactID), FALSE, 'tns');
  			$param = array('id'=>$id);
        	$this->soap->call('Delete', array('parameters'=>$param));
			return TRUE;      	
		}
		else {
			return FALSE;
		}
	}
	
	
	/**
     * @uses	Returns a Kintera Error.
     * @access	public
     * @return  String.
     * @example	$KinteraWrapper->getError();
     **/
	public function getError() {
		return $this->soap->getError();
	}
}
?>