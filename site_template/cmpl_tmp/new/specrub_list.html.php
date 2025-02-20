<?
global $_CONFIG, $site_templater;
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=503;
//echo "<br />___".$_TPL_REPLACMENT["FULL_SMI_ID"].$_TPL_REPLACMENT["NEWS_LINE"];
$ilines = new Ilines();
$pg = new Pages();
//print_r($_TPL_REPLACMENT);

global $DB;
$specrubrics = $DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS rubric, ex.icont_text AS extra_section, exf.icont_text AS extra_section_flag, col.icont_text AS color_title, exm.icont_text AS extra_section_menu
                FROM adm_ilines_type AS c
               INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=13 
               INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
               INNER JOIN adm_ilines_content AS col ON col.el_id=e.el_id AND col.icont_var= 'title_color'
               INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var= 'sort'
               INNER JOIN adm_ilines_content AS ex ON ex.el_id=e.el_id AND ex.icont_var= 'extra_section'
               INNER JOIN adm_ilines_content AS exm ON exm.el_id=e.el_id AND exm.icont_var= 'extra_section_menu'
               INNER JOIN adm_ilines_content AS exf ON exf.el_id=e.el_id AND exf.icont_var= 'extra_section_flag'
               INNER JOIN adm_ilines_content AS st ON st.el_id=e.el_id AND st.icont_var= 'status'
               WHERE st.icont_text='1'
                 ORDER BY s.icont_text");
// All link
/*if($_GET[specrub]==-1)
	echo "<b>Все</b>";
else
	echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("specrub" => -1))."\">Все</a> ";
*/
echo '<ul class="speclist">';
foreach ($specrubrics as $key => $value) {
  $color_title = "";
  if(!empty($value['color_title']) && $value['color_title']!="")
    $color_title = " style=\"color: ".$value['color_title']."\"";
  if(!empty($value['extra_section_menu']) && $value['extra_section_menu']!="<p>&nbsp;</p>")
    echo $value['extra_section_menu'];
	echo "<li class=\"specrublist-element\"><a class=\"specrublist-link\"".$color_title." href=\"".$pg->getPageUrl(1101, array("specrub" => $value[id]))."\">".$value[rubric]."</a></li>";
	if($value[id]==5787) {
	    ?>
        <ul class="speclist">
        <li class="specrublist-element"><a class="specrublist-link" style="color: #8e8e8e" href="/index.php?page_id=1557&id=1">Трекер пандемии</a></li>
        </ul>
<?php
    }
}
echo "</ul>";

echo $_TPL_REPLACMENT['EX_INFO'];

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>