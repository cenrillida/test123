<?
global $DB, $_CONFIG, $site_templater;

/*if($_GET['update']==1) {
    preg_match_all('~<a.*?href=["\']+(.*?)["\'].*?<img.*?src=["\']+(.*?)["\']+~', '<div class="single singleFull">
			<p valign="top"><br>
<a target="_blank" href="http://identityworld.ru/"><img alt="Экспертная сеть по исследованию идентичности" title="Экспертная сеть по исследованию идентичности" src="/files/Image/parthners/banners/ex_set88x31.gif" width="88" hspace="3" height="31" border="0" align="left"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.mgimo.ru"><img alt="МГИМО-Университет МИД России" src="/files/Image/parthners/banners/88x31.gif" width="88" height="31" border="0" align="top"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://intertrends.ru/"><img alt="Журнал " международные="" src="/files/Image/parthners/banners/ban1.gif" width="88" height="31" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.politstudies.ru/"><img alt="Научный и культурно-просветительский журнал Полис" src="/files/Image/parthners/banners/polis_banner.gif" width="88" height="31" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p align="justify"><a target="_blank" href="http://www.shlangenbadskie-besedy.org/"><img alt="Шлангенбадские беседы" src="/files/Image/parthners/banners-2/SHLANGEN.jpg" width="47" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a href="http://europa.eu/espas/" target="_blank"><img src="/files/Image/parthners/banners-2/ESPAS.jpg" alt="European Strategy and Policy Analysis System (ESPAS)" width="72" height="47" border="0" align="top"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://obraforum.ru/"><img alt="Научно-образовательный форум по международным отношениям" src="/files/Image/parthners/banners-2/OBRAFORUM.jpg" width="57" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.gubkin.ru/faculty/meb/chairs_and_departments/meep/" target="_blank"><img src="/files/Image/parthners/banners-2/RGUNIGUB.jpg" alt="Российский государственный университет нефти и газа им. И.М. Губкина" width="46" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://risa.ru/ru/"><img alt="РАМИ - VII Конвент" src="/files/Image/parthners/banners-2/RAMI.jpg" width="70" height="47" border="0" align="top"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.fesmos.ru/"><img alt="Фонд имени Фридриха Эберта" src="/files/Image/parthners/banners-2/FEBERT.jpg" width="80" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://rapn.ru/"><img alt="Российская Ассоциация Политической науки" title="Российская Ассоциация Политической науки" src="/files/Image/parthners/banners-2/RAPN.jpg" width="90" hspace="3" height="47" border="0" align="left"></a>&nbsp;&nbsp;&nbsp;</p>
<p align="justify"><a target="_blank" href="http://kisi.kz/"><img alt="Казахстанский институт  стратегических исследований при Президенте Республики Казахстан (КАЗИСС)" title="Казахстанский институт  стратегических исследований при Президенте Республики Казахстан (КАЗИСС)" src="/files/Image/parthners/banners-2/KAZISS.jpg" width="47" hspace="3" height="47" border="0" align="left"></a>&nbsp;&nbsp;&nbsp;<a href="https://www.bp.com/" target="_blank"><img src="/files/Image/parthners/banners-2/BP.jpg" title="BP Global" alt="BP Global" width="47" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="https://www.iiss.org/" target="_blank"><img src="/files/Image/parthners/banners-2/IISS.jpg" title="International Institute for Strategic Studies | IISS" alt="International Institute for Strategic Studies | IISS" width="75" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://carnegieendowment.org/"><img alt="Carnegie Endowment for International Peace" title="Carnegie Endowment for International Peace" src="/files/Image/parthners/banners-2/CARNEGIE.jpg" width="238" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.columbia.edu/"><img alt="Columbia University in the City of New York" title="Columbia University in the City of New York" src="/files/Image/parthners/banners-2/COLUNI.jpg" width="46" hspace="3" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;</p>
<p align="justify"><a target="_blank" href="http://www.upenn.edu/"><img alt="University of Pennsylvania" title="University of Pennsylvania" src="/files/Image/parthners/banners-2/PENN.jpg" width="144" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.atlanticcouncil.org/"><img alt="Atlantic Council" title="Atlantic Council" src="/files/Image/parthners/banners-2/ATLANTICC.jpg" width="226" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.nti.org/about/projects/euro-atlantic-security-initiative-easi/" target="_blank"><img src="/files/Image/parthners/banners-2/NTI.jpg" title="Euro-Atlantic Security Initiative (EASI)" alt="Euro-Atlantic Security Initiative (EASI)" width="98" hspace="3" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;</p>
<p><a target="_blank" href="https://csis.org/"><img alt="Center for Strategic and International Studies" title="Center for Strategic and International Studies" src="/files/Image/parthners/banners-2/CSIS.jpg" width="97" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.kiep.go.kr/eng/"><img alt="Korea Institute International Economic Policy" title="Korea Institute International Economic Policy" src="/files/Image/parthners/banners-2/KIEP.jpg" width="118" hspace="3" height="47" border="0"></a><a href="http://en.wikipedia.org/wiki/China_Institutes_of_Contemporary_International_Relations" target="_blank"><img src="/files/Image/parthners/banners-2/CICIR.jpg" title="China Institutes Of Contemporary International Relations" alt="China Institutes Of Contemporary International Relations" width="114" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.eabr.org/"><img alt="Евразийский Банк Развития" title="Евразийский Банк Развития" src="/files/Image/parthners/banners-2/EBR.jpg" width="80" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.pism.pl/en" target="_blank"><img src="/files/Image/parthners/banners-2/PISM.jpg" title="PISM" alt="PISM" width="89" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p><a href="http://www.brookings.edu/" target="_blank"><img src="/files/Image/parthners/banners-2/BROOKINGS.jpg" title="Brookings - Quality. Independence. Impact." alt="Brookings - Quality. Independence. Impact." width="294" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.novatek.ru/" target="_blank"><img src="/files/Image/parthners/banners-2/NOVATEK.jpg" title="ОАО «НОВАТЭК»" alt="ОАО «НОВАТЭК»" width="245" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p><a target="_blank" href="https://www2.jiia.or.jp/en/"><img alt="The Japan Institute of International Affairs" title="The Japan Institute of International Affairs" src="/files/Image/parthners/banners-2/JIIA.jpg" width="52" hspace="3" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a target="_blank" href="http://urfu.ru/"><img alt="Уральский федеральный университет" title="Уральский федеральный университет" src="/files/Image/parthners/banners-2/UFUNI.jpg" width="108" height="47" border="0"></a>&nbsp;&nbsp;&nbsp; <a href="http://www.ifri.org/" target="_blank"><img src="/files/Image/parthners/banners-2/IFRI.jpg" title="Institut fran?ais des relations internationales" alt="Institut fran?ais des relations internationales" width="48" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.sipri.org/" target="_blank"><img src="/files/Image/parthners/banners-2/SIPRI.jpg" title="Stockholm International Peace Research Institute" alt="Stockholm International Peace Research Institute" width="54" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a href="http://www.swp-berlin.org/" target="_blank"><img src="/files/Image/parthners/banners-2/SWP.jpg" title="Stiftung Wissenschaft und Politik (SWP)" alt="Stiftung Wissenschaft und Politik (SWP)" width="130" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p><a href="http://www.ieras.ru/" target="_blank"><img src="/files/Image/parthners/banners-2/IERAN.jpg" title="Институт Европы РАН" alt="Институт Европы РАН" width="245" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;  <a href="http://gotothinktank.com/" target="_blank"><img src="/files/Image/parthners/banners/TTCSP.jpg" title="Think Tanks and Civil Societies Program - Univercity of Pennsylvania" alt="Think Tanks and Civil Societies Program - Univercity of Pennsylvania" width="" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>



				</div>', $result);
    preg_match_all('~<img.*?alt=["\']+(.*?)["\']+~', '<div class="single singleFull">
			<p valign="top"><br>
<a target="_blank" href="http://identityworld.ru/"><img alt="Экспертная сеть по исследованию идентичности" title="Экспертная сеть по исследованию идентичности" src="/files/Image/parthners/banners/ex_set88x31.gif" width="88" hspace="3" height="31" border="0" align="left"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.mgimo.ru"><img alt="МГИМО-Университет МИД России" src="/files/Image/parthners/banners/88x31.gif" width="88" height="31" border="0" align="top"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://intertrends.ru/"><img alt="Журнал " международные="" src="/files/Image/parthners/banners/ban1.gif" width="88" height="31" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.politstudies.ru/"><img alt="Научный и культурно-просветительский журнал Полис" src="/files/Image/parthners/banners/polis_banner.gif" width="88" height="31" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p align="justify"><a target="_blank" href="http://www.shlangenbadskie-besedy.org/"><img alt="Шлангенбадские беседы" src="/files/Image/parthners/banners-2/SHLANGEN.jpg" width="47" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a href="http://europa.eu/espas/" target="_blank"><img src="/files/Image/parthners/banners-2/ESPAS.jpg" alt="European Strategy and Policy Analysis System (ESPAS)" width="72" height="47" border="0" align="top"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://obraforum.ru/"><img alt="Научно-образовательный форум по международным отношениям" src="/files/Image/parthners/banners-2/OBRAFORUM.jpg" width="57" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.gubkin.ru/faculty/meb/chairs_and_departments/meep/" target="_blank"><img src="/files/Image/parthners/banners-2/RGUNIGUB.jpg" alt="Российский государственный университет нефти и газа им. И.М. Губкина" width="46" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://risa.ru/ru/"><img alt="РАМИ - VII Конвент" src="/files/Image/parthners/banners-2/RAMI.jpg" width="70" height="47" border="0" align="top"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.fesmos.ru/"><img alt="Фонд имени Фридриха Эберта" src="/files/Image/parthners/banners-2/FEBERT.jpg" width="80" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://rapn.ru/"><img alt="Российская Ассоциация Политической науки" title="Российская Ассоциация Политической науки" src="/files/Image/parthners/banners-2/RAPN.jpg" width="90" hspace="3" height="47" border="0" align="left"></a>&nbsp;&nbsp;&nbsp;</p>
<p align="justify"><a target="_blank" href="http://kisi.kz/"><img alt="Казахстанский институт  стратегических исследований при Президенте Республики Казахстан (КАЗИСС)" title="Казахстанский институт  стратегических исследований при Президенте Республики Казахстан (КАЗИСС)" src="/files/Image/parthners/banners-2/KAZISS.jpg" width="47" hspace="3" height="47" border="0" align="left"></a>&nbsp;&nbsp;&nbsp;<a href="https://www.bp.com/" target="_blank"><img src="/files/Image/parthners/banners-2/BP.jpg" title="BP Global" alt="BP Global" width="47" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="https://www.iiss.org/" target="_blank"><img src="/files/Image/parthners/banners-2/IISS.jpg" title="International Institute for Strategic Studies | IISS" alt="International Institute for Strategic Studies | IISS" width="75" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://carnegieendowment.org/"><img alt="Carnegie Endowment for International Peace" title="Carnegie Endowment for International Peace" src="/files/Image/parthners/banners-2/CARNEGIE.jpg" width="238" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.columbia.edu/"><img alt="Columbia University in the City of New York" title="Columbia University in the City of New York" src="/files/Image/parthners/banners-2/COLUNI.jpg" width="46" hspace="3" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;</p>
<p align="justify"><a target="_blank" href="http://www.upenn.edu/"><img alt="University of Pennsylvania" title="University of Pennsylvania" src="/files/Image/parthners/banners-2/PENN.jpg" width="144" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.atlanticcouncil.org/"><img alt="Atlantic Council" title="Atlantic Council" src="/files/Image/parthners/banners-2/ATLANTICC.jpg" width="226" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.nti.org/about/projects/euro-atlantic-security-initiative-easi/" target="_blank"><img src="/files/Image/parthners/banners-2/NTI.jpg" title="Euro-Atlantic Security Initiative (EASI)" alt="Euro-Atlantic Security Initiative (EASI)" width="98" hspace="3" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;</p>
<p><a target="_blank" href="https://csis.org/"><img alt="Center for Strategic and International Studies" title="Center for Strategic and International Studies" src="/files/Image/parthners/banners-2/CSIS.jpg" width="97" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.kiep.go.kr/eng/"><img alt="Korea Institute International Economic Policy" title="Korea Institute International Economic Policy" src="/files/Image/parthners/banners-2/KIEP.jpg" width="118" hspace="3" height="47" border="0"></a><a href="http://en.wikipedia.org/wiki/China_Institutes_of_Contemporary_International_Relations" target="_blank"><img src="/files/Image/parthners/banners-2/CICIR.jpg" title="China Institutes Of Contemporary International Relations" alt="China Institutes Of Contemporary International Relations" width="114" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a target="_blank" href="http://www.eabr.org/"><img alt="Евразийский Банк Развития" title="Евразийский Банк Развития" src="/files/Image/parthners/banners-2/EBR.jpg" width="80" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.pism.pl/en" target="_blank"><img src="/files/Image/parthners/banners-2/PISM.jpg" title="PISM" alt="PISM" width="89" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p><a href="http://www.brookings.edu/" target="_blank"><img src="/files/Image/parthners/banners-2/BROOKINGS.jpg" title="Brookings - Quality. Independence. Impact." alt="Brookings - Quality. Independence. Impact." width="294" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.novatek.ru/" target="_blank"><img src="/files/Image/parthners/banners-2/NOVATEK.jpg" title="ОАО «НОВАТЭК»" alt="ОАО «НОВАТЭК»" width="245" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p><a target="_blank" href="https://www2.jiia.or.jp/en/"><img alt="The Japan Institute of International Affairs" title="The Japan Institute of International Affairs" src="/files/Image/parthners/banners-2/JIIA.jpg" width="52" hspace="3" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a target="_blank" href="http://urfu.ru/"><img alt="Уральский федеральный университет" title="Уральский федеральный университет" src="/files/Image/parthners/banners-2/UFUNI.jpg" width="108" height="47" border="0"></a>&nbsp;&nbsp;&nbsp; <a href="http://www.ifri.org/" target="_blank"><img src="/files/Image/parthners/banners-2/IFRI.jpg" title="Institut fran?ais des relations internationales" alt="Institut fran?ais des relations internationales" width="48" hspace="3" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="http://www.sipri.org/" target="_blank"><img src="/files/Image/parthners/banners-2/SIPRI.jpg" title="Stockholm International Peace Research Institute" alt="Stockholm International Peace Research Institute" width="54" height="47" border="0"></a> &nbsp;&nbsp;&nbsp;<a href="http://www.swp-berlin.org/" target="_blank"><img src="/files/Image/parthners/banners-2/SWP.jpg" title="Stiftung Wissenschaft und Politik (SWP)" alt="Stiftung Wissenschaft und Politik (SWP)" width="130" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>
<p><a href="http://www.ieras.ru/" target="_blank"><img src="/files/Image/parthners/banners-2/IERAN.jpg" title="Институт Европы РАН" alt="Институт Европы РАН" width="245" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;  <a href="http://gotothinktank.com/" target="_blank"><img src="/files/Image/parthners/banners/TTCSP.jpg" title="Think Tanks and Civil Societies Program - Univercity of Pennsylvania" alt="Think Tanks and Civil Societies Program - Univercity of Pennsylvania" width="" hspace="8" height="47" border="0"></a>&nbsp;&nbsp;&nbsp;</p>



				</div>', $result2);
    $count=0;
    foreach ($result[1] AS $key => $value) {
        //var_dump($value,$result[2][$key],$result2[1][$key]);
        $lid = $DB->query("INSERT INTO adm_directories_element SET itype_id = 25, el_date = UNIX_TIMESTAMP()");
        $count_string = $count;
        if(strlen($count)==1) {
            $count_string = "00".$count;
        }
        if(strlen($count)==2) {
            $count_string = "0".$count;
        }
        $DB->query("INSERT INTO adm_directories_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, 'sort', $count_string);
        $DB->query("INSERT INTO adm_directories_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, 'text', $result2[1][$key]);
        $DB->query("INSERT INTO adm_directories_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, 'link', $value);
        $DB->query("INSERT INTO adm_directories_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, 'logo', '<p><img src="'.$result[2][$key].'"/></p>');
        $count++;
    }
    exit;
}*/
/*if($_GET['delete']) {
    $delete_ids= $DB->select("SELECT ac.el_id FROM `adm_directories_content` AS ac
INNER JOIN adm_directories_element AS ae ON ac.el_id=ae.el_id
WHERE ae.itype_id=25 GROUP BY ac.el_id");

    foreach ($delete_ids as $k => $v) {
        $DB->query("DELETE FROM adm_directories_content WHERE el_id=".$v['el_id']);
        $DB->query("DELETE FROM adm_directories_element WHERE el_id=".$v['el_id']);
    }
}*/



