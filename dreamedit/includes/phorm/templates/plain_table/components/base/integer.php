<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
	echo "<input style=\"TEXT-ALIGN: right;\" type=\"text\" name=\"".$name."\" id=\"".$name."\" size=\"6\"".(isset($maxlength)? " maxlength=\"".$maxlength."\"": "")." value=\"".$value."\" />\n";
	echo isset($buttons)? $buttons: "";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
