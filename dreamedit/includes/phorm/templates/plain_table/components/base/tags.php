<script language="JavaScript">
function tag_select(tt)
{

   for(i=0;i<document.data_form.tags_select.length;i++)
   {
   	   if(document.data_form.tagslist.value==document.data_form.tags_select[i].value)
   	      break;
   }

   if (i>=document.data_form.tags_select.length)
   {
	   var txt=document.data_form.<?=$name?>;

	   if (txt.value!=null && txt.value!="")
	       txt.value=txt.value+';'+ document.data_form.tagslist.value;
	   else
	       txt.value=document.data_form.tagslist.value;
   }
   else
      alert("Это слово уже выбрано");
}
</script>
<tr valign="top"><td nowrap>
<?php

	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";

	$type = isset($type)? $type: "Publ";

	global $DB;
// Считать тэги
if ($type=="Pages")
    $rows=$DB->select("SELECT cv_text AS keyword FROM adm_pages_content WHERE cv_name='tags'");
if ($type=="Publ" )
    $rows=$DB->select("SELECT keyword FROM publ ");

foreach($rows as $row)
{
  $kws=explode(";",trim($row[keyword]));
  foreach($kws as $k=>$kw)
  {
  	$k=trim($kw);
  	if (!empty($kw) && trim($kw)!="-" && trim($kw)!="." && $kw!="")
  	{
  		if (empty($tags[mb_strtolower($k)])) $tags[mb_strtolower($k)]=0;
  		$tags[mb_strtolower($k)]++;

  	}
  }

}
if (count($tags)>0) ksort($tags);


?>
</td><td width="100%">
<table>
<tr>
<td  valign='top'>

<?php
	$val0=explode(";",htmlspecialchars($value));
	echo "<div style='display:none;'>";
	echo "<select name='tags_select' type='hidden'>";
	foreach($val0 as $val)
	{
		echo "<option value='".$val."'></options>";
	}
	echo "</select>";
	echo "</div >";
	echo "<textarea name=\"".$name."\" id=\"".$name."\" cols=\"".$cols."\" rows=\"".$rows."\">".htmlspecialchars($value)."</textarea>\n";
	echo isset($buttons)? $buttons: "";

?>
</td>
<td valign='top'>
<!-- Вывести тэги -->
<select name='tagslist' size=10 onChange=tag_select(this) >
<?
foreach($tags as $tag=>$count)
{
   echo "<option value='".$tag."' index >".$tag."</a>";
}
?>
</select>


</td>
</tr>
</table>
<?

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
