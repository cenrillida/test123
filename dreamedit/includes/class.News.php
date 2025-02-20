<?php

class News {

    private $ilines;

    function __construct() {
        $this->ilines = new Ilines();
    }

    /**
     * @return FirstNewsElement
     */
    function mapToFirstNewsElement($value) {
        if(isset($value["date"]))
        {
            preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $value["date"], $matches);
            $value["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
            $value["date"] = date("d.m.Y", $value["date"]);
        }
        $pg = new Magazine();
        if ($_SESSION[lang]!='/en')
            $people = $pg->getAutors($value['people']);
        else
            $people = $pg->getAutorsEn($value['people']);


        if(!empty($value[full_text]))
            $text_for_image = $value[full_text];
        else
            $text_for_image = $value[prev_text];
        preg_match_all( '@src="([^"]+)"@' , $text_for_image, $imgSrc );
        preg_match_all( '@alt="([^"]+)"@' , $text_for_image, $imgAlt );
        $imgSrc = array_pop($imgSrc);
        $imgAlt = array_pop($imgAlt);

        if($value['main_echo_all']) {
            $name = "";
            $personImage = "";
            $auth_img_str = "";

            foreach ($people as $personKey => $person) {
                if (empty($personKey))
                    break;
                if(!empty($name)) {
                    $name .= ", ";
                }
                if (is_numeric($personKey)) {
                    if (!empty($person['ran'])) {
                        $name .= $person['ran'] . " ";
                    } else {
                        if (!empty($person['grade']))
                            $name .= $person['grade'] . " ";
                    }
                    $name .= $person['name_surname'];
                    if (!empty($person['picsmall']))
                        $personImage = "/dreamedit/foto/" . $person['picsmall'];
                    else
                        $personImage = "/images/user-4.png";
                } else {
                    $name .= $personKey;
                    $personImage = "/images/user-4.png";
                }
                if (!empty($personImage)) {
                    $auth_img_str .= "<div class=\"author-img mr-2\" style=\"background-image: url('$personImage')\"></div>";
                }
            }

        } else {
            $name = "";
            $personImage = "";
            $auth_img_str = "";

            foreach ($people as $personKey => $person) {
                if (empty($personKey))
                    break;
                if (is_numeric($personKey)) {
                    if (!empty($person['ran'])) {
                        $name .= $person['ran'] . " ";
                    } else {
                        if (!empty($person['grade']))
                            $name .= $person['grade'] . " ";
                    }
                    $name .= $person['name_surname'];
                    if (!empty($person['picsmall']))
                        $personImage = "/dreamedit/foto/" . $person['picsmall'];
                    else
                        $personImage = "/images/user-4.png";
                } else {
                    $name = $personKey;
                    $personImage = "/images/user-4.png";
                }
                break;
            }
            if (!empty($personImage)) {
                $auth_img_str = "<div class=\"author-img mr-2\" style=\"background-image: url('$personImage')\"></div>";
            }
        }
        return new FirstNewsElement(
            (int)$value['id'],
            $value['title'],
            $imgSrc[0],
            $imgAlt[0],
            $auth_img_str,
            $name
        );
    }

