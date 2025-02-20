
<?php
include_once dirname(__FILE__)."/_include.php";
global $DB;

function insertPhotosFromPhotoset($id) {
    global $DB;
    $json = file_get_contents('https://www.flickr.com/services/rest?method=flickr.photosets.getPhotos&api_key=3988023e15f45c8d4ef5590261b1dc53&page=1&format=json&nojsoncallback=1&extras=url_m&photoset_id='.$id);
    $obj = json_decode($json);
    $photo_array = $obj->photoset->photo;
    if(count($photo_array)>4) {

        do {
            $rand = mt_rand(0, count($photo_array)-1);
            $random_numbers[$rand] = $rand;
        } while( count($random_numbers) < 4 );

        $random_numbers = array_values($random_numbers); // This strips the keys

        foreach ($random_numbers as $number) {
            $DB->query("INSERT INTO flickr_main(link) VALUES (?)", $obj->photoset->photo[$number]->url_m);
        }
    } else {
        foreach ($obj->photoset->photo as $photo) {
            $DB->query("INSERT INTO flickr_main(link) VALUES (?)", $photo->url_m);
        }
    }
}

$flickr_photosets_json = file_get_contents('https://www.flickr.com/services/rest?method=flickr.photosets.getList&api_key=3988023e15f45c8d4ef5590261b1dc53&user_id=152126910@N03&format=json&nojsoncallback=1');
$flickr_photosets = json_decode($flickr_photosets_json);

if(!empty($flickr_photosets->photosets->photoset)) {
    $DB->query("TRUNCATE TABLE flickr_main");
    insertPhotosFromPhotoset($flickr_photosets->photosets->photoset[0]->id);
    insertPhotosFromPhotoset($flickr_photosets->photosets->photoset[1]->id);
    insertPhotosFromPhotoset($flickr_photosets->photosets->photoset[2]->id);
}