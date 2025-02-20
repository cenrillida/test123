<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

// Анонсы на главной

$news = new News();



$pg = new Pages();

$announcements = $news->getAnnouncements();
if(!empty($announcements)) {
    ?>

    <div class="announce-row row justify-content-center">
    <?php
    foreach ($announcements as $k=>$v) {
        ?>
            <div class="announce-element col-lg-3 col-md-6 col-xs-12 pb-3<?php if ($count >= 3) echo ' d-none d-lg-block'; ?>" data-announce="<?=$v[el_id]?>" id="announce-<?=$v[el_id]?>">
                <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="massmedia-element">
                                <div class="massmedia-element-header mb-2">
                                    <div style="color: darkgrey;"><?= $v["content"]["DATE_WORD"] ?> | <i
                                                class="far fa-clock"></i> <?= $v["content"]["TIME_WORD"] ?>
                                    </div>
                                    <div class="announce-element-text"><?= $v["content"]["PREV_TEXT"] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-upper-link position-absolute"><a
                                href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?><?= $pg->getPageUrl($page_content["NEWS_BLOCK_PAGE"], array("id" => $v[el_id], "p" => @$_REQUEST["p"])) ?>"><i
                                    class="fas fa-link"></i></a></div>
                    <a href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?><?= $pg->getPageUrl($page_content["NEWS_BLOCK_PAGE"], array("id" => $v[el_id], "p" => @$_REQUEST["p"])) ?>"
                       class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight"
                       draggable="true"></a>
                </div>
            </div>
        <?php if($_GET[debug]==5):?>
            <div class="announce-element col-lg-3 col-md-6 col-xs-12 pb-3" data-announce="123" id="announce-123">
                <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="massmedia-element">
                                <div class="massmedia-element-header mb-2">
                                    <div style="color: darkgrey;">29 апреля 2020 | <i class="far fa-clock"></i> 15:00                                    </div>
                                    <div class="announce-element-text"><p><strong>Александр Дынкин</strong>&nbsp;станет гостем программы "Танец черных лебедей" на "Горчаков-ТВ".&nbsp;Сначала зрители увидят видеолекцию Елены Телегиной, а затем президент ИМЭМО РАН ответит на вопросы аудитории.&nbsp;Необходима предварительная регистрация.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-upper-link position-absolute"><a href="/news/events/text?id=123"><i class="fas fa-link"></i></a></div>
                    <a href="/news/events/text?id=123" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                </div>
            </div>
            <div class="announce-element col-lg-3 col-md-6 col-xs-12 pb-3" data-announce="1234" id="announce-1234">
                <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="massmedia-element">
                                <div class="massmedia-element-header mb-2">
                                    <div style="color: darkgrey;">29 апреля 2020 | <i class="far fa-clock"></i> 15:00                                    </div>
                                    <div class="announce-element-text"><p><strong>Александр Дынкин</strong>&nbsp;станет гостем программы "Танец черных лебедей" на "Горчаков-ТВ".&nbsp;Сначала зрители увидят видеолекцию Елены Телегиной, а затем президент ИМЭМО РАН ответит на вопросы аудитории.&nbsp;Необходима предварительная регистрация.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-upper-link position-absolute"><a href="/news/events/text?id=123"><i class="fas fa-link"></i></a></div>
                    <a href="/news/events/text?id=123" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                </div>
            </div>
            <div class="announce-element col-lg-3 col-md-6 col-xs-12 pb-3 d-none d-lg-block" data-announce="12345" id="announce-12345">
                <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="massmedia-element">
                                <div class="massmedia-element-header mb-2">
                                    <div style="color: darkgrey;">29 апреля 2020 | <i class="far fa-clock"></i> 15:00                                    </div>
                                    <div class="announce-element-text"><p><strong>Александр Дынкин</strong>&nbsp;станет гостем программы "Танец черных лебедей" на "Горчаков-ТВ".&nbsp;Сначала зрители увидят видеолекцию Елены Телегиной, а затем президент ИМЭМО РАН ответит на вопросы аудитории.&nbsp;Необходима предварительная регистрация.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="news-upper-link position-absolute"><a href="/news/events/text?id=123"><i class="fas fa-link"></i></a></div>
                    <a href="/news/events/text?id=123" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                </div>
            </div>
        <?php endif;?>
        <?php
    }
    ?>
    </div>
    <?php if($_GET[debug]==5):?>
    <script>

        var cards = document.querySelectorAll('.announce-element');

        var cardsOldInfo = //example content
            {"cardId": {
                    "x": 100,
                    "y": 200,
                    "width": 100
                }
            };
        var cardsNewInfo = cardsOldInfo;

        function removeCard(card){
            cardsOldInfo = getCardsInfo();
            //card.parentNode.removeChild(card);
            $('#announce-'+card.dataset.announce).hide("fade", {}, 700, function() {
                card.parentNode.removeChild(card);
                cardsNewInfo = getCardsInfo();
                moveCards();
            });
        }

        function getCardsInfo(){
            updateCards();
            var cardsInfo = {};
            cards.forEach(function (card) {
                var rect = card.getBoundingClientRect();
            cardsInfo[card.id] = {
                "x": rect.left,
                "y": rect.top,
                "width": (rect.right - rect.left)
            };
        });
            return cardsInfo;
        }

        function moveCards(){
            updateCards();
            cards.forEach(function (card) {
                var translateX = cardsOldInfo[card.id].x - cardsNewInfo[card.id].x;
                var translateY = cardsOldInfo[card.id].y -cardsNewInfo[card.id].y;
                var scaleX = cardsOldInfo[card.id].width/cardsNewInfo[card.id].width;
                card.animate([
                    {
                        transform: 'translate('+translateX+'px, '+translateY+'px) scaleX('+scaleX+')'
                    },
                    {
                        transform: 'none'
                    }
                ], {
                    duration: 250,
                    easing: 'ease-out'
                });
        });
        }

        function updateCards(){
            cards = document.querySelectorAll('.announce-element');
        }


        /*jQuery( document ).ready(function() {
            jQuery.ajax({
                type: 'GET',
                dataType: 'json',
                url: '<?=$_SESSION[lang]?>/index.php?page_id=1562&ajax_get_elements_mode=announce<?php if ($_SESSION[lang] == "/en") echo "&ajax_stat_lang=en";?>',
                success: function (data) {
                    if(data.length === 0) {
                        $('.announce-row').closest('section').hide(300);
                    } else {
                        var existElements = Array();

                        $('div.announce-element').each(function() {
                            var element = $(this);
                            var id = element.data('announce')+"";

                            if($.inArray( id, existElements ) == -1)
                                existElements.push(id);
                        });


                        for (var k in data) {
                            var divElement = document.createElement("div");
                            divElement.innerHTML = data[k].text;

                            var element = $('#announce-' + k).find('.announce-element-text');

                            if (element.length !== 0) {
                                var index = existElements.indexOf(k+"");
                                if (index > -1) {
                                    existElements.splice(index, 1);
                                }
                                if (divElement.innerHTML != element[0].innerHTML) {
                                    element[0].innerHTML = divElement.innerHTML;
                                }
                            }
                        }

                        existElements.forEach(function(el) {
                            var element = $('#announce-' + el);
                            element.hide("fade", {}, 700, function () {
                                $('.announce-element').animate();
                            });
                        });
                    }
                }
            })
        });*/
    </script>
    <?php
    endif;
}

?>
