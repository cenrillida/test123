<?php
global $DB, $_CONFIG;

$ilines = new Ilines();
$ievent = new Events();

$otdel = (int)$_TPL_REPLACMENT['OTDEL'];

$rows = $ilines->getCerNews(array('4','18'),0,8, $otdel);

if(!empty($rows))
{
    ?>
    <div class="container-fluid cerconferences-container">
        <div class="row cerconferences-row">
            <?php
            foreach ($rows as $k => $v) {
                $tpl = new Templater();
                $tpl->appendValues(array("EL_ID" => $v[el_id]));
                $tpl->appendValues(array("LAST_TEXT" => $v["last_text"]));
                $tpl->appendValues(array("MD" => '12'));
                $tpl->appendValues(array("LG" => '6'));
                $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.cernews_element.html");
            }
            ?>
        </div>
        <div class="d-flex justify-content-center cerconferences-loader-main">
            <div class="spinner-border cerconferences-loader mt-5" role="status" style="display: none">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <script>
        events_page = 8;
        lockAjax = 0;

        function scrollCerConferencesAjax(e) {
            if($('.cerconferences-container')[0].getBoundingClientRect().bottom<1500) {
                if (lockAjax == 0) {
                    lockAjax = 1;
                    jQuery.ajax({
                        type: 'GET',
                        url: '<?=$_SESSION[lang]?>/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1&ajax_cerconferences_otdel=<?=$otdel?>&ajax_cerconferences=' + events_page,
                        success: function (data) {
                            events_page += 8;
                            var new_div = $(data).hide();
                            new_div.css("top","50px");
                            $('.cerconferences-row').append(new_div);
                            new_div.fadeIn({queue: false, duration: 700});
                            new_div.animate({top: 0, display: "block"},700);
                            if (data == "") {
                                lockAjax = 2;
                            }
                        },
                        complete: function (data) {
                            $('.cerconferences-loader').hide();
                            if (lockAjax == 2) {
                                lockAjax = 1;
                            } else {
                                lockAjax = 0;
                            }
                        },
                        beforeSend: function () {
                            $('.cerconferences-loader').show();
                        }
                    })
                }
            }
        }

        window.onresize = scrollCerConferencesAjax;
        document.addEventListener('scroll', scrollCerConferencesAjax, false);

    </script>
    <script src="/newsite/js/holder.min.js"></script>
    <?php
}?>