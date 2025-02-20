<?php
	foreach ($components as $name => $component) {
		$value = htmlspecialchars($component['object']->to_string());
		print "$name = $value<br>\n";
	}
?>
