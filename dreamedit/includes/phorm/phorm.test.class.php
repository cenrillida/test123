<?php

require_once ('phorm.class.php');

class phorm_test extends phorm {

	function phorm_test ($values = array()) {
		$this->_test_phorm();
		$this->phorm($values);
	}


	function _test_phorm () {
		$this->phorm = array (
			'name'			=> 'TestForm',
			'template_dir'	=> 'plain_table',
			'language'		=> 'ru',
			'components'	=> array (
				'referrer'		=> array (
					'class'				=> 'base::hidden',
				),
				'first_name'	=> array (
					'class'				=> 'base::textbox',
					'prompt'			=> 'First Name:',
					'help'				=> 'Enter your first name here.',
					'size'				=> '30',
					'maxlength'			=> '50',
					'minlength'			=> '2',
					'required'			=> TRUE,
					'validate_method'	=> 'base::alpha',
				),
				'last_name'		=> array (
					'class'				=> 'base::textbox',
					'prompt'			=> 'Last Name:',
					'help'				=> 'Enter your last name here.',
					'size'				=> '30',
					'maxlength'			=> '50',
					'minlength'			=> '2',
					'required'			=> TRUE,
					'validate_method'	=> 'base::alpha',
				),
				'email_address'	=> array (
					'class'				=> 'base::textbox',
					'prompt'			=> 'Email:',
					'help'				=> 'Enter your full email address.',
					'size'				=> '30',
					'maxlength'			=> '50',
					'minlength'			=> '6',
					'required'			=> TRUE,
					'validate_method'	=> 'base::email',
				),
				'password'		=> array (
					'class'				=> 'base::password',
					'prompt'			=> array('Password:','Repeat Password:'),
					'help'				=> 'Enter your password here.',
					'size'				=> '30',
					'maxlength'			=> '50',
					'minlength'			=> '2',
					'required'			=> TRUE,
					'validate_method'	=> 'base::alpha',
				),
				'color'			=> array (
					'class'				=> 'base::selectbox',
					'prompt'			=> 'Favorite Color:',
					'help'				=> 'Select your favorite color.',
					'options'			=> array('','Red','Blue','Black','Green','Yellow','Orange','Pink'),
					'size'				=> 1,
					'multiple'			=> FALSE,
					'required'			=> TRUE,
				),
				'gender'		=> array (
					'class'				=> 'base::radio',
					'prompt'			=> 'Gender:',
					'help'				=> 'Select your gender.',
					'options'			=> array('Male','Female'),
					'required'			=> TRUE,
				),
				'pets'			=> array (
					'class'				=> 'base::checkbox',
					'prompt'			=> 'Pets:',
					'help'				=> 'Select the types of pets that you own.',
					'options'			=> array('Dog', 'Cat', 'Bird', 'Fish'),
					'required'			=> TRUE,
				),
				'bio'			=> array (
					'class'				=> 'base::textarea',
					'prompt'			=> 'Biography:',
					'help'				=> 'Tell us a little about yourself.',
					'cols'				=> '30',
					'rows'				=> '5',
					'minlength'			=> '5',
					'maxlength'			=> '255',
					'wrap'				=> 'virtual',
					'required'			=> TRUE,
				),
				'picture'		=> array (
					'class'				=> 'base::file',
					'prompt'			=> 'Picture:',
					'help'				=> 'Optionally, include a picture.',
					'size'				=> '30',
					'max_file_size'		=> '102400',
					'min_file_size'		=> '1024',
					'allowed_ext'		=> array('gif', 'jpg', 'jpeg', 'png'),
					'allowed_types'		=> array('image/gif', 'image/jpg', 'image/jpeg', 'image/png'),
					'required'			=> FALSE,
				),
				'submit'		=> array (
					'class'				=> 'base::button',
					'type'				=> 'submit',
					'value'				=> 'Submit Form',
				),
			)
		);
	}


}

?>
