<?php
/**
 * @author		Richard Castera
 * @date		10/28/2009
 * @version		Version - 1.0
 * @access		Public
 * @link		https://snac.sankyserver.com/projects/144/tickets/2
 * @uses		This adds a new subscriber to Kintera.
 * @param       $contact an array of contact details
 * @param       $type string either 'subscription' or 'donation'
 * @param       $args array if $type == 'subscription', should
 *              include the nid of the subscribed newsletter
 *              if $type == 'donation', should include the amt
 *              and recurring status
 **/ 
function ch_kintera_add_to_kintera($contact, $type = 'subscription', $args = array() ) {
    static $Kintera = NULL;
    static $contactID = NULL;

	if($contact) {

    if ( arg(0) == 'about' ) {

      $form = 'Subscription Form';

    } else {

      $form = 'Donation Form';

    }

		// Set the root directory of the Kintera folder

		$KinteraRoot = $_SERVER['DOCUMENT_ROOT'] . '/sites/all/modules/covenant_house/Kintera';

		

		// Load the Kintera Class

		require_once($KinteraRoot . '/Class.SankyKintera.php');

		

		// Include libraries for SOAP calls.

		$nusoapPath = $KinteraRoot . '/lib/nusoap.php';

		$wsdlPath = $KinteraRoot . '/KinteraConnect.wsdl';

		

		// Instantiate the class.

		if ( !$Kintera ) {

      $Kintera = new SankyKintera($nusoapPath, $wsdlPath);

    }

		

		// Connect to Covenant House Kintera Account. 

		if($Kintera->Connect('sankyadmin', 'sankiew38p', '291713')) {

			

			// Contact Profile

			$contactProfile = array(

	    		'FirstName'=>$contact['first_name'],

	    		'LastName'=>$contact['last_name'],

	    		'Email'=>$contact['email'],

	    		'AlternateID'=>'ch_' . $contact['email'],

	    		'PrimaryAddressLine1'=>$contact['address_1'],

	    		'PrimaryAddressLine2'=>$contact['address_2'],

	    		'PrimaryAddressCity'=>$contact['city'],

	    		//'PrimaryAddressState'=>'NY', // Do not know how to pass this correctly to Kintera. Getting a SOAP Error with these variations ('NY', 'New York')

	    		'PrimaryAddressZip'=>$contact['postal_code'],

	    		//'PrimaryAddressCountry'=>'US', // Do not know how to pass this correctly to Kintera. Getting a SOAP Error with these variations ('US', 'United States')

	    		'Phone'=>$contact['telephone'],

	    		'EmailFormat'=>'HTML'

	 		);

	    	

      // Get the subscribers info so in case an error occurs we can still get the information.

      $contactInfo = print_r($contact, TRUE);

      

      // Add the new contact.

      if ( !$contactID ) {

        $contactID = $Kintera->contactExists($contact['email']);

        if ( $contactID ) {

          $contactProfile['ContactID'] = $contactID;

          if(($Kintera->updateContact($contactProfile, TRUE)) == FALSE) {

            $error = '[Could not update Contact]' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

            mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

          }

        } else {

          $contactID = $Kintera->addContact($contactProfile, TRUE);

        }

        // If we have a new contact id...

        if($contactID) {

          /**

           * Constituency Custom Field

           **/

          $customFields = array(

            'ContactID'=>$contactID,

            'FieldID'=>'4814053', 

            'Value'=>'Prospect'

          );

        

          // Update the contact added with some custom fields.

          $Kintera->updateCustomFields($customFields);

          // If there was an error adding the custom field to the contact, email it to us.

          if($Kintera->getError() != '') {

            $error = '[Could not add the Constituency Custom Field - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

            mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

          }

        } else {

	    		$error = '[Could not add new Contact - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

		    	mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

	    	}

      }

      if ( $contactID && $type == 'subscription' && $args['nid'] ) {

        $nid = $args['nid'];

        $fields = array(

          48 => array('key' => '4814055', 'title' => 'Beacon'),

          49 => array('key' => '4814057', 'title' => 'Daily Reflections'),

          50 => array('key' => '4814056', 'title' => 'Voice (Advocacy)'),

        );

        $customFields = array(

          'ContactID'=>$contactID,

          'FieldID'=>$fields[$nid]['key'], 

          'Value'=>'Yes',

        );

        // Update the contact added with some custom field.

        $Kintera->updateCustomFields($customFields);

          

        // If there was an error adding the custom field to the contact, email it to us.

        if($Kintera->getError() != '') {

          $error = '[Could not add the '.$fields[$nid]['title'].' Subscription Custom Field - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

          mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

        }

      } elseif ( $contactID && $type == 'donation' ) {

        /**

         * Constituency Custom Field

         **/

        $customFields = array(

          'ContactID'=>$contactID,

          'FieldID'=>'4814053', 

          'Value'=>'Online Donor'

        );

      

        // Update the contact added with some custom fields.

        $Kintera->updateCustomFields($customFields);

        // If there was an error adding the custom field to the contact, email it to us.

        if($Kintera->getError() != '') {

          $error = '[Could not add the Constituency Custom Field - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

          mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

        }

        /**

				 * Last Date Custom Field - This is the date of the donation.

				 **/		

				$customFields = array(

					'ContactID'=>$contactID,

					'FieldID'=>'4814062', 

					'Value'=>date("n/j/Y", $args['timestamp']),

				);

				// Update the contact added with some custom field.

        $Kintera->updateCustomFields($customFields);

        

		    // If there was an error adding the custom field to the contact, email it to us.

		    if($Kintera->getError() != '') {

		    	$error = '[Could not add the Last Date Custom Field - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

		    	mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

		    }

        

        /**

				 * Last Amount Custom Field - This is the amount of the donation.

				 **/		

				$customFields = array(

					'ContactID'=>$contactID,

					'FieldID'=>'4814063', 

					'Value'=>sprintf('%01.2f', $args['amt']),

				);

				

				// Update the contact added with some custom field.

		    $Kintera->updateCustomFields($customFields);

		    	

		    // If there was an error adding the custom field to the contact, email it to us.

		    if($Kintera->getError() != '') {

		    	$error = '[Could not add the Last Amount Custom Field - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

		    	mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

		    }

        

        /**

				 * Is Recurring Custom Field - Is this a recurring donation.

				 **/		

				$customFields = array(

					'ContactID'=>$contactID,

					'FieldID'=>'3627150', 

					'Value'=>($args['recurring']?'Yes':'') // Yes, Blank for No.

				);

				

				// Update the contact added with some custom field.

        $Kintera->updateCustomFields($customFields);

		    	

        // If there was an error adding the custom field to the contact, email it to us.

        if($Kintera->getError() != '') {

          $error = '[Could not add the Is Recurring Custom Field - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

          mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

        }

      }

		}

		else {

			$error = '[Could not Connect to Kintera - '.$form.']' . "\n\r" . $Kintera->getError() . "\n\r" . $contactInfo;

		    mail('rcastera@sankyinc.com', 'Covenant House Kintera API Error', $error);

		}

	}

}