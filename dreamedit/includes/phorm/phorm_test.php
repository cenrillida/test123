<?php
var_dump($_REQUEST);
	$title = 'Please fill out this form';
	require_once ('phorm.test.class.php');
	$phorm = new phorm_test($_REQUEST);

	if ($phorm->validate()) {
		// We're all set!
		$first_name	= $phorm->value('first_name');
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
<p><font size="-1">$Id: phorm_test.php,v 1.11 2001/08/19 00:24:31 sean Exp $</font></p>
</body>
</html>
