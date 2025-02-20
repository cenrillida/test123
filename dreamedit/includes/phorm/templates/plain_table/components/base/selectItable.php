<tr valign="top"><td nowrap>
<?
 global $DB;
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

//	$bi = new Binding();
//	print_r("!".$use_id."!");
      echo "<option></option>";
      $ss=$DB->select($query);

	foreach($ss as $key => $val)
	{
		$selected = (isset($value) && $val[$keyname]==$value[0]) ? " selected" : "";
		echo "<option value=\"".$val[$keyname]."\"".$selected.">".$val[$textname]."</option>\n";
	}

	echo "</select>\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
