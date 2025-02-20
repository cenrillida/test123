<?php

ini_set('memory_limit', '2048M');
include_once dirname(__FILE__)."/_include.php";

$articles = $DB->select("SELECT * FROM adm_article WHERE page_template='jarticle' AND contents<>'' AND contents<>'<p>&nbsp;</p>'");

//$articles = $DB->select("
//SELECT citations.cv_text AS contents FROM afjourn.adm_pages AS ap
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
        $article['contents'] = str_replace('<p>&nbsp;</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p><em>&nbsp;</em></p>', '', $article['contents']);
        $article['contents'] = str_replace('<div>&nbsp;</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p style="text-align: center;">REFERENCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<div style="text-align: center;">REFERENCES</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p>REFERENCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<div>REFERENCES</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p style="text-align: center;">&nbsp;REFERENCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">&nbsp;REFERENCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">&nbsp;REFERENCES<em> </em></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES<em> </em></p>', '', $article['contents']);
        $article['contents'] = str_replace('<div align="center">REFERENCES</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES<i></i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES&nbsp;</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES &nbsp;</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES<i> </i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES <i> </i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES <i> </i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center"><i>REFERENCES</i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">REFERENCES <i>&nbsp;</i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p style="text-align: center;">SOURCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<div style="text-align: center;">SOURCES</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p>SOURCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<div>SOURCES</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p style="text-align: center;">&nbsp;SOURCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">&nbsp;SOURCES</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">&nbsp;SOURCES<em> </em></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES<em> </em></p>', '', $article['contents']);
        $article['contents'] = str_replace('<div align="center">SOURCES</div>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES<i></i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES&nbsp;</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES &nbsp;</p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES<i> </i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES <i> </i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES <i> </i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center"><i>SOURCES</i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES <i>&nbsp;</i></p>', '', $article['contents']);
        $article['contents'] = str_replace('<p align="center">SOURCES&nbsp;&nbsp;</p>', '', $article['contents']);
        $article['contents'] = str_replace('<ol>', '', $article['contents']);
        $article['contents'] = str_replace('</ol>', '', $article['contents']);
        $article['contents'] = str_replace("\r\n\r\n", "\r\n", $article['contents']);

        $sources = "";
        if (strpos($article['contents'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »<i> </i></p>') !== false) {
            $sources = substr($article['contents'], strpos($article['contents'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »<i> </i></p>'));
        }
        if (strpos($article['contents'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »</p>') !== false) {
            $sources = substr($article['contents'], strpos($article['contents'], '<p align="center">ƒ–”√»≈ »—“Œ◊Õ» »</p>'));
        }

        $articleExploded = explode("\n", $article['contents']);
//        $article['contents'] = str_replace("\r\n", '', $article['contents']);
//        $article['contents'] = str_replace("\n", '', $article['contents']);
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
                <?=$article['contents']?>
            </td>
            <td><?=$sources?></td>
        </tr>
    <?php endforeach;?>
</table>
</body>
</html>
