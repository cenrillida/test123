<?php
global $DB,$_CONFIG;
// Главная новость

$query = "SELECT c.el_id AS id,c.icont_text AS prev_text,rub.icont_text AS rubric,a.icont_text AS title,pe.icont_text AS people,sp.icont_text AS small_picture,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS rub ON rub.el_id=a.el_id AND rub.icont_var='rubric'
				 INNER JOIN adm_ilines_content AS pe ON pe.el_id=a.el_id AND pe.icont_var='people'
				 INNER JOIN adm_ilines_content AS sp ON sp.el_id=a.el_id AND sp.icont_var='small_picture'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=a.el_id AND nh.icont_var='nohome'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=5
				 WHERE a.icont_var='title' AND s.icont_text=1 AND rub.icont_text=439 AND (nh.icont_text IS NULL OR nh.icont_text=0)
                 ORDER BY d.icont_text DESC LIMIT 1
                ";
$result = $DB->select($query);

$count_firstnews=0;
foreach($result as $rows)
{
    if(isset($rows["date"]))
    {
        preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows["date"], $matches);
        $rows["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
        $rows["date"] = date("d.m.Y", $rows["date"]);
    }
?>
<div class="col-12 pb-3">
    <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative h-100">
        <div class="row">
            <?php if($rows[people]!='' && $rows[people]!='<br>'):
                $query = "SELECT picbig FROM persons WHERE id=".strstr($rows[people], '<', true);
                $result_smi_piar = $DB->select($query);
                $row_picbig_smi_piar = $result_smi_piar[0];
                if($row_picbig_smi_piar[picbig]!=''):
                ?>
                <div class="d-none d-md-block col-md my-auto text-center">
                    <img src="/dreamedit/foto/<?=$row_picbig_smi_piar[picbig]?>" alt="">
                </div>
            <?php
                endif;
                endif;?>
            <div class="col my-auto">
                <div class="massmedia-element link-color-text">
                    <div class="massmedia-element-header mb-2"><div class="massmedia-date"><?=$rows[date]?></div></div>
                    <?=$rows[prev_text]?>
                </div>
            </div>
        </div>
        <div class="news-upper-link position-absolute"><a target="_blank" href="/index.php?page_id=503&amp;id=<?=$rows[id]?>"><i class="fas fa-link"></i></a></div>
        <a target="_blank" href="/index.php?page_id=503&amp;id=<?=$rows[id]?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
    </div>
</div>
<?php
}