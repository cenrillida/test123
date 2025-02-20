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
                 ORDER BY d.icont_text DESC LIMIT 4
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
<div class="col-12 col-xl-12 pb-3 left-changable-12-6">
    <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative h-100">
        <div class="row">
            <?php if($rows[people]!='' && $rows[people]!='<br>'):
                $query = "SELECT picbig FROM persons WHERE id=".strstr($rows[people], '<', true);
                $result_smi_piar = $DB->select($query);
                $row_picbig_smi_piar = $result_smi_piar[0];
                if($row_picbig_smi_piar[picbig]!=''):
                ?>
                <div class="d-none d-md-block px-3 my-auto text-center">
                    <img src="/dreamedit/foto/<?=$row_picbig_smi_piar[picbig]?>" alt="" width="135">
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
?>


<div class="d-flex justify-content-center smi-full-loader-main">
    <div class="spinner-border smi-full-loader mt-5" role="status" style="display: none">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<div class="col-12 py-3 more-button-smi-full text-center">
    <div class="pr-red-title-a-main"><button class="pr-red-title-a pl-2 pr-2" target="_blank"><i class="fas fa-chevron-down"></i></button> <button class="pr-red-title-a-back smi-full-ajax" target="_blank"><i class="fas fa-chevron-down"></i></button></div>
</div>

<script>
    smi_full_count = 4;
    $( ".smi-full-ajax" ).on( "click", function(event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'GET',
            url: '/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1&ajax_smi_full='+smi_full_count,
            success: function (data) {
                smi_full_count += 8;
                $('.smi-full-loader-main').before(data);
                collumns_scroll();
            },
            complete: function (data) {
                $('.smi-full-loader').hide();
                $('.more-button-smi-full').show();
            },
            beforeSend: function () {
                $('.smi-full-loader').show();
                $('.more-button-smi-full').hide();
            }
        })
    });
</script>

