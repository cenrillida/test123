<?
global $_CONFIG, $site_templater;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

	if ($_SESSION[lang]!='/en')
	{
		if (!empty($_TPL_REPLACMENT["CONTENT"]) && $_TPL_REPLACMENT["CONTENT"]!='<p>&nbsp;</p>')
		{
            if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"])) {
                echo "<div id=\"editor-page-".$_REQUEST[page_id]."\">";
            }
            $_TPL_REPLACMENT["CONTENT"] = TextProcessor::processAllBuilders($_TPL_REPLACMENT["CONTENT"]);
			echo @$_TPL_REPLACMENT["CONTENT"];
            if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"])) {
                echo "</div>";
                ?>
                <script>
                    $( document ).ready(function() {
                        admin_editors.push("editor-page-<?=$_REQUEST[page_id]?>");
                    });
                </script>
                <?php
            }
		}
		else
		{
            if($_GET[debug]==2) {
                echo $_TPL_REPLACMENT["SUBMENU"];
            } else {
                include($_TPL_REPLACMENT["SUBMENU"]);
            }
		}
	}
	else
	{
	if (!empty($_TPL_REPLACMENT["CONTENT_EN"]) && $_TPL_REPLACMENT["CONTENT_EN"]!='<p>&nbsp;</p>')
	{
        if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"])) {
            echo "<div id=\"editor-page-".$_REQUEST[page_id]."\">";
        }
        $_TPL_REPLACMENT["CONTENT_EN"] = TextProcessor::processAllBuilders($_TPL_REPLACMENT["CONTENT_EN"]);
        echo @$_TPL_REPLACMENT["CONTENT_EN"];
        if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"])) {
            echo "</div>";
            ?>
            <script>
                $( document ).ready(function() {
                    admin_editors.push("editor-page-<?=$_REQUEST[page_id]?>");
                });
            </script>
            <?php
        }
	}
	else
	{

        if($_GET[debug]==2) {
            echo $_TPL_REPLACMENT["SUBMENU"];
        } else {
            include($_TPL_REPLACMENT["SUBMENU"]);
        }

	}
	}
	if (!isset($_REQUEST[printmode]))
	{
?>

        <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="https://yastatic.net/share2/share.js"></script>
        <div class="ya-share2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
<?
    }

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

?>
