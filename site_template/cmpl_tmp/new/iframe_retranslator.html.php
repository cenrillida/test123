<?php

//if(strlen($_SERVER["REDIRECT_URL"])>21) {
//    $urlRedirect = "https://insserver.ru/covid".str_replace("/iframe-retranslator","",$_SERVER["REQUEST_URI"]);
//    Dreamedit::sendHeaderByCode(301);
//    Dreamedit::sendLocationHeader($urlRedirect);
//    exit;
//}

$id = (int)$_GET[id];

if(!empty($id)) {
    $manager = new CerSpecrubManager();

    $element = $manager->getElementByID($id);

    header("Content-type: text/html; charset=utf-8");
    if($_SESSION[lang]!="/en") {
        $url = $element->getIframe();
    } else {
        $url = $element->getIframeEn();
    }

    if(!empty($url)) {

        $explodedUrl = explode("?",str_replace("https://","",$url));
        $explodedUrl = explode("/",str_replace("https://","",$explodedUrl[0]));

        $html = file_get_contents($url);

        preg_match_all("/href=\"(((?!(http:\/\/|https:\/\/))[^#])+?)\"/", $html, $links);

        foreach ($links[1] as $k => $v) {
            if($v[0]=="/") {
                $final = "href=\"https://" . $explodedUrl[0] . $v . "\"";
            } else {
                if($url[strlen($url)-1]=="/") {
                    $final = "href=\"" . $url . $v . "\"";
                } else {
                    $final = "href=\"" . $url . "/" . $v . "\"";
                }
            }
            if($v=="font-awesome-5.3.1/css/all.min.css") {
                $final = "href=\"https://use.fontawesome.com/releases/v5.8.1/css/all.css\" integrity=\"sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf\" crossorigin=\"anonymous\"";
            }
            $html = str_replace($links[0][$k], $final, $html);
        }

        preg_match_all("/src=\"(((?!(http:\/\/|https:\/\/))[^#])+?)\"/", $html, $links);

        foreach ($links[1] as $k => $v) {
            if($v[0]=="/") {
                $final = "src=\"https://" . $explodedUrl[0] . $v . "\"";
            } else {
                if($url[strlen($url)-1]=="/") {
                    $final = "src=\"" . $url . $v . "\"";
                } else {
                    $final = "src=\"" . $url . "/" . $v . "\"";
                }
            }
            if($v=="__assets__/shiny-server-client.min.js") {
                $final = "src=\"/newsite/cer/shiny-server-client.min.js\"";
            }
            $html = str_replace($links[0][$k], $final, $html);
        }

        $html = str_replace("</body>","<link href=\"/newsite/cer/iframe-helper.css\" rel=\"stylesheet\"></body>",$html);

        echo $html;
    }
}