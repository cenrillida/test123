<?
include_once dirname(__FILE__)."/../../_include.php";
global $DB;

preg_match( '@[[:digit:]]*[[:digit:]]@' , $_POST['flickr_link'], $id);

$json = file_get_contents('https://www.flickr.com/services/rest?method=flickr.photosets.getPhotos&api_key=3988023e15f45c8d4ef5590261b1dc53&per_page=12&page=1&format=json&nojsoncallback=1&extras=url_l&photoset_id='.$id[0]);
$obj = json_decode($json);
$DB->query("TRUNCATE TABLE flickr_main");
foreach ($obj->photoset->photo as $photo) {
    $DB->query("INSERT INTO flickr_main(link) VALUES (?)", $photo->url_l);
}
if(!empty($obj->photoset->photo)) {
    echo "Успешно!";
} else {
    echo "Ошибка";
}


?>