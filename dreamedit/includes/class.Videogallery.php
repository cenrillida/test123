<?php

class VideogalleryElement {

    private $id;
    private $title;
    private $titleEn;
    private $photoStop;
    private $date;
    private $params;
    private $paramsActive;
    private $youtubeUrl;
    private $titleNoMod;
    private $titleEnNoMod;
    private $dateNoMod;

    function __construct($id,$title,$titleEn,$photoStop,$date,$params,$paramsActive,$youtubeUrl,$titleNoMod,$titleEnNoMod,$dateNoMod)
    {
        $this->id=$id;
        $this->title=$title;
        $this->titleEn=$titleEn;
        $this->photoStop=$photoStop;
        $this->date=$date;
        $this->params=$params;
        $this->paramsActive=$paramsActive;
        $this->youtubeUrl=$youtubeUrl;
        $this->titleNoMod=$titleNoMod;
        $this->titleEnNoMod=$titleEnNoMod;
        $this->dateNoMod=$dateNoMod;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getTitleEn()
    {
        return $this->titleEn;
    }

    /**
     * @return mixed
     */
    public function getPhotoStop()
    {
        return $this->photoStop;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getParamsActive()
    {
        return $this->paramsActive;
    }

    /**
     * @return mixed
     */
    public function getYoutubeUrl()
    {
        return $this->youtubeUrl;
    }

    /**
     * @return mixed
     */
    public function getDateNoMod()
    {
        return $this->dateNoMod;
    }

    /**
     * @return mixed
     */
    public function getTitleNoMod()
    {
        return $this->titleNoMod;
    }

    /**
     * @return mixed
     */
    public function getTitleEnNoMod()
    {
        return $this->titleEnNoMod;
    }
}

class Videogallery {

    function __construct()
    {

    }

    /**
     * @return VideogalleryElement[]
     */
    private function moderateSelectedVideos($videos) {
        $ilines = new Ilines();

        $videos = $ilines->appendContent($videos);
        $videosElements = array();

        foreach ($videos as $id=>$video) {
            $params = "?rel=0&autoplay=1";
            if (!empty($video["content"]['TIME_SECONDS'])) $params .= "&start=" . $video["content"]['TIME_SECONDS'] . "&t=" . $video["content"]['TIME_SECONDS'];
            $par = "1";
            if ($video["content"]['PARAMS']) {
                $params = "";
                $par = "0";
            }
            if (!empty($video["content"]['TITLE_EN'])) {
                if (!empty($video["content"]['URL_EN']))
                    $titleVideoEn = '<a target="_blank" href="' . $video["content"]['URL_EN'] . '">' . $video["content"]['TITLE_EN'] . '</a>';
                else
                    $titleVideoEn = $video["content"]['TITLE_EN'];
            } else {
                if (!empty($video["content"]['URL']))
                    $titleVideoEn = '<a target="_blank" href="' . $video["content"]['URL'] . '">Sorry. Only in Russian</a>';
                else
                    $titleVideoEn = "Sorry. Only in Russian";
            }
            if (!empty($video["content"]['URL']))
                $titleVideo = '<a target="_blank" href="' . $video["content"]['URL'] . '">' . $video["content"]['TITLE'] . '</a>';
            else
                $titleVideo = $video["content"]['TITLE'];
            $iDate = explode('.', substr($video["content"]['DATE'], 0, 10));

            $videosElements[] = new VideogalleryElement($id,$titleVideo,$titleVideoEn,$video["content"]['PHOTO_STOP'],date('d.m.y', mktime(0, 0, 0, $iDate[1], $iDate[2], $iDate[0])),$params,$par,$video["content"]['YOUTUBE_URL'],$video["content"]['TITLE'],$video["content"]['TITLE_EN'],$video["content"]['DATE']);
        }
        return $videosElements;
    }

    /**
     * @return VideogalleryElement[]
     */
    function getVideos($type_id,$start,$count) {
        global $DB;
        $query = "SELECT e.el_id AS ARRAY_KEY
				 FROM adm_ilines_element AS e
				 INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var='date'
				 WHERE s.icont_text=1 AND e.itype_id=?d
                 ORDER BY d.icont_text DESC LIMIT ?d,?d
                ";
        $videos = $DB->select($query,$type_id,$start,$count);

        return $this->moderateSelectedVideos($videos);
    }

    /**
     * @return VideogalleryElement[]
     */
    function getVideosByPerson($id,$type_id,$start,$count) {
        global $DB;
        $query = "SELECT e.el_id AS ARRAY_KEY
				 FROM adm_ilines_element AS e
				 INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var='date'
				 INNER JOIN adm_ilines_content AS p ON p.el_id=e.el_id AND p.icont_var='people'
				 WHERE s.icont_text=1 AND e.itype_id=?d AND (p.icont_text LIKE '".(int)$id."<br>%' OR
                           p.icont_text LIKE '%<br>".(int)$id."<br>%' OR
                           p.icont_text LIKE '%<br>".(int)$id."')
                 ORDER BY d.icont_text DESC LIMIT ?d,?d
                ";
        $videos = $DB->select($query,$type_id,$start,$count);

        return $this->moderateSelectedVideos($videos);
    }

    /**
     * @return VideogalleryElement[]
     */
    function getVideosExclude($id,$type_id,$start,$count) {
        global $DB;
        $query = "SELECT e.el_id AS ARRAY_KEY
				 FROM adm_ilines_element AS e
				 INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=e.el_id AND d.icont_var='date'
				 WHERE s.icont_text=1 AND e.itype_id=?d AND e.el_id<>?d
                 ORDER BY d.icont_text DESC LIMIT ?d,?d
                ";
        $videos = $DB->select($query,$type_id,$id,$start,$count);

        return $this->moderateSelectedVideos($videos);
    }

    /**
     * @return VideogalleryElement[]
     */
    function getVideoById($id,$type_id) {
        global $DB;
        $query = "SELECT e.el_id AS ARRAY_KEY
				 FROM adm_ilines_element AS e
				 INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var='status'
				 WHERE s.icont_text=1 AND e.itype_id=?d AND e.el_id=?d
                ";
        $videos = $DB->select($query,$type_id,$id);

        return $this->moderateSelectedVideos($videos);
    }


}