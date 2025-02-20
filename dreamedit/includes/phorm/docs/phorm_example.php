<?php

	// set default title
	$title = 'Please fill out this form';

	// load our form definition class
	require_once ('phorm.example.class.php');

	// create an instance of our class
	$phorm = new phorm_test;

	if ($phorm->validate()) {
		// The form validated!  This is where you would
		// do things such as store the results in a database
		// or send an email message.

		// this will get the value of the component named
		// "first_name". If you call the value method without
		// a component name, it will return an associative
		// array (comp_name => value) with all of the 
		// components values.
		$first_name = $phorm->value('first_name');
		$title = "Welcome $first_name!";
	}

?>
<html>
<head>
<title>Phorm test: <?php print $title; ?></title>
</head>
<body>
<?php
	$phorm->display();
?>
</body>
</html>
