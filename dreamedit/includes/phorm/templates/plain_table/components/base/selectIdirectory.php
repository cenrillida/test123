<tr valign="top"><td nowrap>
<?
	
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?
//	print_r($value);
	$value = is_array($value)? $value: array($value);
	
	echo "<select name=\"".$name."\" ";
	echo isset($size)? "size=\"".$size."\"": ""; 
	echo ">\n";
	
	$bi = new Binding();	
	print_r("!".$use_id."!");

	
	foreach($bi->getTextsByTypeName($ilinestype,$keyname,$textname,$dirname,$use_id) as $key => $val) 
	{
		$selected = (isset($value) && in_array($key, $value))? " selected" : "";
		echo "<option value=\"".$key."\"".$selected.">".$val[$textname]."</option>\n";
	}

	echo "</select>\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
