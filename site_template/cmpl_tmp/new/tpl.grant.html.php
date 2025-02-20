<?
$pg = new Pages();
//print_r($_TPL_REPLACMENT);
?>
<? /* echo $_TPL_REPLACMENT["DATE"];*/ ?></span>
<ul>
<li>
<strong><?=@$_TPL_REPLACMENT["TITLE_NEWS"]?></strong>
</li>
<?php 
global $DB;
$rows_grant = $DB->select("SELECT * FROM adm_nirs_content WHERE el_id=".(int)$_TPL_REPLACMENT["EL_ID"]." AND icont_var='gr_content'");

$gr_cont="";
foreach ($rows_grant as $k => $v) {
	$gr_cont=$v['icont_text'];
}

if(!empty($gr_cont) && $gr_cont!='<p>&nbsp;</p>'){?>
<div class="buts"><a class="buts1" onclick="return false;" href="#">Подробнее</a><div class="buts_text" style="display: none"><?php echo $gr_cont;?></div></div>
<?php }?>
<blockquote dir="ltr" style="margin-right: 0px"><blockquote dir="ltr" style="margin-right: 0px">
<?
if(!empty($_TPL_REPLACMENT["OTDEL"]))
   echo $_TPL_REPLACMENT["OTDEL"]."<br />";
?>
<?=@$_TPL_REPLACMENT["NUMBER"]?><br />
Руководитель: <?=@$_TPL_REPLACMENT["REGALII"]?>&nbsp;<?=@$_TPL_REPLACMENT["FIO"]?><br />
<?php

if(!empty($_TPL_REPLACMENT["FIOEXE"])):?>
Исполнитель: <?=@$_TPL_REPLACMENT["REGALIIEXE"]?>&nbsp;<?=@$_TPL_REPLACMENT["FIOEXE"]?><br />
<?php endif;?>
Срок выполнения: <?=@$_TPL_REPLACMENT["YEAR_BEG"]?> - <?=@$_TPL_REPLACMENT["YEAR_END"]?>
</blockquote></blockquote>
</ul>

