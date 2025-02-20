<?
include_once dirname(__FILE__)."/../../_include.php";
global $DB;
if($_ACTIVE["action"] == "index")
{
    $feed0=$DB->select("SELECT * FROM feedback ORDER BY date DESC");
    ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){


            $(".buts").delegate(".buts1", "click", function(){
                $(this).parent().find(".buts_text").stop().slideToggle();
                if($(this).parent().find(".buts1").text()=='Подробнее')
                    $(this).parent().find(".buts1").text('Скрыть');
                else
                    $(this).parent().find(".buts1").text('Подробнее');
            });
        });
    </script>
    <?php
    echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
    echo "<tr><td><a href='https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"] . "&id=all&action=del'>Удалить все записи</a><br><hr></td></tr>";
    foreach($feed0 as $k=>$feed)
    {

        echo "<tr>".
            "<td>".
            "<strong>".$feed[fio]."</strong>&nbsp;&nbsp;&nbsp;".
            substr($feed['date'],8,2)."/".substr($feed['date'],5,2)."/".substr($feed['date'],0,4).
            "<br />".
            "<a href='mailto:".$feed[email]."'>".$feed[email]."</a> ".$feed[telephone]."<br />".substr(strip_tags($feed[text]),0,100)."<br />";
        ?>

        <div class="buts"><a class="buts1" onclick="return false;" href="#">Подробнее</a><div class="buts_text" style="display: none;">
                <p><?=$feed[text]?></p>
            </div></div><br>
        <a href="https://<?=$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]?>index.php?mod=<?=$_REQUEST["mod"]?>&id=<?=$feed[id]?>&action=del">Удалить</a>
        <?php
        echo "<br /><br><hr>";
        echo "</td></tr>";
    }
    echo "</table>";
}

if($_ACTIVE["action"] == "del")
{
	if($_GET['id'] == "all")
	{
        $DB->query("TRUNCATE TABLE feedback");
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]);
	}
	else
	{
        $DB->query("DELETE FROM feedback WHERE id=".$_GET['id']);
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]);
	}
}

?>