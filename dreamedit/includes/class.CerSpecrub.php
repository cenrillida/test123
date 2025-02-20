<?php

class CerSpecrub {

    private $id;
    private $title;
    private $title_en;
    private $fulltext;
    private $fulltext_en;
    private $date;
    private $iframe;
    private $iframe_en;
    private $img;
    private $img_en;
    private $status;
    private $status_en;

    public function __construct($id,
                                $title,
                                $title_en,
                                $fulltext,
                                $fulltext_en,
                                $date,
                                $iframe,
                                $iframe_en,
                                $img,
                                $img_en,
                                $status,
                                $status_en)
    {
        $this->id = $id;
        $this->title = $title;
        $this->title_en = $title_en;
        $this->fulltext = $fulltext;
        $this->fulltext_en = $fulltext_en;
        $this->date = $date;
        $this->iframe = $iframe;
        $this->iframe_en = $iframe_en;
        $this->img = $img;
        $this->img_en = $img_en;
        $this->status = $status;
        $this->status_en = $status_en;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFulltext()
    {
        return $this->fulltext;
    }

    /**
     * @return string
     */
    public function getFulltextEn()
    {
        return $this->fulltext_en;
    }

    /**
     * @return string
     */
    public function getIframe()
    {
        return $this->iframe;
    }

    /**
     * @return string
     */
    public function getIframeEn()
    {
        return $this->iframe_en;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return string
     */
    public function getImgEn()
    {
        return $this->img_en;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getStatusEn()
    {
        return $this->status_en;
    }
}

class CerSpecrubManager {

    public function __construct()
    {

    }

    /**
     * @return CerSpecrub
     */
    private function convertFromDB($element) {
        $specrubElement = new CerSpecrub(
            $element['id'],
            $element['title'],
            $element['title_en'],
            $element['fulltext'],
            $element['fulltext_en'],
            $element['date'],
            $element['iframe'],
            $element['iframe_en'],
            $element['img'],
            $element['img_en'],
            $element['status'],
            $element['status_en']);
        return $specrubElement;
    }

    /**
     * @return CerSpecrub[]
     */
    public function getAllElements($status = -1, $limit = -1, $lang = "ru") {
        global $DB;

        $statusField = "status";
        if($lang=="en") {
            $statusField = "status_en";
        }

        if($limit != -1) {
            $limit = " LIMIT ".(int)$limit;
        } else {
            $limit = "";
        }

        if($status==1) {
            $elements = $DB->select("SELECT * FROM cer_specrub WHERE " . $statusField . "=1 ORDER BY date DESC".$limit);
        } else {
            $elements = $DB->select("SELECT * FROM cer_specrub ORDER BY date DESC".$limit);
        }
        $resultArr = array();

        foreach ($elements as $element) {
            $resultArr[] = $this->convertFromDB($element);
        }

        return $resultArr;
    }

    /**
     * @return CerSpecrub
     */
    public function getElementByID($id) {
        global $DB;

        $element = $DB->selectRow("SELECT * FROM cer_specrub WHERE id=?d",(int)$id);

        if(!empty($element)) {
            return $this->convertFromDB($element);
        }
        return null;
    }

    /**
     * @param CerSpecrub $element
     * @return string
     */
    public function updateDBWithElement(CerSpecrub $element) {
        global $DB;

        if($element->getId()==-1) {
            $DB->query("INSERT INTO cer_specrub(title,title_en,`fulltext`,fulltext_en,`date`,iframe,iframe_en,img,img_en,status,status_en) 
                        VALUES (?,?,?,?,?,?,?,?,?,?d,?d)",
                        $element->getTitle(),
                        $element->getTitleEn(),
                        $element->getFulltext(),
                        $element->getFulltextEn(),
                        $element->getDate(),
                        $element->getIframe(),
                        $element->getIframeEn(),
                        $element->getImg(),
                        $element->getImgEn(),
                        $element->getStatus(),
                        $element->getStatusEn());
            $cacheEngine = new CacheEngine();
            $cacheEngine->reset();
            return "OK";
        }
        if((int)$element->getId()>0) {
            $elementCheck = $this->getElementByID($element->getId());
            if(empty($elementCheck)) {
                return "Элемента не существует";
            } else {
                $img = $element->getImg();
                $imgEn = $element->getImgEn();
                if(empty($img)) {
                    $img = $elementCheck->getImg();
                } else {
                    $imageDelete = $elementCheck->getImg();
                    if(!empty($imageDelete)) {
                        if (is_file($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$imageDelete))
                            unlink($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$imageDelete);
                    }
                }
                if(empty($imgEn)) {
                    $imgEn = $elementCheck->getImgEn();
                } else {
                    $imageDelete = $elementCheck->getImgEn();
                    if(!empty($imageDelete)) {
                        if (is_file($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$imageDelete))
                            unlink($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$imageDelete);
                    }
                }
                $DB->query("UPDATE cer_specrub SET 
                        title=?, 
                        title_en=?, 
                        `fulltext`=?, 
                        fulltext_en=?, 
                        `date`=?, 
                        iframe=?,
                        iframe_en=?,
                        img=?,
                        img_en=?,
                        status=?d,
                        status_en=?d 
                        WHERE id=?d",
                    $element->getTitle(),
                    $element->getTitleEn(),
                    $element->getFulltext(),
                    $element->getFulltextEn(),
                    $element->getDate(),
                    $element->getIframe(),
                    $element->getIframeEn(),
                    $img,
                    $imgEn,
                    $element->getStatus(),
                    $element->getStatusEn(),
                    $element->getId());
                $cacheEngine = new CacheEngine();
                $cacheEngine->reset();
                return "OK";
            }
        }
        return "Неизвестная ошибка";
    }

    /**
     * @return string
     */
    public function deleteFromDBByID($id) {
        global $DB;

        if((int)$id>0) {
            $elementCheck = $this->getElementByID($id);
            if(empty($elementCheck)) {
                return "Элемента не существует";
            } else {
                $DB->query("DELETE FROM cer_specrub WHERE id=?d",(int)$id);
                $img = $elementCheck->getImg();
                $imgEn = $elementCheck->getImgEn();

                if(!empty($img)) {
                    if (is_file($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$img))
                        unlink($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$img);
                }
                if(!empty($imgEn)) {
                    if (is_file($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$imgEn))
                        unlink($_SERVER["DOCUMENT_ROOT"] . "/files/Image/cerspecrub/".$imgEn);
                }
                $cacheEngine = new CacheEngine();
                $cacheEngine->reset();
                return "OK";
            }
        }
        return "Неизвестная ошибка";

    }

    /**
     * @param CerSpecrub $element
     */
    public function echoStat($element) {
        $id = $element->getId();
        $page[0][cerspecrub_id] = $id;
        $page[0][page_name] = $element->getTitle();
        Statistic::theStatNew("cerspecrub-".(int)$id, $page);
    }

    /**
     * @param CerSpecrub $element
     */
    public function echoForm($element = null) {
        if(!empty($element)) {
            $date = $element->getDate();
            $img = $element->getImg();
            $imgEn = $element->getImgEn();
            $checked = $element->getStatus();
            if($checked) {
                $checked = " checked";
            } else {
                $checked = "";
            }
            $checkedEn = $element->getStatusEn();
            if($checkedEn) {
                $checkedEn = " checked";
            } else {
                $checkedEn = "";
            }
            $fulltext = $element->getFulltext();
            $fulltext = str_replace("<br>","\r\n",$fulltext);
            $fulltextEn = $element->getFulltextEn();
            $fulltextEn = str_replace("<br>","\r\n",$fulltextEn);
        } else {
            $date = "";
            $img = "";
            $imgEn = "";
            $checked = " checked";
            $checkedEn = " checked";
            $fulltext = "";
            $fulltextEn = "";
        }
        ?>
        <form enctype="multipart/form-data" style="max-width: 500px;" class="text-center m-auto" id="form-add" name="add" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <div class="form-group">
                <label for="cer_title">Название</label>
                <input id="cer_title" class="inputbox form-control" type="text" alt="Название" name="cer_title"<?php if(!empty($element)) echo ' value="'.htmlspecialchars($element->getTitle()).'"';?> required/>
            </div>
            <div class="form-group">
                <label for="cer_title_en">Название (English)</label>
                <input id="cer_title_en" class="inputbox form-control" type="text" alt="Название (English)" name="cer_title_en"<?php if(!empty($element)) echo ' value="'.htmlspecialchars($element->getTitleEn()).'"';?>/>
            </div>
            <div class="form-group">
                <label for="cer_fulltext">Текст на картинке</label>
                <textarea class="form-control" id="cer_fulltext" name="cer_fulltext" placeholder="" required rows="3"><?php if(!empty($element)) echo htmlspecialchars($fulltext);?></textarea>
            </div>
            <div class="form-group">
                <label for="cer_fulltext_en">Текст на картинке (English)</label>
                <textarea class="form-control" id="cer_fulltext_en" name="cer_fulltext_en" placeholder="" rows="3"><?php if(!empty($element)) echo htmlspecialchars($fulltextEn);?></textarea>
            </div>
            <div class="form-group">
                <label for="cer_date">Дата</label>
                <input id="cer_date" class="inputbox form-control" type="datetime-local" name="cer_date" required<?php if(!empty($date)) echo ' value="'.str_replace(" ","T",substr($date,0,-3)).'"'; else echo ' value="'.date("Y-m-d").'T'.date("H:i").'"';?> />
            </div>
            <div class="form-group">
                <label for="cer_iframe">Ссылка на iframe</label>
                <input id="cer_iframe" class="inputbox form-control" type="text" name="cer_iframe" required<?php if(!empty($element)) echo ' value="'.htmlspecialchars($element->getIframe()).'"';?>/>
            </div>
            <div class="form-group">
                <label for="cer_iframe_en">Ссылка на iframe (English)</label>
                <input id="cer_iframe_en" class="inputbox form-control" type="text" name="cer_iframe_en"<?php if(!empty($element)) echo ' value="'.htmlspecialchars($element->getIframeEn()).'"';?>/>
            </div>
            <div class="form-group">
                <label for="file">Картинка</label><br>
            </div>
            <?php if(!empty($element) && $img!=""):?>
            <div class="my-3">
                <img src="/files/Image/cerspecrub/<?=$img?>" alt="">
            </div>
            <?php endif;?>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cer_img" name="cer_img">
                    <label class="custom-file-label" for="cer_img" data-browse="Выбрать файл">Выбрать файл</label>
                </div>
                <small id="fileHelp" class="form-text text-muted">
                    Картинка размером 440х293. Формат jpg, png. Не более 10МБ.
                </small>
            </div>
            <div class="form-group">
                <label for="file">Картинка (English)</label><br>
            </div>
            <?php if(!empty($element) &&  $imgEn!=""):?>
                <div class="my-3">
                    <img src="/files/Image/cerspecrub/<?=$imgEn?>" alt="">
                </div>
            <?php endif;?>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cer_img_en" name="cer_img_en">
                    <label class="custom-file-label" for="cer_img_en" data-browse="Выбрать файл">Выбрать файл</label>
                </div>
                <small id="fileHelp" class="form-text text-muted">
                    Картинка размером 440х293. Формат jpg, png. Не более 10МБ.
                </small>
            </div>
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox"<?=$checked?> id="cer_status" name="cer_status" >
                <label for="cer_status">
                    Опубликовать
                </label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox"<?=$checkedEn?> id="cer_status_en" name="cer_status_en" >
                <label for="cer_status_en">
                    Опубликовать (English)
                </label>
            </div>
            <?php if(!empty($element)):?>
                <input id="cer_id" class="inputbox form-control" type="hidden" name="cer_id" value="<?=$element->getId()?>"/>
            <?php endif;?>
            <a class='button_form imemo-button btn btn-lg imemo-button text-uppercase' name='submit' onclick="event.preventDefault(); document.getElementById('form-add').submit()" href="#">
                Сохранить
            </a>
        </form>
        <script language="JavaScript">
            $(document).ready(function () {
                bsCustomFileInput.init()
            });
        </script>
        <?php

    }

}