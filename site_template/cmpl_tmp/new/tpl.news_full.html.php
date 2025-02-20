<?
//print_r($_TPL_REPLACMENT);
if(isset($_TPL_REPLACMENT["STAT_VIEWS"])) {
    echo "<div style='text-align: right; color: #979797;'><img width='15px' style='vertical-align: middle' src='/img/eye.png'/> <span id='stat-views-counter' style='vertical-align: middle'>".$_TPL_REPLACMENT["STAT_VIEWS"]."</span></div>";
}
?>
<!--<span class="date"><b><?=@$_TPL_REPLACMENT["DATE"]?> <?=@$_TPL_REPLACMENT["TITLE"]?></b></span><br />-->
<!--<h5 class="date"><b><?=@$_TPL_REPLACMENT["TITLE"]?></b></h5><br /><br />/-->
<?php if(!empty($_TPL_REPLACMENT["PICTURE"])) echo $_TPL_REPLACMENT["PICTURE"]."<br />"?>
<?
if(!isset($_REQUEST[en]))
   echo $_TPL_REPLACMENT["FULL_TEXT"]."<br />";
else   
   echo $_TPL_REPLACMENT["FULL_TEXT_EN"]."<br />";