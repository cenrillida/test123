<?php

// Include the phorm class.  Change the path to point to the phorm 
// class on your system.
require_once ('../phorm.class.php');

class phorm_test extends phorm {

	// This is the constructor
    function phorm_test () {
		// Call _test_phorm below to setup the form definition.
        $this->_test_phorm();
		// Call the constructor from the phorm parent class.
        $this->phorm();
    }


    function _test_phorm () {
        $this->phorm = array (
			// Set the name of the <form>
            'name'            => 'TestForm',
			// Set the template set to be used
            'template_dir'    => 'plain_table',
			// The language file for errors and such
            'language'        => 'american_english',
			// This is the path to the inPhorm directory
			'include_path'    => '../',
			// The array of componets for your form
            'components'      => array (
                'first_name'    => array (
					// The class is used to determine which inPhorm
					// component needs to be loaded to handle this.
                    'class'               => 'base::textbox',
					// This prompt is displayed to the user.
                    'prompt'              => 'First Name:',
					// This help text can be used to offer assistance
					// to make your form easy to understand.
                    'help'                => 'Enter your first name here.',
					// The size of the textbox.
                    'size'                => '30',
					// The maximum number of characters allowed
                    'maxlength'           => '50',
					// The minimum number of characters allowed
                    'minlength'           => '2',
					// Is this field required?
                    'required'            => TRUE,
					// The validation class and method to use to 
					// validate the user's input.  The
					// base::alpha validation method only allows
					// a-zA-Z as input.
                    'validate_method'     => 'base::alpha'
                ),
                'last_name'     => array (
                    'class'               => 'base::textbox',
                    'prompt'              => 'Last Name:',
                    'help'                => 'Enter your last name here.',
                    'size'                => '30',
                    'maxlength'           => '50',
                    'minlength'           => '2',
                    'required'            => TRUE,
                    'validate_method'     => 'base::alpha'
                ),
                'password'      => array (
                    'class'               => 'base::password',
					// The password component has two prompts which 
					// are defined as an array.
                    'prompt'              => array('Password:','Repeat Password:'),
                    'help'                => 'Enter your password here.',
                    'size'                => '30',
                    'maxlength'           => '50',
                    'minlength'           => '2',
                    'required'            => TRUE,
                    'validate_method'     => 'base::alpha'
                ),
				// This is just a simple submit button named "submit".
                'submit'        => array (
                    'class'               => 'base::button',
					// Valid types are submit and reset.
                    'type'                => 'submit',
					// This is displayed on the button
                    'value'               => 'Submit Form'
                ),
            )
        );
    }
}

?>