$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if ($_SESSION[lang]!='/en')
{
    //preg_match('~<img.*?src=["\']+(.*?)["\']+~', $body, $result);
    $partners = $DB->select("SELECT logo.icont_text AS logo, text.icont_text AS text, link.icont_text AS link FROM adm_directories_content AS ac INNER JOIN adm_directories_element AS ae ON ac.el_id=ae.el_id 
                              INNER JOIN adm_directories_content AS logo ON logo.el_id=ac.el_id AND logo.icont_var='logo' 
                              INNER JOIN adm_directories_content AS text ON text.el_id=ac.el_id AND text.icont_var='text' 
                              INNER JOIN adm_directories_content AS sort ON sort.el_id=ac.el_id AND sort.icont_var='sort' 
                              INNER JOIN adm_directories_content AS link ON link.el_id=ac.el_id AND link.icont_var='link' 
                              WHERE ae.itype_id=25 GROUP BY ac.el_id ORDER BY sort.icont_text");
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <style>
        .slick-slide {
            margin: 0px 20px;
        }

        .slick-slide img {
            max-width: 100%;
            margin: auto;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .slick-slider
        {
            position: relative;
            display: block;
            box-sizing: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -khtml-user-select: none;
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            -webkit-tap-highlight-color: transparent;
        }

        .slick-list
        {
            position: relative;
            display: block;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        .slick-list:focus
        {
            outline: none;
        }
        .slick-list.dragging
        {
            cursor: pointer;
            cursor: hand;
        }

        .slick-slider .slick-track,
        .slick-slider .slick-list
        {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        .slick-track
        {
            position: relative;
            top: 0;
            left: 0;
            display: block;
        }
        .slick-track:before,
        .slick-track:after
        {
            display: table;
            content: '';
        }
        .slick-track:after
        {
            clear: both;
        }
        .slick-loading .slick-track
        {
            visibility: hidden;
        }

        .slick-slide
        {
            display: none;
            float: left;
            height: 55px;
            position: relative;

        }
        [dir='rtl'] .slick-slide
        {
            float: right;
        }
        .slick-slide img
        {
            display: block;
        }
        .slick-slide.slick-loading img
        {
            display: none;
        }
        .slick-slide.dragging img
        {
            pointer-events: none;
        }
        .slick-initialized .slick-slide
        {
            display: block;
        }
        .slick-loading .slick-slide
        {
            visibility: hidden;
        }
        .slick-vertical .slick-slide
        {
            display: block;
            height: auto;
            border: 1px solid transparent;
        }
        .slick-arrow.slick-hidden {
            display: none;
        }
    </style>
    <script>
        jQuery(document).ready(function(){
            jQuery('.customer-logos').slick({
                slidesToShow: 3,
                slidesToScroll: 2,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
    </script>
    <?php
    echo '<section class="customer-logos slider">';
    foreach ($partners AS $partner) {
        preg_match('~<img.*?src=["\']+(.*?)["\']+~', $partner['logo'], $result);
         echo '<div class="slide"><img alt="'.$partner['text'].'" src="'.$result[1].'"></div>';
    }
    echo '</section>';
    if (!empty($_TPL_REPLACMENT["CONTENT"]) && $_TPL_REPLACMENT["CONTENT"]!='<p>&nbsp;</p>')
    {
        echo @$_TPL_REPLACMENT["CONTENT"];
    }
}
else
{
    if (!empty($_TPL_REPLACMENT["CONTENT_EN"]) && $_TPL_REPLACMENT["CONTENT_EN"]!='<p>&nbsp;</p>')
    {
        echo @$_TPL_REPLACMENT["CONTENT_EN"];
    }
}
if (!isset($_REQUEST[printmode]))
{
    ?>
    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
    <script src="https://yastatic.net/share2/share.js"></script>
    <div class="ya-share2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
    <?
}


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
