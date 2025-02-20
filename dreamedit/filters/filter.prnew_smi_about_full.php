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
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=5
				 WHERE a.icont_var='title' AND s.icont_text=1 AND rub.icont_text=440
                 ORDER BY d.icont_text DESC LIMIT 0,3
                ";
$result = $DB->select($query);


foreach($result as $rows)
{
    if(isset($rows["date"]))
    {
        preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows["date"], $matches);
        $rows["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
        $rows["date"] = date("d.m.Y", $rows["date"]);
    }

    $pos = strrpos($rows["prev_text"], "</p>");

    $full_text = "";
    $more = "";
    if (!empty($rows[full_text]))
        $more = "&nbsp; &nbsp; &nbsp; &nbsp;<a target='_blank' href=/index.php?page_id=502&id=".$rows[id].">подробнее...</a>";

    if($pos !== false)
    {
        $full_text = substr_replace($rows["prev_text"], " ".$more."</p>", $pos, strlen("</p>"));
    } else {
        $full_text = $rows["prev_text"].$more;
    }


?>
    <div class="col-12 pb-3">
        <div class="shadow border bg-white p-3 h-100 position-relative">
            <div class="col-12 p-2">
                <div class="img-in-text-margin printables">
                    <div class="row">
                        <div class="col-12 col-md-2 text-center align-self-center">
                            <?=$rows['small_picture']?>
                        </div>
                        <div class="col-12 col-md-10">
                            <b style="font-size: 15px;"><?=$rows['title']?></b>
                            <?=$full_text?>
                        </div>
                    </div>
                </div>
            </div>
            <a target='_blank' href="/index.php?page_id=502&amp;id=<?=$rows[id]?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
        </div>
    </div>
<?php


}

?>

<div class="d-flex justify-content-center smi-about-full-loader-main">
    <div class="spinner-border smi-about-full-loader mt-5" role="status" style="display: none">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<div class="col-12 py-3 more-button-smi-about-full text-center">
    <div class="pr-red-title-a-main"><button class="pr-red-title-a pl-2 pr-2" target="_blank"><i class="fas fa-chevron-down"></i></button> <button class="pr-red-title-a-back smi-about-full-ajax" target="_blank"><i class="fas fa-chevron-down"></i></button></div>
</div>

<script>
    smi_about_full_count = 3;
    $( ".smi-about-full-ajax" ).on( "click", function(event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'GET',
            url: '/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1&ajax_smi_about_full='+smi_about_full_count,
            success: function (data) {
                smi_about_full_count += 3;
                $('.smi-about-full-loader-main').before(data);
            },
            complete: function (data) {
                $('.smi-about-full-loader').hide();
                $('.more-button-smi-about-full').show();
            },
            beforeSend: function () {
                $('.smi-about-full-loader').show();
                $('.more-button-smi-about-full').hide();
            }
        })
    });
</script>