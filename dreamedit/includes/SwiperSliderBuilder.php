<?php

class SwiperSliderBuilder
{
    private $id;
    private $imgBlock;
    private $height;

    /**
     * @param $id
     * @param $imgBlock
     */
    public function __construct($id, $imgBlock, $height = '100%')
    {
        $this->id = $id;
        $this->imgBlock = $imgBlock;
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function processTextBlock($text) {
        $sliderBlock = '<div class="swiper-container '.$this->id.'">';
        $sliderBlock .= '<div class="swiper-wrapper">';
        preg_match_all('@src="([^"]+)"@',$this->imgBlock, $imgSrcs);
        foreach ($imgSrcs[1] as $imgSrc) {
            $sliderBlock .= "<div class='swiper-slide'><img src='{$imgSrc}' alt='' /></div>";
        }
        $sliderBlock .= '</div>';
        $sliderBlock .= '<div class="swiper-pagination swiper-color-clouds"></div>';
        $sliderBlock .= '<div class="swiper-button-prev swiper-color-clouds"></div>';
        $sliderBlock .= '<div class="swiper-button-next swiper-color-clouds"></div>';
        $sliderBlock .= '</div>';

        $finalText = str_replace("[SWIPER_SLIDER]",$sliderBlock, $text);

        return $finalText;
    }

    /**
     *
     */
    public function echoStyles() {
        ?>
        <style>

            .swiper {
                width: 100%;
                height: 100%;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;

                /* Center slide text vertically */
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
            }

            .swiper-slide img {
                display: block;
                width: 100%;
                height: <?=$this->height?> !important;
                object-fit: cover;
            }

            .swiper-slide {
                width: 60%;
                opacity: 50%;
                transition: opacity ease-in-out 500ms;
            }
            .swiper-slide.swiper-slide-active {
                opacity: 100%;
            }
        </style>
        <?php
    }

    /**
     *
     */
    public function echoJs() {
        ?>
        <script>
            $( document ).ready(function() {
                var swiper = new Swiper(".<?=$this->id?>", {
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
            });
        </script>
        <?php
    }

}