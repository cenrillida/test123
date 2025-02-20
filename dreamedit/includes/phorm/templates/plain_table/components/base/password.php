<tr valign="top"><td nowrap>
<?php
	if(!is_array($prompt))
		$prompt = array($prompt);

	$prompt[0] .= ":";
	$prompt[0] = count($validate_errors) ? "<span class=\"error\">".$prompt[0]."</span>" : $prompt[0];
	echo $prompt[0]."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
	$value[0] = isset($value[0]) ? $value[0] : '';

	echo "<input type=\"text\" name=\"".$name."[0]\" id=\"".$name."\" size=\"".$size."\"".(isset($maxlength)? " maxlength=\"".$maxlength."\"": "")." value=\"\" />\n";
	echo isset($buttons)? $buttons: "";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>

<?
if(!isset($prompt[1]))
	return;
?>

<tr valign="top"><td nowrap>
<?php
	$prompt[1] .= ":";
	$prompt[1] = count($validate_errors) ? "<span class=\"error\">".$prompt[1]."</span>" : $prompt[1];
	echo $prompt[1]."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
	$value[1] = isset($value[1]) ? $value[1] : '';
	echo "<input type=\"text\" name=\"".$name."[1]\" id=\"".$name."_1\" size=\"".$size."\"".(isset($maxlength)? " maxlength=\"".$maxlength."\"": "")." value=\"\" />\n";
?>
</td></tr>