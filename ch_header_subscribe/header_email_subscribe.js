/**
 * Author:		Richard Castera
 * Date:		12/9/2009
 * Comments:	Used for the email signup in the header.
 **/
Drupal.behaviors.ch_header_email_signup = function(context) {
	if(Drupal.jsEnabled) {
        
        // When they hover over the sigup button.
    	$('#quick_links_email', context).hover(
    		function() {
    			$('#header_email_signup').css('display', 'block');
    		}, 
    		function() {
    			$('#header_email_signup').css('display', 'none');
    		}
    	);
    	
        // Ajax for when the email signup form is submitted.
    	$('#header_email_signup_form', context).submit(function(e) {
    		
    		// Prevent default action.
    		e.preventDefault();
    		
            // Validate the form.
    		if(validateSignup()) {
    			
                $('#header_email_signup_msg').text('Submitting...');
                
                $('#header_email_signup_submit').attr('disabled', 'disabled');
                
    			// Post ajax
    			$.post($(this).attr('action'), 
    				{
    				    first_name: 	     $('#header_email_signup_first_name').val(),
                        last_name: 	         $('#header_email_signup_last_name').val(),
    					email: 				 $('#header_email_signup_email').val()
    					//ch_news_beacon: 	 $('#ch_news_beacon').attr('checked'),
    					//ch_news_reflections: $('#ch_news_reflections').attr('checked'),
    					//ch_news_voice: 	 	 $('#ch_news_voice').attr('checked')
    				},
    		
    				function(data) {
    					if(data.added == true) {
    						$('#header_email_signup').html('<div id="header_email_signup_content"><p>Thank you for signing up!</p></div>');
                            $('#header_email_signup_submit').attr('disabled', '');
    					}
    					else {
    						$('#header_email_signup_msg').addClass('header_email_signup_failure');
    						$('#header_email_signup_msg').text('Signup Failed!');
                            $('#header_email_signup_submit').attr('disabled', '');
    					}
    				},
    				
    				'json'
    			);
    		}		
    		
    	});
    	
    	$('#header_email_signup_first_name', context).focus(function() {
    		if($('#header_email_signup_msg').hasClass('header_email_signup_failure')) {
    			$('#header_email_signup_msg').removeClass('header_email_signup_failure').text('');
    		}
    	});
    	
        $('#header_email_signup_last_name', context).focus(function() {
    		if($('#header_email_signup_msg').hasClass('header_email_signup_failure')) {
    			$('#header_email_signup_msg').removeClass('header_email_signup_failure').text('');
    		}
    	});
        
        $('#header_email_signup_email', context).focus(function() {
    		if($('#header_email_signup_msg').hasClass('header_email_signup_failure')) {
    			$('#header_email_signup_msg').removeClass('header_email_signup_failure').text('');
    		}
    	});
        
//    	$('#header_email_signup input:checkbox', context).click(function() {
//    		if($('#header_email_signup_msg').hasClass('header_email_signup_failure')) {
//    			$('#header_email_signup_msg').removeClass('header_email_signup_failure').text('');
//    		}
//    	});
    	
        // Validate the signup.
    	function validateSignup() {
            if($('#header_email_signup_last_name').val() == '') {
    			$('#header_email_signup_msg').addClass('header_email_signup_failure');
    			$('#header_email_signup_msg').text('Empty Last Name!');
    			return false;
    		}
            
            $email = $('#header_email_signup_email').val();
    		if($email == '' || !validEmail($email)) {
    			$('#header_email_signup_msg').addClass('header_email_signup_failure');
    			$('#header_email_signup_msg').text('Invalid Email!');
    			return false;
    		}
    		
//    		if(!$('#ch_news_beacon').attr('checked') && !$('#ch_news_reflections').attr('checked') && !$('#ch_news_voice').attr('checked')) {
//    			$('#header_email_signup_msg').addClass('header_email_signup_failure');
//    			$('#header_email_signup_msg').text('Select a Newsletter!');
//    			return false;
//    		}
//    		
    		return true;
    	}
    	
        // Validate emai address.
    	function validEmail(e) {
    		var filter = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
    		return String(e).search (filter) != -1;
    	}
    }
}