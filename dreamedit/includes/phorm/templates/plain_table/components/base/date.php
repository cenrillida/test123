<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?
	$dateType = array(
		"a" => "3",
		"A" => "11",
		"b" => "3",
		"B" => "8",
		"C" => "2",
		"d" => "2",
		"e" => "2",
		"H" => "2",
		"I" => "2",
		"j" => "3",
		"k" => "2",
		"l" => "2",
		"m" => "2",
		"M" => "2",
		"n" => "2",
		"p" => "2",
		"P" => "2",
		"S" => "2",
		"s" => "10",
		"t" => "4",
		"U" => "2",
		"W" => "2",
		"V" => "2",
		"u" => "1",
		"w" => "1",
		"y" => "2",
		"Y" => "4",
		"%" => "1",
	);

	$size = 0;
	preg_match_all("/%([aAbBCdeHIjklmMnpPSstUWVuwyY%])/i", $type, $matches);
	foreach($matches[1] as $v)
	{
		if(isset($dateType[trim($v)]))
			$size += $dateType[trim($v)];
	}
	$size = strlen($type) - count($matches[1]) * 2 + $size;

	echo "<input style=\"TEXT-ALIGN: right;\" type=\"text\" name=\"".$name."\" id=\"".$name."\" size=\"16\"  maxlength=\"16\" value=\"".$value."\" />\n";
	echo isset($buttons)? $buttons: "";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
