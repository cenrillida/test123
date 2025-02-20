<?php
ini_set('memory_limit', '256M');
include_once dirname(__FILE__)."/_include.php";

$file_path = $_SERVER["DOCUMENT_ROOT"].'/files/File/magazines/puty_miru/2019/01/FullText_1_2019.pdf'; // using just for this example, I pull $file_name from another function

function _create_preview_images($file_path) {

    // Strip document extension
    $file_name = basename($file_path, '.pdf');

    $save_folder = str_replace($file_name.".pdf","", $file_path)."pdfconverted/";
    mkdir($save_folder);

    // Convert this document
    // Each page to single image
    $img = new Imagick();

    // Set image resolution
    // Determine num of pages
    $img->setResolution(150,150);

    $img->readImage($file_path);

    // Compress Image Quality
    $img->setImageCompressionQuality(100);
    $num_pages = $img->getNumberImages();


    // Convert PDF pages to images
    for($i = 0;$i < $num_pages; $i++) {

        // Set iterator postion
        $img->setIteratorIndex($i);

        // Set image format
        $img->setImageFormat('jpeg');

        // Write Images to temp 'upload' folder
        $img->writeImages($save_folder.$file_name.'-'.$i.'.jpg', false);
    }

    $img->destroy();

    $img = new Imagick();

    $img->setResolution(25,25);

    // Compress Image Quality
    $img->readImage($file_path);

    $img->setImageCompressionQuality(50);

    $file_html_path = str_replace("/home/imemon/html", "", $save_folder);
    $html = "<div class='cover' data-background-file='$file_html_path$file_name-0.jpg' data-thumbnail-image='$file_html_path$file_name-th-0.jpg' data-page-label='t0'></div>";

    // Convert PDF pages to images
    for($i = 0;$i < $num_pages; $i++) {

        // Set iterator postion
        $img->setIteratorIndex($i);

        // Set image format
        $img->setImageFormat('jpeg');

        // Write Images to temp 'upload' folder
        $img->writeImages($save_folder.$file_name.'-th-'.$i.'.jpg', false);

        if($i!=0) {
            if ($num_pages == $i + 1) {
                $html .= "<div class='cover' data-background-file='$file_html_path$file_name-$i.jpg' data-thumbnail-image='$file_html_path$file_name-th-$i.jpg' data-page-label='t$i'></div>";
            } else {
                $html .= "<div class='page' data-background-file='$file_html_path$file_name-$i.jpg' data-thumbnail-image='$file_html_path$file_name-th-$i.jpg' data-page-label='t$i'></div>";
            }
        }
    }

    $img->destroy();

    global $DB;

    $check = $DB->select("SELECT path FROM pdf_converted WHERE path=?", $file_path);

    if(!empty($check)) {
        $DB->query("UPDATE pdf_converted SET html=? WHERE path=?", $html, $file_path);
    } else {
        $DB->query("INSERT INTO pdf_converted(path, html) VALUES (?,?)", $file_path, $html);
    }
}

_create_preview_images($file_path);