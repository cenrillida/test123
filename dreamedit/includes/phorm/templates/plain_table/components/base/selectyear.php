<tr valign="top"><td nowrap>
<?

	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?
    $rang0=explode("|",trim($rang));

	$value = is_array($value)? $value: array($value);

    if (empty($value)) $value[0]=date("Y");

	echo "<select name=\"".$name."\" ";
	echo isset($size)? "size=\"".$size."\"": "";
	echo ">\n";


	$il = date("Y");
	for($i=($il+$rang0[0]);$i<=($il+$rang0[1]);$i++) {
		$selected = (isset($value) && in_array($key, $value))? " selected" : "";
		$selected = (isset($value) && $value[0]==$i)? " selected" : "";
		echo "<option value=\"".$i."\"".$selected.">".$i."</option>\n";
	}

	echo "</select>\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
