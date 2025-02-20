<tr valign="top"><td nowrap>
<?
	
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?

	$value = is_array($value)? $value: array($value);

	echo "<select name=\"".$name."\" ";
	echo isset($size)? "size=\"".$size."\"": ""; 
	echo ">\n";
	
	$directories = new Directories();



echo "<option value=\"\"></option>\n";
	foreach($directories->getTypes() as $key => $val) {
		$selected = (isset($value) && in_array($val["itype_name"], $value))? " selected" : "";
		echo "<option value=\"".$val["itype_name"]."\"".$selected.">".$val["itype_name"]."</option>\n";
	}

	echo "</select>\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