    /**
     * @return FirstNewsElement
     */
    function getFirstNewsById($id) {
        global $DB;

        if ($_SESSION[lang]!='/en') {

            $value = $DB->selectRow("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,p.icont_text AS people,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date, pm.icont_text AS main_echo_all
                 FROM adm_ilines_element AS e
                 INNER JOIN adm_ilines_content AS a ON e.el_id=a.el_id AND a.icont_var='title'
				 INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=e.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=e.el_id AND c.icont_var='prev_text'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=e.el_id AND f.icont_var='full_text'
				 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=e.el_id AND nh.icont_var='nohome'
				 LEFT OUTER JOIN adm_ilines_content AS p ON p.el_id=e.el_id AND p.icont_var='people'
				 LEFT OUTER JOIN adm_ilines_content AS pm ON pm.el_id=e.el_id AND pm.icont_var='main_echo_all'
				 WHERE e.el_id=?d
                ",$id);
        }
        else {
            $value=$DB->selectRow("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,p.icont_text AS people,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date, pm.icont_text AS main_echo_all
				 FROM adm_ilines_element AS e
				 INNER JOIN adm_ilines_content AS a ON e.el_id=a.el_id AND a.icont_var='title_en'
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text_en'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text_en'
				 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=a.el_id AND nh.icont_var='nohome'
				 LEFT OUTER JOIN adm_ilines_content AS nhe ON nhe.el_id=a.el_id AND nhe.icont_var='nohome_en'
				 LEFT OUTER JOIN adm_ilines_content AS p ON p.el_id=a.el_id AND p.icont_var='people'
				 LEFT OUTER JOIN adm_ilines_content AS pm ON pm.el_id=a.el_id AND pm.icont_var='main_echo_all'
				 WHERE e.el_id=?d
                ",$id);
        }

        return $this->mapToFirstNewsElement($value);
    }

    /**
     * @return FirstNewsElement[]
     */
    function getFirstNews($limit = 3, $additionalSelect = "") {
        global $DB;

        if ($_SESSION[lang]!='/en') {

            $rows = $DB->select("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,p.icont_text AS people,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date, pm.icont_text AS main_echo_all
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=a.el_id AND nh.icont_var='nohome'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
				 LEFT OUTER JOIN adm_ilines_content AS p ON p.el_id=a.el_id AND p.icont_var='people'
				 LEFT OUTER JOIN adm_ilines_content AS pm ON pm.el_id=a.el_id AND pm.icont_var='main_echo_all'
				 WHERE a.icont_var='title' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>' AND (nh.icont_text IS NULL OR nh.icont_text=0) {$additionalSelect}
                 ORDER BY d.icont_text DESC LIMIT ?d
                ",$limit);
        }
        else {
            $rows=$DB->select("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,p.icont_text AS people,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date, pm.icont_text AS main_echo_all
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text_en'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text_en'
				 LEFT OUTER JOIN adm_ilines_content AS nh ON nh.el_id=a.el_id AND nh.icont_var='nohome'
				 LEFT OUTER JOIN adm_ilines_content AS nhe ON nhe.el_id=a.el_id AND nhe.icont_var='nohome_en'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
				 LEFT OUTER JOIN adm_ilines_content AS p ON p.el_id=a.el_id AND p.icont_var='people'
				 LEFT OUTER JOIN adm_ilines_content AS pm ON pm.el_id=a.el_id AND pm.icont_var='main_echo_all'
				 WHERE a.icont_var='title_en' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>' AND (nhe.icont_text IS NULL OR nhe.icont_text=0) {$additionalSelect}
                 ORDER BY d.icont_text DESC LIMIT ?d
                ",$limit);
        }

        $firstNewsArray = array();
        foreach ($rows as $key => $value) {
            $firstNewsArray[] = $this->mapToFirstNewsElement($value);
        }
        return $firstNewsArray;
    }

    function getAnnouncements() {
        $rows = $this->ilines->getLimitedElementsMultiSort("**", 15, 1,"DATE2", "DESC", "status");
        $date = new DateTime();
        $interval = new DateInterval('P1D');
        $date->add($interval);

        $result = array();
        if(!empty($rows) )
        {
            $rows = $this->ilines->appendContent($rows);

            foreach($rows as $k => $v)
            {
                if($this->ilines->getNewsOutOfMain($v[el_id]))
                    unset($rows[$k]);
            }

            $rows=array_values($rows);
            $rows = array_reverse($rows);

            foreach($rows as $k => $v)
            {
                if($v[itype_id]==1 || $v[itype_id]==4)
                {
                    if (empty($v["content"]["DATE2"])) $v["content"]["DATE2"]=$v["content"]["DATE"];

                    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);
                    $time = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                    $day = date("Y.m.d", $time);
                    $time = date("H:i:s", $time);
                    $today_flag = false;
                    if($day==date("Y.m.d")) {
                        if (!$v["content"]["TIME_IMPORTANT"]) {
                            $time = "07:00:00";
                        }
                        if (date("Y.m.d " . $time) > date("Y.m.d H:i:s")) {
                            $today_flag = true;
                        }
                    }

                    if(($v["content"]["DATE2"]> $date->format("Y.m.d")) || $today_flag)
                    {
                        if ($_SESSION[lang]=='/en')
                        {
                            $rows[$k]["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
                            $rows[$k]["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
                            if($rows[$k]["content"]["PREV_TEXT"]=="<p>&nbsp;</p>" || empty($rows[$k]["content"]["PREV_TEXT"]))
                                continue;
                        }
                        if(isset($v["content"]["DATE"]))
                        {
                            preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
                            $rows[$k]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                            $rows[$k]["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
                        }

                        $rows[$k]["content"]["DATE_WORD"] = "";
                        $rows[$k]["content"]["TIME_WORD"] = "";
                        if(isset($v["content"]["DATE2"]))
                        {
                            preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);

                            $rows[$k]["content"]["TIME_WORD"] = $matches[4].":".$matches[5];
                            if($_SESSION[lang]!="/en") {
                                switch ($matches[2]) {
                                    case "01":
                                        $m = '€нвар€';
                                        break;
                                    case "02":
                                        $m = 'феврал€';
                                        break;
                                    case "03":
                                        $m = 'марта';
                                        break;
                                    case "04":
                                        $m = 'апрел€';
                                        break;
                                    case "05":
                                        $m = 'ма€';
                                        break;
                                    case "06":
                                        $m = 'июн€';
                                        break;
                                    case "07":
                                        $m = 'июл€';
                                        break;
                                    case "08":
                                        $m = 'августа';
                                        break;
                                    case "09":
                                        $m = 'сент€бр€';
                                        break;
                                    case "10":
                                        $m = 'окт€бр€';
                                        break;
                                    case "11":
                                        $m = 'но€бр€';
                                        break;
                                    case "12":
                                        $m = 'декабр€';
                                        break;
                                }
                            }
                            else {
                                switch ($matches[2]) {
                                    case "01":
                                        $m = 'january';
                                        break;
                                    case "02":
                                        $m = 'february';
                                        break;
                                    case "03":
                                        $m = 'march';
                                        break;
                                    case "04":
                                        $m = 'april';
                                        break;
                                    case "05":
                                        $m = 'may';
                                        break;
                                    case "06":
                                        $m = 'june';
                                        break;
                                    case "07":
                                        $m = 'july';
                                        break;
                                    case "08":
                                        $m = 'august';
                                        break;
                                    case "09":
                                        $m = 'september';
                                        break;
                                    case "10":
                                        $m = 'october';
                                        break;
                                    case "11":
                                        $m = 'november';
                                        break;
                                    case "12":
                                        $m = 'december';
                                        break;
                                }
                            }

                            $rows[$k]["content"]["DATE_WORD"] = $matches[3] . " " . $m . " " . $matches[1];

                            $rows[$k]["content"]["DATE2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                            $rows[$k]["content"]["DATE_FORMAT"] = $v["content"]["DATE2"];
                            $rows[$k]["content"]["DATE2"] = date("d.m.Y г.", $v["content"]["DATE2"]);
                        }
                        $result[$k] = $rows[$k];

                    }
                }
            }

        }
        return $result;
    }

    function getAuthors() {
        global $DB;

        $authorsRows = $DB->select("SELECT DISTINCT icont_text
            FROM adm_ilines_content 
            WHERE icont_var='PEOPLE' AND icont_text<>''");

        $authorsArray = array();

        foreach ($authorsRows as $authorsRow) {
            $authors = explode("<br>",trim($authorsRow['icont_text']));
            foreach($authors as $k=>$author)
            {
                if (!empty($author))
                {
                    if (is_numeric($author))
                    {
                        if(!isset($authorsArray[$author])) {
                            $authorsArray[$author] = $author;
                        }
                    }
                }
            }
        }

        $authorsFinalRows = $DB->select("SELECT p.id AS ARRAY_KEY, p.id AS id,
			 CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),IF(p.fname<>'','.','')) AS fio,
			 autor_en AS fio_en
			 FROM persons AS p WHERE p.id IN (?a) ORDER BY p.surname", $authorsArray);

        return $authorsFinalRows;
    }
}