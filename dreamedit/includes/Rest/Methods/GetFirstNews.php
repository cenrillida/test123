<?php

namespace Rest\Methods;

use Rest\Models\FirstNewsElement;

class GetFirstNews implements \RestMethod {

    private $firstNewsElements;

    function __construct() {
        $this->firstNewsElements = array();
    }

    function execute($params) {
        $news = new \News();
        $firstNews = $news->getFirstNews();

        foreach ($firstNews as $k=>$element) {
            $image = $element->getImageUrl();
            if(substr($image,0,1) == "/") {
                $image = "https://".$_SERVER["HTTP_HOST"].$image;
            }
            $this->firstNewsElements[] = new FirstNewsElement(
                $element->getId(),
                iconv("cp1251","UTF-8", $element->getTitle()),
                iconv("cp1251","UTF-8", $image),
                iconv("cp1251","UTF-8", $element->getImageAlt())
            );
        }
        return $this->firstNewsElements;
    }

}