<?php

class ArticleSendFormField {

    /** @var string */
    private $id;
    /** @var string */
    private $type;
    /** @var bool */
    private $required;
    /** @var string */
    private $text;
    /** @var string */
    private $checkText;
    /** @var string */
    private $placeholder;
    /** @var bool */
    private $emailValidate;
    /** @var string */
    private $emailValidateText;

    /**
     * ArticleSendFormField constructor.
     * @param string $id
     * @param string $type
     * @param bool $required
     * @param string $text
     * @param string $textEn
     * @param string $checkText
     * @param string $checkTextEn
     * @param bool $emailValidate
     * @param string $emailValidateText
     */
    public function __construct($id, $type, $required, $text, $checkText="", $placeholder="", $emailValidate = false, $emailValidateText = "")
    {
        $this->id = $id;
        $this->type = $type;
        $this->required = $required;
        $this->text = $text;
        $this->checkText = $checkText;
        $this->placeholder = $placeholder;
        $this->emailValidate = $emailValidate;
        $this->emailValidateText = $emailValidateText;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getCheckText()
    {
        return $this->checkText;
    }

    /**
     * @return bool
     */
    public function isEmailValidate()
    {
        return $this->emailValidate;
    }

    /**
     * @return string
     */
    public function getEmailValidateText()
    {
        return $this->emailValidateText;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }




}

class ArticleSendBuilder {

    private $result;
    private $docUpload;
    private $pdfUpload;
    /** @var ArticleSendFormField[] */
    private $fields;
    private $rubrics;
    private $jourId;
    private $newJourId;

