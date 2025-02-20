<?
$pg = new Pages();
?>
<div class="col-12 p-2">
    <div class="bg-color-lightgray h-100 p-3 img-in-text-margin">
        <?
        if($_TPL_REPLACMENT["GO"])
        {
            if($_SESSION[lang]!="/en"):
                $more = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a style="font-style: italic;" href="'.$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"])).'">подробнее...</a>';
            else:
                $more = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a style="font-style: italic;" href="/en'.$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"])).'">more...</a>';
            endif;
        }?>
		<?
		if(isset($_GET[printmode])) {
			echo "".$_TPL_REPLACMENT["COUNTER_EL"].". &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$_TPL_REPLACMENT["DATE"];
		}
		?>
			<?php if ($_SESSION[lang]!="/en"): ?>
                 <?php if(!empty($_TPL_REPLACMENT["SMALL_PICTURE"])):?>
                 <div class="row">
                    <div class="col-2 text-center align-self-center">
                        <?=@$_TPL_REPLACMENT["SMALL_PICTURE"]?>
                    </div>
                    <div class="col-10">
                        <font size="2" class="act-comments-element-date" style="border-bottom: 1px solid #999;border-right: 1px solid #999; padding-right: 4px; padding-bottom: 1px; padding-left: 5px; color: #999;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</font>&nbsp;&nbsp;<b style=\"font-size: 15px;\">".@$_TPL_REPLACMENT["TITLE"]?></b>
                        <?php
                        $pos = strrpos($_TPL_REPLACMENT["PREV_TEXT"], "</p>");

                        if($pos !== false)
                        {
                            echo substr_replace($_TPL_REPLACMENT["PREV_TEXT"], " ".$more."</p>", $pos, strlen("</p>"));
                        } else {
                            echo $_TPL_REPLACMENT["PREV_TEXT"].$more;
                        }
                        ?>
                    </div>
                 </div>
                 <?php else:?>
        <p><font size="2" class="act-comments-element-date" style="border-bottom: 1px solid #999;border-right: 1px solid #999; padding-right: 4px; padding-bottom: 1px; padding-left: 5px; color: #999;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</font>&nbsp;&nbsp;<b style=\"font-size: 15px;\">".@$_TPL_REPLACMENT["TITLE"]?></b></p>
                     <?php
                     $pos = strrpos($_TPL_REPLACMENT["PREV_TEXT"], "</p>");

                     if($pos !== false)
                     {
                         echo substr_replace($_TPL_REPLACMENT["PREV_TEXT"], " ".$more."</p>", $pos, strlen("</p>"));
                     } else {
                         echo $_TPL_REPLACMENT["PREV_TEXT"].$more;
                     }
                     ?>
                 <?php endif;?>
			<?
			else:
				?>
				<font size="2" class="act-comments-element-date" style="border-bottom: 1px solid black;border-right: 1px solid black;padding-right: 4px;padding-bottom: 1px; padding-left: 5px;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</font>&nbsp;&nbsp;<b style=\"font-size: 15px;\">".@$_TPL_REPLACMENT["TITLE_EN"]?></b>
                    <?php
                    $pos = strrpos($_TPL_REPLACMENT["PREV_TEXT_EN"], "</p>");

                    if($pos !== false)
                    {
                        echo substr_replace($_TPL_REPLACMENT["PREV_TEXT_EN"], " ".$more."</p>", $pos, strlen("</p>"));
                    } else {
                        echo $_TPL_REPLACMENT["PREV_TEXT_EN"].$more;
                    }
                    ?>
			<?php endif; ?>


    </div>
</div>
