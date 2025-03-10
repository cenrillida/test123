<?php
global $DB,$_CONFIG,$page_content;
// ������� �������

if(!empty($_TPL_REPLACMENT["PERSON"])) {
    $person = (int)$_TPL_REPLACMENT["PERSON"];
    $personSql = " AND (pe.icont_text LIKE '".$person."<br>%' OR
                           pe.icont_text LIKE '%<br>".$person."<br>%' OR
                           pe.icont_text LIKE '%<br>".$person."')";
} else {
    $personSql = "";
}

$query = "SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,pe.icont_text AS people,d.icont_text AS date,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date,f.icont_text AS full_text
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS pe ON pe.el_id=a.el_id AND pe.icont_var='people'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 INNER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=1
				 WHERE a.icont_var='title' AND s.icont_text=1".$personSql."
                 ORDER BY d.icont_text DESC LIMIT 0,3";
$result = $DB->select($query);

$pg = new Pages();



foreach($result as $rows)
{
    if(isset($rows["date"]))
    {
        preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows["date"], $matches);
        $rows["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
        $rows["date"] = date("d.m.Y", $rows["date"]);
    }

    ?>
    <div class="col-12 col-md-6 col-xl-12 pb-3 right-changable-12-4">
        <div class="shadow border bg-white p-3 h-100 position-relative">
            <div class="row">
                <div class="col-12 text-right">
                    <div style="color: darkgrey;"><?=$rows["date"]?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="news-element">
                        <?=$rows[prev_text]?>
                        <?php if(!empty($rows[full_text]) && $rows[full_text]!='<p>&nbsp;</p>'):?>
                            <p><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $rows[id]))?>"><?php if ($_SESSION[lang]!="/en") echo '���������...'; else echo "more...";?></a></p>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <?php if(!empty($rows[full_text]) && $rows[full_text]!='<p>&nbsp;</p>'):?>
                <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $rows[id]))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
            <?php endif;?>
        </div>
    </div>
    <?php


}
?>

<div class="d-flex justify-content-center president-news-loader-main">
    <div class="spinner-border president-news-loader mt-5" role="status" style="display: none">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<div class="col-12 py-3 more-button-president-news text-center">
    <div class="pr-red-title-a-main"><button class="pr-red-title-a pl-2 pr-2" target="_blank"><i class="fas fa-chevron-down"></i></button> <button class="pr-red-title-a-back president-news-ajax" target="_blank"><i class="fas fa-chevron-down"></i></button></div>
</div>

<script>
    president_news_count = 3;
    $( ".president-news-ajax" ).on( "click", function(event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'GET',
            url: '/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1&ajax_president_news='+president_news_count,
            success: function (data) {
                president_news_count += 6;
                $('.president-news-loader-main').before(data);
                collumns_scroll();
            },
            complete: function (data) {
                $('.president-news-loader').hide();
                $('.more-button-president-news').show();
            },
            beforeSend: function () {
                $('.president-news-loader').show();
                $('.more-button-president-news').hide();
            }
        })
    });
</script>


