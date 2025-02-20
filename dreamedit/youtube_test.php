<?php
//include_once dirname(__FILE__)."/_include.php";
//
//$youtubeUploadVideosJson = file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=UUhbPkDspJgogVB0J4kWDt_w&maxResults=5&key=AIzaSyC5q_FJQpW8HwP2vadCchTBoLqiIqagSF8');
//$youtubeUploadVideos = json_decode($youtubeUploadVideosJson);
//
//if(!empty($youtubeUploadVideos->items)) {
//    $DB->query("TRUNCATE TABLE youtube_videos");
//    foreach ($youtubeUploadVideos->items as $item) {
//        $title = mb_convert_encoding($item->snippet->title,"windows-1251","UTF-8");
//        $description = mb_convert_encoding($item->snippet->description,"windows-1251","UTF-8");
//        $DB->query("INSERT INTO youtube_videos(title,description,thumbnail,url) VALUES(?,?,?,?)",$title,$description,$item->snippet->thumbnails->maxres->url,$item->snippet->resourceId->videoId);
//    }
//}