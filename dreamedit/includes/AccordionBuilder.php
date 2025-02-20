<?php

class AccordionBuilder
{
    private $id;
    private $elements;

    /**
     * @param $id
     * @param $elements
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $html = "<div class=\"accordion mb-3\" id=\"accordion{$this->id}\">";
        $pg = new Pages();

        $accordionConfig = $pg->getContentByPageId($this->id);
        $accordionLike = '';
        if($accordionConfig['ACCORDION_LIKE']) {
            $accordionLike = " data-parent=\"#accordion{$this->id}\"";
        }

        $accordionElements = $pg->getChilds($this->id, null, null, null, null, 'accordion_element');
        $accordionElements = $pg->appendContent($accordionElements);

        foreach ($accordionElements as $accordionElement) {
            $content = $accordionElement['content']['CONTENT'];
            if (!empty($accordionElement['content']['SWIPER_SLIDER'])) {
                $sliderHeight="100%";
                if(!empty($accordionElement['content']['SWIPER_SLIDER_HEIGHT'])) {
                    $sliderHeight = $accordionElement['content']['SWIPER_SLIDER_HEIGHT'] . "px";
                }
                $sliderBuilder = new SwiperSliderBuilder("slider-" . $accordionElement['page_id'], $accordionElement['content']['SWIPER_SLIDER'], $sliderHeight);
                $content = $sliderBuilder->processTextBlock($content);
                $sliderBuilder->echoStyles();
                ?>
                <script>
                    $( document ).ready(function() {
                        let swiper;
                        $('#collapse<?=$accordionElement['page_id']?>').on('shown.bs.collapse', function () {
                            if (swiper === undefined) {
                                swiper = new Swiper(".<?="slider-" . $accordionElement['page_id']?>", {
                                    slidesPerView: "auto",
                                    centeredSlides: true,
                                    spaceBetween: 30,
                                    pagination: {
                                        el: ".swiper-pagination",
                                        clickable: true,
                                    },
                                    navigation: {
                                        nextEl: '.swiper-button-next',
                                        prevEl: '.swiper-button-prev',
                                    },
                                    loop: true,
                                });
                            }
                        })
                    });
                </script>
                <?php
            }

            $defaultOpened = '';
            if($accordionElement['content']['OPENED_BY_DEFAULT']) {
                $defaultOpened = ' show';
            }
            $html .= '<div class="card border">';

            $html .= "<div class=\"card-header bg-light\" id=\"heading{$accordionElement['page_id']}\">
			<h2 class=\"mb-0\"><button id=\"collapseble-{$accordionElement['page_id']}\" aria-controls=\"collapse{$accordionElement['page_id']}\" aria-expanded=\"false\" class=\"btn btn-link btn-block text-left collapsed font-weight-bold\" data-target=\"#collapse{$accordionElement['page_id']}\" data-toggle=\"collapse\" type=\"button\">
			{$accordionElement['content']['TITLE']}
			</button></h2>
            </div>";

            $html .= "<div aria-labelledby=\"heading{$accordionElement['page_id']}\" class=\"collapse{$defaultOpened}\" id=\"collapse{$accordionElement['page_id']}\"{$accordionLike}>
                <div class=\"card-body\">
                    {$content}
                </div>
            </div>";

            $html .= '</div>';
        }
        $html .= '</div>';

        return $html;
    }

    public static function buildAllAccordions($html)
    {
        $pg = new Pages();

        preg_match_all("/\[ACCORDION_LIST_(\d+)\]/i",$html,$accordions);

        foreach ($accordions[1] as $accordion) {
            $accordionPage = $pg->getPageById($accordion);
            if($accordionPage['page_template']=='accordion') {
                $accordionBuilder = new self($accordion);
                $html = str_replace("[ACCORDION_LIST_{$accordion}]", $accordionBuilder->build(), $html);
            } else {
                $html = str_replace("[ACCORDION_LIST_{$accordion}]", '', $html);
            }
        }

//        if(!empty($accordions[1])) {
//            $html = self::buildAllAccordions($html);
//        }

        return $html;
    }

}