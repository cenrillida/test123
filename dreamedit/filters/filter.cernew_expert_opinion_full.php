<?php
global $DB,$_CONFIG;
// Главная новость

$ilines = new Ilines();

$otdel = (int)$_TPL_REPLACMENT['OTDEL'];

$result = $ilines->getCerNews(array('3','16'),0,6, $otdel);



if(!empty($result)):
?>

<div class="container-fluid cer-expert-opinions-container">
    <div class="row cer-expert-opinions-row">
        <?php
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
                $more = "&nbsp; &nbsp; &nbsp; &nbsp;<a target='_blank' href=/index.php?page_id=1594&id=".$rows[id].">подробнее...</a>";

            if($pos !== false)
            {
                $full_text = substr_replace($rows["prev_text"], " ".$more."</p>", $pos, strlen("</p>"));
            } else {
                $full_text = $rows["prev_text"].$more;
            }

            $tpl = new Templater();
            $tpl->appendValues(array("EL_ID" => $rows[el_id]));
            $tpl->appendValues(array("FULL_TEXT" => $full_text));
            $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.cer_expert_opinion_element.html");

        }
        ?>
    </div>
    <div class="d-flex justify-content-center cer-expert-opinions-loader-main">
        <div class="spinner-border cer-expert-opinions-loader mt-5" role="status" style="display: none">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<script>
    events_page = 6;
    lockAjax = 0;

    function scrollCerExpertOpinionsAjax(e) {
        if($('.cer-expert-opinions-container')[0].getBoundingClientRect().bottom<1500) {
            if (lockAjax == 0) {
                lockAjax = 1;
                jQuery.ajax({
                    type: 'GET',
                    url: '<?=$_SESSION[lang]?>/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1&ajax_cer_expert_opinions_otdel=<?=$otdel?>&ajax_cer_expert_opinions=' + events_page,
                    success: function (data) {
                        events_page += 6;
                        var new_div = $(data).hide();
                        new_div.css("top","50px");
                        $('.cer-expert-opinions-row').append(new_div);
                        new_div.fadeIn({queue: false, duration: 700});
                        new_div.animate({top: 0, display: "block"},700);
                        if (data == "") {
                            lockAjax = 2;
                        }
                    },
                    complete: function (data) {
                        $('.cer-expert-opinions-loader').hide();
                        if (lockAjax == 2) {
                            lockAjax = 1;
                        } else {
                            lockAjax = 0;
                        }
                    },
                    beforeSend: function () {
                        $('.cer-expert-opinions-loader').show();
                    }
                })
            }
        }
    }

    window.onresize = scrollCerExpertOpinionsAjax;
    document.addEventListener('scroll', scrollCerExpertOpinionsAjax, false);

</script>
<script src="/newsite/js/holder.min.js"></script>
<?php endif;?>