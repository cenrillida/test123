<tr valign="top"><td nowrap>
<?
global $_CONFIG;
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<script type="text/javascript" src="/<?=$_CONFIG["global"]["paths"]["admin_dir"]?>/includes/SelectBox/prototype.js"></script>
<script type="text/javascript" src="/<?=$_CONFIG["global"]["paths"]["admin_dir"]?>/includes/SelectBox/dropdown.js"></script>
<link rel="stylesheet" href="/<?=$_CONFIG["global"]["paths"]["admin_dir"]?>/includes/SelectBox/style.css" />
<?php

//	$value = is_array($value)? $value: array($value);


	echo "<div class=\"select\" id=\"country\">";
	echo "<a href=\"#\" onclick=\"return observeOpener(this);\" class=\"dd-opener\">- select -</a>";
	echo "<a href=\"#\" onclick=\"return observeOpener(this);\" class=\"dd-opener pulldown_arrow\">&nbsp;</a>";
	echo "<ul class=\"selectbox\" style=\"width:250px\">";
	foreach($options as $val => $option)
	{
//		$selected = (isset($value) && in_array($val, $value))? " selected" : "";
		echo "<li><a href=\"#\" value=\"".$val."\">".$option."</a></li>";
//		echo "<option value=\"".$val."\"".$selected.">".$option."</option>\n";
	}
/*
			<li><a href="" value="1">Czech Republic</a></li>
			<li><a href="" value="3">Germany</a></li>
			<li><a href="" value="4">France</a></li>
			<li><a href="" value="5">Slovakia</a></li>
			<li><a href="" value="2">USA</a></li>*/
	echo "</ul>";
	echo "<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
	echo "</div>";


	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
