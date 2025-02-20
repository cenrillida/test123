<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content, $DB;

function newsRatingEcho($interval) {
    global $DB;

    if($_SESSION[lang]!="/en") {
        $lang_prefix = "";
        $lang_prefix_down = "";
    } else {
        $lang_prefix = "-en";
        $lang_prefix_down = "_en";
    }

//    $news = $DB->select("SELECT t.icont_text AS title, pr.news_id, et.itype_id AS type_id
//                              FROM page_rating AS pr
//                              INNER JOIN adm_ilines_content AS t ON t.el_id=pr.news_id AND t.icont_var='title".$lang_prefix_down."'
//                              INNER JOIN adm_ilines_element AS et ON et.el_id=pr.news_id
//                              WHERE pr.page_type='newsfull".$lang_prefix."' AND pr.interval_days=".$interval."
//                              ORDER BY pr.place");

    $news = Statistic::getTopNews($interval, $lang_prefix, 5, true);

    $first_el = true;
    foreach ($news as $item):
        $news_more_page = 502;
        if($item['type_id']==5)
            $news_more_page = 503;?>
    <?php if(!$first_el):?>
    <?php else: $first_el=false;?>
    <?php endif;?>
        <div class="col-12 pb-3">
            <a class="font-size-sm" style="font-size: 15px;" href="<?=$_SESSION[lang]?>/index.php?page_id=<?=$news_more_page?>&id=<?=$item['news_id']?>"><?=$item['title']?></a>
        </div>
    <?php endforeach;
}


    ?>
<div class="row" id="rating-news-section">
    <div class="col-12 col-md pb-3">
        <div class="shadow bg-white p-3 h-100 position-relative">
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo "ТОП новостей за сегодня"; else echo "TOP Daily News";?></h5>
                </div>
            </div>
            <div class="row" id="news-rating-day">
                <div class="col d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md pb-3">
        <div class="shadow bg-white p-3 h-100 position-relative">
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo "ТОП новостей за неделю"; else echo "TOP Weekly News";?></h5>
                </div>
            </div>
            <div class="row" id="news-rating-week">
                <div class="col d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md pb-3">
        <div class="shadow bg-white p-3 h-100 position-relative">
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo "ТОП новостей за месяц"; else echo "TOP Monthly News";?></h5>
                </div>
            </div>
            <div class="row" id="news-rating-month">
                <div class="col d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery( document ).ready(function() {
        let options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.1,
        };

        let ratingLoaded = false;
        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if(entry.isIntersecting && !ratingLoaded) {
                    ratingLoaded = true;
                    jQuery.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '<?=$_SESSION[lang]?>/index.php?page_id=1562&ajax_get_elements_mode=news_rating',
                        success: function (data) {
                            jQuery('#news-rating-day').html(data.day.html);
                            jQuery('#news-rating-week').html(data.week.html);
                            jQuery('#news-rating-month').html(data.month.html);
                        }
                    });
                }
                // Each entry describes an intersection change for one observed
                // target element:
                //   entry.boundingClientRect
                //   entry.intersectionRatio
                //   entry.intersectionRect
                //   entry.isIntersecting
                //   entry.rootBounds
                //   entry.target
                //   entry.time
            });
        }, options);
        let target = document.querySelector("#rating-news-section");
        observer.observe(target);
    });
</script>