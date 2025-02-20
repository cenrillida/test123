<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php

	$texts = is_array($texts)? $value: explode("|",$texts);

	echo "<select name=\"".$name."\" ";
	echo isset($size)? "size=\"".$size."\"": "";
	echo (isset($multiple) && $multiple)? " multiple": "";
	echo ">\n";

	foreach($texts as $val => $option) {
		$selected = (isset($value) && ($value == $option))? " selected" : "";
		echo "<option value=\"".$option."\"".$selected.">".$option."</option>\n";
	}

	echo "</select>\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
