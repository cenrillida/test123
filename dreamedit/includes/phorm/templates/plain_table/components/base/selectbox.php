<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php

	$value = is_array($value)? $value: array($value);

	echo "<select name=\"".$name."\" ";
	echo isset($size)? "size=\"".$size."\"": ""; 
	echo (isset($multiple) && $multiple)? " multiple": "";
	echo ">\n";
	
	foreach($options as $val => $option) {
		$selected = (isset($value) && in_array($val, $value))? " selected" : "";
		echo "<option value=\"".$val."\"".$selected.">".$option."</option>\n";
	}

	echo "</select>\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
