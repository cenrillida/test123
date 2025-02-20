<h4 class="error"><?=Dreamedit::translate("Обнаружены слудующие ошибки")?>:</h4>
<ul class="error">
<?php
	foreach ($errors as $error) {
		$error_msg = $error['prompt'] . " " . $error['msg'];
		print "<li>$error_msg\n";
	}
?>
</ul>
