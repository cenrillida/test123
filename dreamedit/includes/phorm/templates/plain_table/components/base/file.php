<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td>
<?php
	$number_of_files = isset($number_of_files) ? $number_of_files : 1;
	for ($i = 0; $i < $number_of_files; $i++) {
		if ($i != 0) echo "<tr><td>&nbsp;</td>\n";
		echo "<td>";
		echo "<input type=\"file\" name=\"".$name."[]\" size=\"".$size."\" />";

		if(!empty($value) && !empty($destination))
		{
			$destination = substr($destination, strlen($destination) - 1, 1) == "/"? $destination: $destination."/";
			echo "<br /><a href=\"".$destination.$value."\" target=\"_blank\" onclick=\"window.open(this.href, 'fileLink', width=100, height=100, resizable=1, scrollbars=1)\"></a>";
		}

		if(!empty($allowed_ext))
			echo "<p class=\"form_help\" style=\"MARGIN-BOTTOM: 0px;\">".translate("Допустимые расширения файла").": ".implode(", ", $allowed_ext).".</p>";

		if(!empty($denied_ext))
			echo "<p class=\"form_help\" style=\"MARGIN-BOTTOM: 0px;\">".translate("Запрещенные расширения файла").": ".implode(", ", $denied_ext).".</p>";

		if(!empty($allowed_types))
			echo "<p class=\"form_help\" style=\"MARGIN-BOTTOM: 0px;\">".translate("Допустимые mime-типы файла").": ".implode(", ", $allowed_types).".</p>";

		if(!empty($denied_types))
			echo "<p class=\"form_help\" style=\"MARGIN-BOTTOM: 0px;\">".translate("Запрещенные mime-типы файла").": ".implode(", ", $denied_types).".</p>";

		if(!empty($help))
			echo "<p class=\"form_help\">".$help."</p>";		

		echo "</td></tr>\n";
	}
?>
