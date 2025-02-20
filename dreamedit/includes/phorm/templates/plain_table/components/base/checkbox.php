<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
//	if(!is_array($value))
//		$value = array($value);

	if(is_array($options))
	{
		foreach ($options as $key => $option) {
			$checked = (isset($value[$key]) && $value[$key] == 1) ? " checked": "";
			echo "<input type=\"checkbox\" name=\"".$name."[".$key."]\" value=\"1\"".$checked." />\n";
			echo " ".$option."<br />";
		}
	}
	else
	{
		$checked = (isset($value) && $value == 1) ? " checked": "";
		echo "<input type=\"checkbox\" name=\"".$name."\" value=\"1\"".$checked." />\n";
		echo " ".$options."<br />";
	}

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
