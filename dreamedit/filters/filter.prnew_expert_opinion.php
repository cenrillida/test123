<?

global $DB,$_CONFIG;
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
				 WHERE a.icont_var='title' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>' AND (nh.icont_text IS NULL OR nh.icont_text=0)
                 ORDER BY d.icont_text DESC LIMIT 1
                ");
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
				 WHERE a.icont_var='title_en' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>' AND (nhe.icont_text IS NULL OR nhe.icont_text=0)
                 ORDER BY d.icont_text DESC LIMIT 1
                ");
}
    if(!empty($rows)) {
        echo '<div class="col-12 text-center">';
    }
    foreach ($rows as $key => $value) {
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
                    $name = $personKey;
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
        ?>
        <div class="my-3 card">
            <div class="position-relative<?php if(empty($imgSrc[0])) echo " my-auto";?>">
                <?php if(!empty($imgSrc[0])):?>
                <img class="card-img" src="<?=$imgSrc[0]?>" alt="<?=$imgAlt[0]?>">
                <div class="position-absolute img-ton">
                    <div class="card-body text-white absolute-bottom w-100">
                        <a target="_blank" class="text-white" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$value[id]?>"><h5 class="card-title card-comments-title"><?=$value['title']?></h5></a>
                        <div class="mb-3 d-none d-md-block">
                            <div class="text-center">
                                <?=$auth_img_str?>
                            </div>
                            <b class="font-italic"><?=$name?></b>
                        </div>
                    </div>
                </div>
                <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$value[id]?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight hover-highlight-center-dark" draggable="true"></a>
                <?php else:?>
                <div>
                    <div class="card-body w-100">
                        <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$value[id]?>"><h5 class="card-title card-comments-title"><?=$value['title']?></h5></a>
                            <div class="mb-3 d-none d-md-block">
                                <div class="text-center">
                                    <?=$auth_img_str?>
                                </div>
                                <b class="font-italic"><?=$name?></b>
                            </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <?php
    }
    if(!empty($rows)) {
        echo '</div>';
    }
?>