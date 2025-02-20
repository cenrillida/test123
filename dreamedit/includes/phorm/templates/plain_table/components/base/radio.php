<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
	foreach ($options as $option) {
		echo $option.": ";
		$checked = ($value == $option) ? ' checked' : '';
		echo "<input type=\"radio\" name=\"".$name."\" value=\"".$option."\"".$checked." />\n";
	}

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
