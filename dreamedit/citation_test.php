<?php

ini_set('memory_limit', '2048M');
include_once dirname(__FILE__)."/_include.php";

$articles = $DB->select("SELECT * FROM adm_article WHERE page_template='jarticle' AND `references_en`<>'' AND `references_en`<>'<p>&nbsp;</p>'");


function getSources($references, $text, $source) {
    $result = array();
    $result['sources'] = $source;
    $result['references_en'] = $references;
    if (strpos($result['references_en'], $text) !== false) {
        $result['sources'] = substr($result['references_en'], strpos($result['references_en'], $text));
        $result['sources'] = str_replace($text, '', $result['sources']);
        $result['references_en'] = substr($result['references_en'], 0, strpos($result['references_en'], $text));
    }
    return $result;
}

//$articles = $DB->select("
//SELECT citations.cv_text AS references_en FROM afjourn.adm_pages AS ap
//INNER JOIN afjourn.adm_pages_content AS citations ON citations.page_id=ap.page_id AND citations.cv_name='REFERENCES'
//WHERE ap.page_template='article'
//");

?>

<html lang="ru" >
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<?php
var_dump(count($articles));
?>
<table>
    <?php foreach ($articles as $article):

//        $sources = "";
//        if (strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »<i> </i></p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »<i> </i></p>'));
//            $sources = str_replace('<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »<i> </i></p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »<i> </i></p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »</p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »</p>'));
//            $sources = str_replace('<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »</p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »</p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » <i>&nbsp;</i></p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » <i>&nbsp;</i></p>'));
//            $sources = str_replace('<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » <i>&nbsp;</i></p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » <i>&nbsp;</i></p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » &nbsp;</p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » &nbsp;</p>'));
//            $sources = str_replace('<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » &nbsp;</p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» » &nbsp;</p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »&nbsp;</p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »&nbsp;</p>'));
//            $sources = str_replace('<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »&nbsp;</p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »&nbsp;</p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »<i> </i></p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »<i> </i></p>'));
//            $sources = str_replace('<p align="center">»—“Œ◊Õ» »<i> </i></p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »<i> </i></p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »</p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »</p>'));
//            $sources = str_replace('<p align="center">»—“Œ◊Õ» »</p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »</p>'));
//        }
//        if (strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »&nbsp;</p>') !== false) {
//            $sources = substr($article['references_en'], strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »&nbsp;</p>'));
//            $sources = str_replace('<p align="center">»—“Œ◊Õ» »&nbsp;</p>', '', $sources);
//            $article['references_en'] = substr($article['references_en'], 0, strpos($article['references_en'], '<p align="center">»—“Œ◊Õ» »&nbsp;</p>'));
//        }
//        $article['references_en'] = str_replace('<p>&nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p><em>&nbsp;</em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div>&nbsp;</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p style="text-align: center;">—œ»—Œ  À»“≈–¿“”–€</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div style="text-align: center;">—œ»—Œ  À»“≈–¿“”–€</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p>—œ»—Œ  À»“≈–¿“”–€</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div>—œ»—Œ  À»“≈–¿“”–€</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p style="text-align: center;">&nbsp;—œ»—Œ  À»“≈–¿“”–€</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">&nbsp;—œ»—Œ  À»“≈–¿“”–€</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">&nbsp;—œ»—Œ  À»“≈–¿“”–€<em> </em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€<em> </em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div align="center">—œ»—Œ  À»“≈–¿“”–€</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€<i></i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€&nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€ &nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€<i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€ <i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€ <i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center"><i>—œ»—Œ  À»“≈–¿“”–€</i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">—œ»—Œ  À»“≈–¿“”–€ <i>&nbsp;</i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace("\r\n\r\n", "\r\n", $article['references_en']);

        //$DB->query("UPDATE adm_article SET `references_en`=?,`sources`=? WHERE page_id=?d",$article['references_en'], $sources, $article['page_id']);

        $sources = "";
        $sourcesArr = getSources($article['references_en'], '<p style="text-align: center;">SOURCES</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<div style="text-align: center;">SOURCES</div>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p>SOURCES</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<div>SOURCES</div>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p style="text-align: center;">&nbsp;SOURCES</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">&nbsp;SOURCES</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">&nbsp;SOURCES<em> </em></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES<em> </em></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<div align="center">SOURCES</div>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES<i></i></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES&nbsp;</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES &nbsp;</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES<i> </i></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES <i> </i></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES <i> </i></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center"><i>SOURCES</i></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES <i>&nbsp;</i></p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];
        $sourcesArr = getSources($article['references_en'], '<p align="center">SOURCES&nbsp;&nbsp;</p>', $sources);
        $article['references_en'] = $sourcesArr['references_en'];
        $sources = $sourcesArr['sources'];

        $article['references_en'] = str_replace('<p>&nbsp;</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p><em>&nbsp;</em></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<div>&nbsp;</div>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p style="text-align: center;">REFERENCES</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<div style="text-align: center;">REFERENCES</div>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p>REFERENCES</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<div>REFERENCES</div>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p style="text-align: center;">&nbsp;REFERENCES</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">&nbsp;REFERENCES</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">&nbsp;REFERENCES<em> </em></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES<em> </em></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<div align="center">REFERENCES</div>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES<i></i></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES&nbsp;</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES &nbsp;</p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES<i> </i></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES <i> </i></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES <i> </i></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center"><i>REFERENCES</i></p>', '', $article['references_en']);
        $article['references_en'] = str_replace('<p align="center">REFERENCES <i>&nbsp;</i></p>', '', $article['references_en']);
        $article['references_en'] = str_replace("\r\n\r\n", "\r\n", $article['references_en']);

        //$DB->query("UPDATE adm_article SET `references_en`=?,`sources_en`=? WHERE page_id=?d",$article['references_en'], $sources, $article['page_id']);

//
//        $article['references_en'] = str_replace('<p>&nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p><em>&nbsp;</em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div>&nbsp;</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p style="text-align: center;">REFERENCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div style="text-align: center;">REFERENCES</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p>REFERENCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div>REFERENCES</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p style="text-align: center;">&nbsp;REFERENCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">&nbsp;REFERENCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">&nbsp;REFERENCES<em> </em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES<em> </em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div align="center">REFERENCES</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES<i></i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES&nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES &nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES<i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES <i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES <i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center"><i>REFERENCES</i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">REFERENCES <i>&nbsp;</i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p style="text-align: center;">SOURCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div style="text-align: center;">SOURCES</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p>SOURCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div>SOURCES</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p style="text-align: center;">&nbsp;SOURCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">&nbsp;SOURCES</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">&nbsp;SOURCES<em> </em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES<em> </em></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<div align="center">SOURCES</div>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES<i></i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES&nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES &nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES<i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES <i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES <i> </i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center"><i>SOURCES</i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES <i>&nbsp;</i></p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<p align="center">SOURCES&nbsp;&nbsp;</p>', '', $article['references_en']);
//        $article['references_en'] = str_replace('<ol>', '', $article['references_en']);
//        $article['references_en'] = str_replace('</ol>', '', $article['references_en']);
//        $article['references_en'] = str_replace("\r\n\r\n", "\r\n", $article['references_en']);
//
//
//        $articleExploded = explode("\n", $article['references_en']);
//        $article['references_en'] = str_replace("\r\n", '', $article['references_en']);
//        $article['references_en'] = str_replace("\n", '', $article['references_en']);
        ?>
        <tr>
            <td><a href="https://www.imemo.ru/dreamedit/index.php?mod=articls&action=edit&id=<?=$article['page_id']?>" target="_blank">¿‰ÏËÌÍ‡</a></td>
            <td>
                <table>
                    <?php
//                        foreach ($articleExploded as $value) {
//                            $value = str_replace("\r", '', $value);
/*                            $value = preg_replace("(<.+?>)","",$value);*/
//                            $value = preg_replace("/^\s?\d+\.\s?/i","",$value);
//                            if(!empty($value)) {
//                                echo '<tr><td>' . htmlentities($value) . '</td></tr>';
//                            }
//                        }
                    ?>
                </table>
                <?=$article['references_en']?>
            </td>
            <td><?=$sources?></td>
        </tr>
    <?php endforeach;?>
</table>
</body>
</html>
