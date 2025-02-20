<?
global $_CONFIG,$DB,$page_content;

$mz=new Magazine();

$headers = new Headers();

//print_r($_SESSION);

if ($_SESSION[lang]=='/en') $suff="_en";else $suff="";

$rightBlockName = "Текст - Правая колонка";

$rightBlockPage = $DB->select("SELECT rightblock FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);

if(!empty($rightBlockPage[0][rightblock]))
    $rightBlockName = $rightBlockPage[0][rightblock];

$elements = $headers->getHeaderElements($rightBlockName);
$rows=$DB->select("SELECT cv_text FROM adm_pages_content WHERE page_id=".(int)$_REQUEST[page_id].
    " AND (cv_text<>'' AND cv_text<>'<p>&nbsp;</p>') AND cv_name='reclama".$suff."'");
//print_r($page_content);
$template=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
$rowsm=$mz->getMagazineAllYear($_SESSION[jour_id]);

if (substr($template[0][page_template],0,8)=='magazine' || $template[0][page_template]=='login_meimo')
{

    include_once("block_magazine_right.php");


}
else
{
//if (count($rows)>0)
//{
    $tpl = new Templater();
//	$tpl->setValues($rows[0][cv_text]);
    $tpl->appendValues(array("CCLASS" => "Пустой"));
    $tpl->appendValues(array("CTYPE" => "Текст"));
    $tpl->appendValues(array("TITLE" => "Обратите внимание"));
    $tpl->appendValues(array("TEXT" => $rows[0][cv_text]));
    $tpl->appendValues(array("TEXT_EN" => $rows[0][cv_text]));
    $tpl->appendValues(array("SHOWTITLE" => 1));

    if($rows[0][cv_text]!="" && $rows[0][cv_text]!="<p>&nbsp;</p>")
    {
        echo '<div class="box">';
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
        echo '</div>';
    }
//}
    if(!empty($elements))
    {
        $num = 1;
        foreach($elements as $k => $v)
        {

            $tpl = new Templater();
            $tpl->setValues($v);
            if($v[el_id]==109)
            {
                $archive_block=$DB->select("SELECT page_parent,page_link FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
                if(isint($archive_block[0][page_link]) && $archive_block[0][page_link]!="")
                    $archive_block=$DB->select("SELECT page_parent FROM adm_pages WHERE page_id=".$archive_block[0][page_link]);
                //echo "<a hidden=true href=block_test>".$archive_block[0][page_link]."</a>";

                if($archive_block[0][page_parent]!=444)
                {
                    continue;
                }



            }
            if($v["ctype"] == "Фильтр")
                $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

            //echo "<a hidden=true href=aaa>".$v[el_id]."</a>";
            $tpl->appendValues(array("SHOWTITLE" => 1));
            echo '<div class="box">';
            $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
            echo '</div>';

            $num++;
        }


    }

}
?>