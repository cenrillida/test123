<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td></tr>
<tr><td width="100%" class="checktree" id="checktree">
<?php

	$values = array();
	if(!empty($value))
	{
		$tmp = array2string($value);
		foreach($tmp as $v)
			$values[$name.$v] = 1;
	}

	createCheckTree($values, $options, isset($start)? $start: 0);
	echo "<br />";
	displaySubbuttons();

?>
<script>
function checkAll(on)
{
	var obj = getObj("checktree");
	var objCheckboxes = obj.getElementsByTagName("INPUT");
	for(var i = 0; i < objCheckboxes.length; i++)
		objCheckboxes[i].checked = on;

}

function invert()
{
	var obj = getObj("checktree");
	var objCheckboxes = obj.getElementsByTagName("INPUT");
	for(var i = 0; i < objCheckboxes.length; i++)
		objCheckboxes[i].checked = !objCheckboxes[i].checked;
}
</script>
</td></tr>


<?
// рисуем дерево чекбоксов
function createCheckTree(&$values, &$elements, $key = 0, $level = 0, $lastBrunche = array(), $last = true)
{
	global $_CONFIG;

	// выход при отсутствии ключа
	if(!isset($elements[$key]))
		return;

	// рисуем стр-ру дерева для каждой ветке в линии
	foreach($lastBrunche as $b)
		echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/".($b? "0": "dTree/line").".gif\" width=\"18\" height=\"18\" align=\"absmiddle\" />";

	// выставляем "последнесть" ветви в текущем уровне для последующих линий
	$lastBrunche[$level] = false;
	if($last)
		$lastBrunche[$level] = true;

	// отображение ветви и чекбокса
	echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/dTree/join".($last? "bottom": "").".gif\" align=\"absmiddle\" />";
	if(isset($elements[$key]["check"]))
		echo "<input type=\"checkbox\" name=\"".$key."\" value=\"1\"".(isset($values[$key])? " checked": "")." /> ".$elements[$key]["title"]."<br />";
	else
		echo "&nbsp;".$elements[$key]["title"]."<br />";

	// рисуем всех детей ветви
	$i = 1;
	foreach($elements[$key]["children"] as $v)
		createCheckTree($values, $elements, $v, $level + 1, $lastBrunche, $i++ == count($elements[$key]["children"]));
}


/* 
каждую из ветвей массива превращаем в строку
array(
	"b1" => array(
		"b11" => array(
			"b111" => array(
				"b1111",
				"b1112",
			),
		), 
		"b12",
	),
	"b2",
);
ппеределываем в 
array(
	"[b1][b11][b111][b1111]",
	"[b1][b11][b111][b1112]",
	"[b1][b12]",
	"[b2]",
);
используем для проверки включен эл-т или нет
*/
function array2string($val)
{
	$retStr = array();
	foreach($val as $k => $v)
	{
		if(is_array($v))
		{
			$tmp = array2string($v);
			foreach($tmp as $l)
				$retStr[] = "[".$k."]".$l;
		}
		else
			$retStr[] = "[".$k."]";
	}
	return $retStr;
}

function displaySubbuttons()
{
	echo "<span class=\"subbuttons\" onclick=\"checkAll(true)\">".Dreamedit::translate("отметить все")."</span>";
	echo "<span class=\"subbuttons\" onclick=\"checkAll(false)\">".Dreamedit::translate("убрать все")."</span>";
	echo "<span class=\"subbuttons\" onclick=\"invert()\">".Dreamedit::translate("инвертировать выделение")."</span>";
}
?>