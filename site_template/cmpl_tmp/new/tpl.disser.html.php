<?
$pg = new Pages();
//print_r($_TPL_REPLACMENT);

?>
 <? /* echo $_TPL_REPLACMENT["TITLE"]; */?></span>
<?
if ($_REQUEST[page_id]!=841 || substr($_TPL_REPLACMENT["DATE"],6,4)<2014)
{
    if(empty($_TPL_REPLACMENT["COMMON_TEXT"])) {
        if (substr($_TPL_REPLACMENT["DATE"], 6, 4) < 2014) {
            ?>
            <span class="date"><b><?= @$_TPL_REPLACMENT["DATE"] ?></b></span>

            <? echo " Опубликован автореферат диссертации на соискание ученой степени " ?>
            <?= @$_TPL_REPLACMENT["RANG"] ?>.


            <br/>
            <b><?= @$_TPL_REPLACMENT["FIO"] ?></b>
            <?
            echo str_replace("<p>", "", str_replace("</p>", "", $_TPL_REPLACMENT["PREV_TEXT"])); ?>. <br/>
            <?
            echo "Специальноcть " ?>
            <?= @$_TPL_REPLACMENT["SPEC"] ?>.<br/>


            <? echo "Защита диссертации состоится в <a href=/index.php?page_id=633>ИМЭМО РАН</a> " ?>

            <b><?= @$_TPL_REPLACMENT["DATE2"] ?></b>
            <? echo "в " ?> <?= @$_TPL_REPLACMENT["TIME"] ?>
            <? echo " в <a href=/index.php?page_id=552>диссертационном совете  " ?>
            <?= @$_TPL_REPLACMENT["SOVET"] ?></a>.

            <br/>

            <?
        } else  //2014 +
        {
            ?>
            <span class="date"><b><?= @$_TPL_REPLACMENT["DATE"] ?></b></span><br/>
            <b><?= @$_TPL_REPLACMENT["FIO"] ?></b><br/>
            Диссертация на тему: <?
            echo str_replace("<p>", "", str_replace("</p>", "", $_TPL_REPLACMENT["PREV_TEXT"])); ?>
            на соискание ученой степени <?= @$_TPL_REPLACMENT["RANG"] ?>. <?
            echo "Специальноcть " ?>
            <?= @$_TPL_REPLACMENT["SPEC"] ?>. <? if (!empty($_TPL_REPLACMENT["SPEC2"])) echo "Специальноcть " . $_TPL_REPLACMENT["SPEC2"] . "." ?>
            <br/>
            Диссертационный совет
            <a href=/index.php?page_id=<?= @$_TPL_REPLACMENT[SPAGE] ?>>
                <?= @$_TPL_REPLACMENT["SOVET"] ?></a><br/>
            <?
        }

    } else {
        ?>
        <span class="date"><b><?= @$_TPL_REPLACMENT["DATE"] ?></b></span><br/>
        <?php

        if($_TPL_REPLACMENT["TITLE_OFF"]!=1):?>
        <b><?= @$_TPL_REPLACMENT["FIO"] ?></b><br/>
        <?php endif;?>
    <?php
        echo $_TPL_REPLACMENT['COMMON_TEXT'];
    }
}
	if ($_REQUEST[page_id]==841)
	{ 
//		echo @$_TPL_REPLACMENT["REFER"];
//		echo @$_TPL_REPLACMENT["VERDICT"];
            echo $_TPL_REPLACMENT["FULL_TEXT"];
            echo $_TPL_REPLACMENT["REFER"];
            echo $_TPL_REPLACMENT["VERDICT"];
	}
	?>
<?
$_TPL_REPLACMENT[FULL_ID]=841;
 
if($_TPL_REPLACMENT["GO"] && !empty($_TPL_REPLACMENT["FULL_TEXT"]))
{
?>
<a href=/index.php?page_id=<?=@$_TPL_REPLACMENT["FULL_ID"]?>&id=<?=@$_TPL_REPLACMENT["EL_ID"]?>>подробнее...</a>
<?
}?>
<br clear="all" /><br />&nbsp; <br />
