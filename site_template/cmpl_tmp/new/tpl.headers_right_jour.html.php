<?

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
?>
<div class="position-relative">
    <div class="position-absolute" style="top: 5px; left: 5px; z-index: 2">
        <a target="_blank" href="/dreamedit/index.php?mod=headers&action=edit&type=l&id=<?=$_TPL_REPLACMENT['HEADER_ID_EDIT']?>"><i class="fas fa-edit text-danger bg-white p-1"></i></a>
    </div>


    <?php
    }

if ($_SESSION["lang"]=='/en' || !empty($_TPL_REPLACMENT["TEXT"]) || $_TPL_REPLACMENT["CTYPE"] =="Фильтр")
{

	if ($_SESSION["lang"]!='/en') $suff='';else $suff='_EN';
    if (!empty($_TPL_REPLACMENT["TITLENEW".$suff])) $_TPL_REPLACMENT["TITLE".$suff]=$_TPL_REPLACMENT["TITLENEW".$suff];

    if(($_TPL_REPLACMENT["CTYPE"] == "Фильтр" && !empty($_TPL_REPLACMENT["FILTERCONTENT"])) || $_TPL_REPLACMENT["CTYPE"] != "Фильтр"):
            if($_TPL_REPLACMENT["SHOWTITLE"]): ?>
            <div class="row justify-content-center mb-3">
                <div class="col-12">
                    <h5 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?=$_TPL_REPLACMENT["TITLE".$suff]?></h5>
                </div>
            </div>
            <?endif;
    endif;
	if($_TPL_REPLACMENT["CTYPE"] == "Фильтр")
	{
	    echo '<div class="row justify-content-center mb-3">';?>
<div class="col-12 pb-3">
    <div class="shadow border bg-white p-3 h-100">
        <div class="row">
            <div class="col-12">

        <?php
	        include($_TPL_REPLACMENT["FILTERCONTENT"]);
?>
            </div>
        </div>
    </div>
</div>
                <?php
	    echo '</div>';
	}
	else if($_TPL_REPLACMENT["CTYPE"] == "Текст")
	{
	    ?>
            <div class="row justify-content-center mb-3">
                <div class="col-12 pb-3">
                    <div class="shadow border bg-white p-3 h-100">
                        <div class="row">
                            <div class="col-12">
                                <?=$_TPL_REPLACMENT["TEXT".$suff]?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?
	}
	else if($_TPL_REPLACMENT["CTYPE"] == "Jour")
	{

		$aa=explode('src="',$_TPL_REPLACMENT["TEXT".$suff]);
		$aa2=explode('"',$aa[1]);

		echo "<div style='height:236px;background: url(".$aa2[0].") no-repeat';>";
		echo "<div style='text-align:right;position:relative;right:10px;top:170px;color:white;'>";
		echo "".$_TPL_REPLACMENT["ISSN"]."<br />";
		if (!empty($_TPL_REPLACMENT["IMPACT"]))
		if ($_SESSION["lang"]!='/en' )
			echo "Импакт-фактор РИНЦ: ".$_TPL_REPLACMENT["IMPACT"]."<br />";
		else
			echo "Impact-factor RINC: ".$_TPL_REPLACMENT["IMPACT"]."<br />";

		echo "".$_TPL_REPLACMENT['SERIES'.$suff]."<br />";
		echo "</div>";
		echo "</div>";
		echo "<h2>".$_TPL_REPLACMENT["PAGE_NAME_EN"]."</h2>";
	//	echo $_TPL_REPLACMENT["TEXT".$suff];
	}
}

    if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
    ?>
</div>
<?php
}
?>

