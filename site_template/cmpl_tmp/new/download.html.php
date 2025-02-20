<?php
// Выдача файла авторизованным пользователям или выдача общедоступного файла
function file_download($file, $open=0) {
    global $DB;
    $pos = strpos($file, "/files/File/magazines/meimo/");
    $mz = new MagazineNew();

    if ($pos === false) {
        echo "Некорректная ссылка";
    } else {
        $file = substr($file, $pos);
        $rows = $DB->select("SELECT open.cv_text AS open FROM adm_article_content AS link INNER JOIN adm_article_content AS open ON link.page_id=open.page_id WHERE link.cv_text LIKE '%".$file."%' AND open.cv_name='full_text_open'");
        foreach ($rows as $row) {
            if((int)$row['open']==1)
                $open=1;
        }
        $rows = $DB->select("SELECT page_id,fulltext_open AS open,author_open_text FROM `adm_article` WHERE link LIKE '%".$file."%' OR link_en LIKE '%".$file."%'");
        foreach ($rows as $row) {
            if((int)$row['open']==1)
                $open=1;
            if((int)$row['author_open_text']==1) {
                $open = 1;
            }

            $numberId = $mz->getNumberIdByArticleId($row['page_id']);
            $numberContent = $mz->getArticleContentByPageId($numberId);
            if($numberContent['FULL_TEXT_OPEN']==1) {
                $open = 1;
            }
        }
        $file = "/home/imemon/html".$file;
        if (file_exists($file)) {
            if(($_SESSION['meimo_authorization']==1) || $open==1) {
                if (ob_get_level()) {
                    ob_end_clean();
                }
                header('Content-Description: File Transfer');
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            }
            else
                echo "У вас нет доступа к этому файлу.";
        } else
            echo "404 Not found";
    }
}

file_download(str_replace(" ","", $_GET['file']), 0);

