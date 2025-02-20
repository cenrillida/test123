<tr valign="top"<?php if($seo_field) echo ' class="seo_field" style="display: none"';?>><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
	echo "<input type=\"text\" name=\"".$name."\" id=\"".$name."\" size=\"".$size."\"".(isset($maxlength)? " maxlength=\"".$maxlength."\"": "")." value=\"".htmlspecialchars($value)."\" />\n";
	echo isset($buttons)? $buttons: "";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