    public function __construct($jourId = null, $newModule = false, $newJourId = null)
    {
        $this->newJourId = $newJourId;
        if(empty($jourId)) {
            $this->jourId = $_SESSION[jour_id];
        } else {
            $this->jourId = $jourId;
        }

        global $DB;
        $this->result = 0;

        include ($_SERVER['DOCUMENT_ROOT']."/classes/upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)
        //$max_size = 5120*1024; // the max. size for uploading
        $this->docUpload = new file_upload;
        $this->pdfUpload = new file_upload;

        $this->docUpload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/article_bank/"; // "files" is the folder for the uploaded files (you have to create this folder)
        $this->docUpload->extensions = array(".doc", ".docx"); // specify the allowed extensions here
        $this->docUpload->language = "ru"; // use this to switch the messages into an other language (translate first!!!)
        $this->docUpload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
        $this->docUpload->rename_file = true;

        $this->pdfUpload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/article_bank/"; // "files" is the folder for the uploaded files (you have to create this folder)
        $this->pdfUpload->extensions = array(".pdf"); // specify the allowed extensions here
        $this->pdfUpload->language = "ru"; // use this to switch the messages into an other language (translate first!!!)
        $this->pdfUpload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
        $this->pdfUpload->rename_file = true;

        $this->fields = array();

//        if ($_SESSION["lang"]!='/en')
//        {
//            $rows=$mz->getRubricAll($_SESSION[jour_id],1,' ',' ' ,"*");
//
//        }
//        else
//        {
//
//            $rows=$mz->getRubricAllEn($_SESSION[jour_id],1,' ',' ' ,"*");
//        }
        $_REQUEST[jj]=$this->jourId;
        $journalPostFix = "";
        if($newModule) {
            $journalPostFix = "_new";
            $_REQUEST[jj]=$this->newJourId;
        }


        if ($_SESSION[lang]!='/en')
            $rows=$DB->select("SELECT SUBSTRING_INDEX(IFNULL(r.name,r.page_name),':',1) AS name,
	 IFNULL(r.name_en,r.page_name) AS name_en,sum(z.count) AS sum 
	 FROM 
	 (SELECT page_parent,count(page_id)AS count 
		FROM `adm_article` WHERE date_public<>'' AND page_template='jarticle' 
		AND IFNULL(name,page_name) <> 'Авторы этого номера'
		GROUP BY page_parent) AS z 
		INNER JOIN adm_article AS r ON r.page_id=z.page_parent AND r.page_template='jrubric' 
		    AND r.journal".$journalPostFix."='".$_REQUEST[jj]."' 
		GROUP BY SUBSTRING_INDEX(IFNULL(name,page_name),':',1)
		ORDER BY IFNULL(name,page_name)");
        else
            $rows=$DB->select("SELECT SUBSTRING_INDEX(IFNULL(r.name,r.page_name),':',1) AS name,
	 IFNULL(r.name_en,r.page_name) AS name_en,sum(z.count) AS sum, name_en AS en 
	 FROM 
	 (SELECT page_parent,count(page_id)AS count 
		FROM `adm_article` WHERE date_public<>'' AND page_template='jarticle' 
		GROUP BY page_parent) AS z 
		INNER JOIN adm_article AS r ON r.page_id=z.page_parent AND r.page_template='jrubric' 
		AND r.journal".$journalPostFix."='".$_REQUEST[jj]."'
		GROUP BY SUBSTRING_INDEX(page_name,':',1)
		ORDER BY IF(IFNULL(r.name_en,' ')=' ',0,1) DESC, r.name_en");
//print_r($rows);

        $this->rubrics = array();

        foreach ($rows as $row) {
            $this->rubrics[] = $row['name'];
        }
    }

    /**
     * @param ArticleSendFormField $field
     */
    public function registerField($field) {
        $this->fields[] = $field;
    }

    private function echoFields() {
        foreach ($this->fields as $field) {
            if($field->getType()=="file"):?>
                <div class="form-group">
                    <label for="file"><b><?=$field->getText()?></b></label><br>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="<?=$field->getId()?>" name="<?=$field->getId()?>">
                        <label class="custom-file-label" for="<?=$field->getId()?>" data-browse="<?=$field->getPlaceholder()?>"><?=$field->getPlaceholder()?></label>
                    </div>
                </div>
            <?php elseif($field->getType()=="rubric"):?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="<?=$field->getId()?>"><?=$field->getText()?><?php if($field->isRequired()) echo " (*)";?></label>
                        <input type='text' name='<?=$field->getId()?>' id='<?=$field->getId()?>' class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rubrics"><?=$field->getPlaceholder()?></label>
                        <select onchange="chrub('<?=$field->getId()?>')" id="rub" class="form-control"><option value=''></option>
                            <?php
                            foreach ($this->rubrics as $rubric) {
                                echo "<option value='" . $rubric . "' title='" . $rubric . "'>" . substr($rubric, 0, 75) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php else:?>
                <div class="form-group">
                    <label for="<?=$field->getId()?>"><?=$field->getText()?><?php if($field->isRequired()) echo " (*)";?></label>
                    <?php if ($field->getType() == "textarea"): ?>
                        <textarea class="form-control" name='<?=$field->getId()?>' id='<?=$field->getId()?>' rows="2"></textarea>
                    <?php elseif($field->getType() == "select"):
                        $options = $field->getPlaceholder();
                        $options = explode("|",$options);
                        ?>
                        <select id="<?=$field->getId()?>" name="<?=$field->getId()?>" class="form-control">
                            <?php
                            foreach ($options as $option) {
                                echo "<option value='" . $option . "' title='" . $option . "'>" . substr($option, 0, 75) . "</option>";
                            }
                            ?>
                        </select>
                    <?php else: ?>
                        <input type='<?=$field->getType()?>' name='<?=$field->getId()?>' id='<?=$field->getId()?>' class="form-control" placeholder="<?=$field->getPlaceholder()?>">
                    <?php endif; ?>
                </div>
            <?php
            endif;
        }
    }

    private function echoCheckFields() {
        foreach ($this->fields as $field) {
            if($field->isRequired()):?>
                if(!checkParam("<?=$field->getId()?>", "<?=$field->getCheckText()?>")) {
                    success = false;
                }
                <?php
                if($field->isEmailValidate()):?>
                    else {
                        if (!check_email(document.getElementById("<?=$field->getId()?>").value)) {
                            $("#<?=$field->getId()?>").parent().append("<div class=\"invalid-feedback\"><?=$field->getEmailValidateText()?></div>");
                            $("#<?=$field->getId()?>").removeClass('is-valid');
                            $("#<?=$field->getId()?>").addClass('is-invalid');
                            success = false;
                        }
                    }
                <?php
                endif;
            endif;
        }
    }

    public function build() {
        global $DB;

        ?>
        <script language="JavaScript">
            $(document).ready(function () {
                bsCustomFileInput.init()
            });
            function check_email(email) {
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return filter.test(email);
            }

            function FeedCheck(param) {

                $('.invalid-feedback').remove();
                $('.is-valid').removeClass('is-valid');
                $('.is-invalid').removeClass('is-invalid');

                var success = true;

                if (param!="en") {
                    if (!document.getElementById("agreament").checked) {
                        $("#agreament").parent().append("<div class=\"invalid-feedback\">Необходимо согласится с правилами отправки</div>");
                        $("#agreament").addClass('is-invalid');
                        success = false;
                    } else {
                        $("#agreament").addClass('is-valid');
                    }
                } else {
                    if (!document.getElementById("agreament").checked) {
                        $("#agreament").parent().append("<div class=\"invalid-feedback\">Need your agreement with rules</div>");
                        $("#agreament").addClass('is-invalid');
                        success = false;
                    } else {
                        $("#agreament").addClass('is-valid');
                    }
                }

                <?php
                    $this->echoCheckFields();
                ?>

                if(!success) {
                    return false;
                }

                if (!grecaptcha.getResponse()) {
                    if (param!="en")
                        alert("Пройдите спам проверку");
                    else alert("Spam protection failed");
                    return false;
                }

                return true;
            }
            function chrub(field)
            {

                var a=document.getElementById('rub');
                document.getElementById(field).value=a.value;

            }
            function spamsend(dig1j,dig2j)
            {

                // if(Number(d1)+Number(d2)!=Number(sum))
                // {
                //
                // 	alert("Вы не прошли спам-контроль");
                // 	return false
                // }
                return true;
            }
            function checkParam(attr,text) {
                if (document.getElementById(attr).value=="") {
                    $("#"+attr).parent().append("<div class=\"invalid-feedback\">"+text+"</div>");
                    $("#"+attr).addClass('is-invalid');
                    return false;
                } else {
                    $("#"+attr).addClass('is-valid');
                }
                return true;
            }
        </script>


        <?

        if($this->result)
        {
            if($_SESSION[lang]!='/en')
                echo '<div class="sent-block"><img width=170px src="/img/e_mail_b.jpg" /><p>Ваша статья отправлена.</p></div>';
            else
                echo '<div class="sent-block"><img width=170px src="/img/e_mail_b.jpg" /><p>Your article have been sent.</p></div>';
        }

        if ($_SESSION[lang]=="/en") $param='en'; else $param="";

        ?>

        <form name="feedform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return FeedCheck('<?=@$param?>')">
            <? if($this->result == false)
            {
                $this->echoFields();
                if ($_SESSION[lang] !='/en')
                {
                        ?>

                        <div class="form-group">
                            <label for="spamp"><b>Защита от спама (*)</b></label>
                            <div class="g-recaptcha" data-sitekey="6LecaG8UAAAAADsh6X_qAAM9NVd26fZggzJwh-HJ" name="spamp" id="spamp"></div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="agreament" name="agreament">
                            <label class="form-check-label" for="agreament">
                                С требованиями, изложенными в разделе "Авторам" согласен/согласна
                            </label>
                        </div>

                        <?php

                }
                else
                {

                    ?>

                    <div class="form-group">
                        <label for="spamp"><b>Spam protection (*)</b></label>
                        <div class="g-recaptcha" data-sitekey="6LecaG8UAAAAADsh6X_qAAM9NVd26fZggzJwh-HJ" name="spamp" id="spamp"></div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="agreament" name="agreament">
                        <label class="form-check-label" for="agreament">
                            Agree with rules in "Author's guide" section
                        </label>
                    </div>


                    <?php
                }
                if ($_SESSION[lang] !='/en')
                    echo "	  <input type='submit' name='Submit' value='Отправить' class='btn btn-lg btn-primary imemo-button text-uppercase'>";
                else
                    echo "	  <input type='submit' name='Submit' value='Send' class='btn btn-lg btn-primary imemo-button text-uppercase'>";

            }
            ?>
        </form>
        <br clear="all">
        <p>
            <?

            if (!empty($_POST)) {
                if($this->result == false)
                {
                    if ($_SESSION[lang]!='/en')
                        echo "Ошибка отправки. Повторите еще раз";
                    else
                        echo "Error sending. Try again";
                }
            }

            ?>
        </p>

        <?

    }

    /**
     * @param string $email
     * @param bool $table
     */
    public function processPostBuild($email,$table) {
        global $DB;

        if(isset($_POST['Submit']))
        {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data_captcha['secret'] = '6LecaG8UAAAAAHtU8Ee0sF7_oxV61LBV8U1zHCun';
            $data_captcha['response'] = $_POST["g-recaptcha-response"];
            $options['http']['method'] = "POST";
            $options['http']['content'] = http_build_query($data_captcha);

            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success=json_decode($verify);
            if ($captcha_success->success==false) {
                if($_SESSION[lang]!="/en")
                {
                    echo "Не пройдена проверка от спама.<br /><br />";
                    echo "Пожалуйста <a href='javascript:history.go(-1)'>вернитесь</a> и попробуйте снова.";
                }
                else
                {
                    echo "Spam protection failed.<br /><br />";
                    echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
                }
                exit;
            } else if ($captcha_success->success==true) {

                $this->docUpload->the_temp_file = $_FILES['upload2']['tmp_name'];
                $this->docUpload->the_file = $_FILES['upload2']['name'];
                $this->docUpload->http_error = $_FILES['upload2']['error'];
                $this->docUpload->replace = "y";
                $this->docUpload->do_filename_check = "n"; // use this boolean to check for a valid filename
                $temp = "Загрузка ";
                if ($this->docUpload->upload())
                    $file = $this->docUpload->file_copy;

                $this->pdfUpload->the_temp_file = $_FILES['upload_pdf']['tmp_name'];
                $this->pdfUpload->the_file = $_FILES['upload_pdf']['name'];
                $this->pdfUpload->http_error = $_FILES['upload_pdf']['error'];
                $this->pdfUpload->replace = "y";
                $this->pdfUpload->do_filename_check = "n"; // use this boolean to check for a valid filename
                if ($this->pdfUpload->upload())
                    $file2 = $this->pdfUpload->file_copy;




                if(!empty($email)) {
                    $nn = "<br>";

                    if(empty($file)) {
                        $file_str = "Отсутствует";
                    } else {
                        $file_str = "https://imemo.ru/article_bank/";
                    }

                    $data = "<b>Форма отправки статьи</b>:" . $nn;

                    foreach ($this->fields as $field) {
                        if($field->getType() == "file") {
                            $data .= "Файл: " . $file_str.$file . ", " . $nn;
                        } else {
                            $data .= $field->getText() . ": " . $_POST[$field->getId()] . ", " . $nn;
                        }
                    }

                    if(!empty($file)) {
                        MailSend::send_mime_mail_attachment("Форма отправки статьи", $email, "", $email, "cp1251", "utf-8", "Форма отправки статьи", $data, $file,$_SERVER['DOCUMENT_ROOT']."/article_bank/", $_FILES['upload2']['name']);
                    } else {
                        MailSend::send_mime_mail("Форма отправки статьи", $email, "", $email, "cp1251", "utf-8", "Форма отправки статьи", $data);
                    }
                }

                if(empty($file)) {
                    $file = '';
                }

                if ($table) {
                    if(empty($_POST['fio'])) $_POST['fio']='';
                    if(empty($_POST['fio_en'])) $_POST['fio_en']='';
                    if(empty($_POST['name'])) $_POST['name']='';
                    if(empty($_POST['name_en'])) $_POST['name_en']='';
                    if(empty($_POST['affiliation'])) $_POST['affiliation']='';
                    if(empty($_POST['affiliation_en'])) $_POST['affiliation_en']='';
                    if(empty($_POST['rubric'])) $_POST['rubric']='';
                    if(empty($_POST['email'])) $_POST['email']='';
                    if(empty($_POST['telephone'])) $_POST['telephone']='';
                    if(empty($_POST['text'])) $_POST['text']='';



                    if ($_POST['email'] != 'sample@email.tst') {
                        if ($DB->query("INSERT INTO article_send (id,journal,fio,fio_en,`name`,name_en,affiliation,affiliation_en,rubric,email,telephone,file,file2,text,`date`,`time`)
			   VALUES(0,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",$this->jourId,$_POST['fio'],$_POST['fio_en'],$_POST['name'],$_POST['name_en'],$_POST['affiliation'],$_POST['affiliation_en'],$_POST['rubric'],$_POST['email'],$_POST['telephone'],$file,'',$_POST['text'],date(Ymd),time() ))
                            $this->result = true;
                        else $this->result = false;
                    }

                }
            }
        }
    }

}