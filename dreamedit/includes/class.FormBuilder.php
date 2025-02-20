<?php

class OptionField {

    /** @var string */
    private $value;
    /** @var string */
    private $title;
    /** @var bool */
    private $selected;

    /**
     * OptionField constructor.
     * @param string $value
     * @param string $title
     */
    public function __construct($value, $title, $selected = false)
    {
        $this->value = $value;
        $this->title = $title;
        $this->selected = $selected;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isSelected()
    {
        return $this->selected;
    }

    /**
     * @param bool $selected
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

}

class RadioField {

    /** @var string */
    private $value;
    /** @var string */
    private $title;
    /** @var string */
    private $id;
    /** @var bool */
    private $checked;

    /**
     * RadioField constructor.
     * @param string $value
     * @param string $title
     * @param string $id
     * @param bool $checked
     */
    public function __construct($value, $title, $id, $checked)
    {
        $this->value = $value;
        $this->title = $title;
        $this->id = $id;
        $this->checked = $checked;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isChecked()
    {
        return $this->checked;
    }

}

class FileField {

    /** @var mixed */
    private $value;
    /** @var string */
    private $uploadPath;
    /** @var string[] */
    private $extensions;
    /** @var int */
    private $maxSize;
    /** @var string */
    private $filePrefix;
    /** @var string */
    private $fileType;
    /** @var array */
    private $changableValues;

    /**
     * FileField constructor.
     * @param mixed $value
     * @param string $uploadPath
     * @param string[] $extensions
     * @param int $maxSize
     * @param string $filePrefix
     * @param string $fileType
     */
    public function __construct($value, $uploadPath, array $extensions, $maxSize, $filePrefix, $fileType, $changableValues = array())
    {
        $this->value = $value;
        $this->uploadPath = $uploadPath;
        $this->extensions = $extensions;
        $this->maxSize = $maxSize;
        $this->filePrefix = $filePrefix;
        $this->fileType = $fileType;
        $this->changableValues = $changableValues;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    /**
     * @return string[]
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @return int
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @return string
     */
    public function getFilePrefix()
    {
        return $this->filePrefix;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @return array
     */
    public function getChangableValues()
    {
        return $this->changableValues;
    }

}

class FormField {

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
    /** @var mixed */
    private $value;
    /** @var OptionField[] */
    private $selectOptions;
    /** @var RadioField[] */
    private $radioOptions;
    /** @var string */
    private $colClass;
    /** @var FormField[] */
    private $complexFormFields;
    /** @var int */
    private $rows;
    /** @var FileField */
    private $fileField;
    /** @var string */
    private $oldId;
    /** @var bool */
    private $readOnly = false;
    /** @var string */
    private $switchableRequiredField = "";


    /**
     * FormField constructor.
     * @param string $id
     * @param string $type
     * @param bool $required
     * @param string $text
     * @param string $checkText
     * @param string $placeholder
     * @param bool $emailValidate
     * @param string $emailValidateText
     * @param mixed $value
     * @param OptionField[] $selectOptions
     * @param RadioField[] $radioOptions
     * @param string $colClass
     * @param FormField[] $complexFormFields
     * @param int $rows
     */
    public function __construct($id, $type, $required, $text, $checkText="", $placeholder="", $emailValidate = false, $emailValidateText = "", $value = "", $selectOptions = array(), $radioOptions = array(), $colClass = "", $complexFormFields = array(), $rows = 2, $fileField = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->required = $required;
        $this->text = $text;
        $this->checkText = $checkText;
        $this->placeholder = $placeholder;
        $this->emailValidate = $emailValidate;
        $this->emailValidateText = $emailValidateText;
        $this->value = $value;
        $this->selectOptions = $selectOptions;
        $this->radioOptions = $radioOptions;
        $this->colClass = $colClass;
        $this->complexFormFields = $complexFormFields;
        $this->rows = $rows;
        $this->fileField = $fileField;
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

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return OptionField[]
     */
    public function getSelectOptions()
    {
        return $this->selectOptions;
    }

    /**
     * @return RadioField[]
     */
    public function getRadioOptions()
    {
        return $this->radioOptions;
    }

    /**
     * @return string
     */
    public function getColClass()
    {
        return $this->colClass;
    }

    /**
     * @return FormField[]
     */
    public function getComplexFormFields()
    {
        return $this->complexFormFields;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return FileField
     */
    public function getFileField()
    {
        return $this->fileField;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getOldId()
    {
        return $this->oldId;
    }

    /**
     * @param string $oldId
     */
    public function setOldId($oldId)
    {
        $this->oldId = $oldId;
    }

    /**
     * @param bool $readOnly
     */
    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;
    }

    /**
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @return string
     */
    public function getSwitchableRequiredField()
    {
        return $this->switchableRequiredField;
    }

    /**
     * @param string $switchableRequiredField
     */
    public function setSwitchableRequiredField($switchableRequiredField)
    {
        $this->switchableRequiredField = $switchableRequiredField;
    }

}

class FormFieldError {

    /** @var string $id */
    private $id;
    /** @var string $id */
    private $text;

    /**
     * FormFieldError constructor.
     * @param string $id
     * @param string $text
     */
    public function __construct($id, $text)
    {
        $this->id = $id;
        $this->text = $text;
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
    public function getText()
    {
        return $this->text;
    }

}

class FormBuilder {

    protected $result;
    protected $docUpload;
    protected $pdfUpload;
    protected $uploadedFiles = array();
    protected $sendFields = array();
    private $sendText;
    private $rulesText;
    private $uploadedDoc;
    private $uploadedPdf;
    private $submitText;
    private $antiSpam;
    /** @var FormField[] */
    protected $fields;
    /** @var FormFieldError[] */
    protected $errorFields;

    public function __construct($sendText,$rulesText,$upload_path,$submitText,$antiSpam=true)
    {
        global $DB;
        $this->result = 0;
        $this->sendText = $sendText;
        $this->rulesText = $rulesText;
        $this->submitText = $submitText;
        $this->antiSpam = $antiSpam;

        include ($_SERVER['DOCUMENT_ROOT']."/classes/upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)

        $this->fields = array();
        $this->errorFields = array();
    }

    /**
     * @param FormField $field
     */
    public function registerField($field) {
        $this->fields[] = $field;
    }

    /**
     * @param FormFieldError $field
     */
    public function registerErrorField($field) {
        $this->errorFields[] = $field;
    }

    /**
     * @param FormField[] $fields
     * @param int $parentFiledId
     */
    private function echoFields($fields = array(), $parentFiledId = null, $iterator = "", $complexPrefix = "", $previousPrefix = "") {
        if(empty($fields)) {
            $fields = $this->fields;
        }
        foreach ($fields as $field) {
            switch ($field->getType()) {
                case "complex-block":
//                    if($_GET[debug]==555) {
//                        $complexFormField = $field->getComplexFormFields();
//                        foreach ($complexFormField as $complexField) {
//                            if($complexField->getType()=="complex-block") {
//                                $complexFormField2 = $complexField->getComplexFormFields();
//                                foreach ($complexFormField2 as $complexField2) {
//                                    if($complexField2->getType()=="complex-block") {
//                                        var_dump($complexField2->getId(), $complexField2->getOldId());
//                                    }
//                                }
//                                var_dump($complexField->getId(), $complexField->getOldId());
//                            }
//                        }
//                        var_dump($field->getId(), $field->getOldId());
//                    }
                    ?>

                    <div id="list<?=$complexPrefix.$field->getId()?>" style="display: none">
                        <h5 class="header<?=$complexPrefix.$field->getId()?>" style="font-weight: bold">1)</h5>
                        <?php $this->echoFields($field->getComplexFormFields());


                        ?>
                        <hr>
                    </div>
                    <div id="echoList<?=$complexPrefix.$field->getId()?>" class="<?=$field->getColClass()?>">
                        <?php
                        $existFields = $field->getValue();
                        if(!empty($existFields)):
                            $fieldCounter = 1;
                            foreach ($existFields as $existField) {
                                foreach ($field->getComplexFormFields() as $complexFormField) {


                                    $oldId = $complexFormField->getOldId();
                                    if (!empty($oldId))
                                        $complexFormField->setId($oldId);

                                    $complexFormField->setOldId($complexFormField->getId());
                                    $complexFormField->setValue($existField[$complexFormField->getId()]);
                                    $complexFormField->setId($complexFormField->getId().$fieldCounter);
                                }
                                echo "<div id='block".$complexPrefix.$field->getId().$fieldCounter."'>";
                                ?>
                                <h5 class="header<?=$complexPrefix.$field->getId()?>" style="font-weight: bold"><?=$fieldCounter?>)</h5>
                                <?php

                                $this->echoFields($field->getComplexFormFields(),$field->getId(),$fieldCounter,$complexPrefix.$field->getId().$fieldCounter, $complexPrefix);
                                echo "<hr></div>";
                                $fieldCounter++;
                            }
                            foreach ($field->getComplexFormFields() as $complexFormField) {
                                $oldId = $complexFormField->getOldId();
                                if (!empty($oldId))
                                    $complexFormField->setId($oldId);
                                $complexFormField->setValue("");
                            }
                            ?>
                        <?php
                        else:
                            $fieldCounter=0;

                        endif;?>
                    </div>

                    <input type="hidden" name="count-<?=$complexPrefix.$field->getId()?>" id="count-<?=$complexPrefix.$field->getId()?>" value="<?php if($fieldCounter==0) echo $fieldCounter; else echo $fieldCounter-1;?>">
                    <?php if($field->getText()!=""):?>
                    <div class="container-fluid">
                        <div class="row justify-content-start">
                            <div>
                                <div class="mr-3 mt-3">
                                    <a class="btn btn-lg imemo-button text-uppercase addComplexListButton<?php if($field->getOldId()!="") echo $field->getOldId(); else echo $field->getId();?>" data-prefixcomplex="<?=$complexPrefix?>" data-complexid="<?=$complexPrefix.$field->getId()?>" id="addList<?=$complexPrefix.$field->getId()?>" href="#" role="button"><?=$field->getText()?></a>
                                </div>
                            </div>
                            <div>
                                <div class="mr-3 mt-3">
                                    <a class="btn btn-lg imemo-button text-uppercase removeComplexListButton<?php if($field->getOldId()!="") echo $field->getOldId(); else echo $field->getId();?>" data-prefixcomplex="<?=$complexPrefix?>" data-complexid="<?=$complexPrefix.$field->getId()?>" <?php if($fieldCounter==0) echo "style=\"display: none\"";?> id="remove<?=$complexPrefix.$field->getId()?>" href="#" role="button">Удалить последний элемент</a>
                                </div>
                            </div>
                            <?php if($complexPrefix==""):?>
                            <?php $this->echoComplexScript($complexPrefix, $field, $fieldCounter);?>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php
                    break;
                case "form-row":
                    ?>
                    <div class="form-row">
                    <?php
                    break;
                case "form-row-end":
                    ?>
                    </div>
                    <?php
                    break;
                case "hr":
                    ?>
                    <div>
                        <hr>
                    </div>
                    <?php
                    break;
                case "header-text":
                    ?>
                    <div class="<?=$field->getColClass()?>">
                        <p><?=$field->getText()?></p>
                    </div>
                    <?php
                    break;
                case "header":
                    ?>
                    <div class="<?=$field->getColClass()?>">
                        <h5 style="font-weight: bold;"><?=$field->getText()?></h5>
                    </div>
                    <?php
                    break;
                case "file":
                    ?>
                    <?php if(in_array($field->getFileField()->getFileType(),array('pdf', 'docx'))):
                    if($field->getFileField()->getValue()!=""):

                        if(is_array($field->getFileField()->getValue())) {
                            $changableValues = $field->getFileField()->getChangableValues();
                            if(!empty($changableValues)) {
                                $fileFields = $changableValues;
                            } else {
                                $fileFields = $field->getFileField()->getValue();
                            }
                            ?>
                            <div id="<?=$previousPrefix.$field->getId()?>-link"<?php if(empty($fileFields[$parentFiledId.$iterator][$field->getOldId()])) echo ' style="display: none;"'?>>
                                <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=<?=$fileFields[$parentFiledId.$iterator][$field->getOldId()]?>" role="button">Прикрепленный ранее файл</a>
                            </div>

                        <?php
                        }
                        else {
                                if($field->getFileField()->getFileType()=='pdf'):
                                ?>
                                <div>
                                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank"
                                                                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=getPdfFile&file=<?= $field->getFileField()->getValue() ?>"
                                                                                   role="button">Прикрепленный ранее
                                        файл</a>
                                </div>
                                    <?php
                                endif;
                                if($field->getFileField()->getFileType()=='docx'):
                                    ?>
                                    <div>
                                        <i class="fas fa-file-word text-primary"></i> <a target="_blank"
                                                                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=getPdfFile&file=<?= $field->getFileField()->getValue() ?>"
                                                                                       role="button">Прикрепленный ранее
                                            файл</a>
                                    </div>
                                <?php
                                endif;
                            }
                    endif;
                    endif;?>
                    <?php if($field->getFileField()->getFileType()=="image"):?>
                    <div>
                        <img class="mw-100" src="<?=$field->getValue()?>" alt="">
                    </div>
                <?php endif;?>
                    <div class="form-group">
                        <label for="file"><b><?=$field->getText()?></b><?php if($field->isRequired()) echo "<i class='text-danger'>*</i>";?></label><br>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="<?=$previousPrefix.$field->getId()?>" name="<?=$previousPrefix.$field->getId()?>">
                            <label class="custom-file-label" for="<?=$previousPrefix.$field->getId()?>" data-browse="<?=$field->getPlaceholder()?>"><?=$field->getPlaceholder()?></label>
                        </div>
                    </div>
                    <?php
                    break;
                default:
                    ?>
                    <div class="form-group <?=$field->getColClass()?>">
                        <?php if($field->getType()!="hidden" && $field->getType()!="checkbox"):?>
                            <label for="<?=$previousPrefix.$field->getId()?>"><?=$field->getText()?><?php if($field->isRequired()) echo "<i class='text-danger'>*</i>";?></label>
                        <?php endif;?>
                        <?php if ($field->getType() == "textarea"): ?>
                            <textarea class="form-control" name='<?=$previousPrefix.$field->getId()?>' id='<?=$previousPrefix.$field->getId()?>' placeholder="<?=$field->getPlaceholder()?>" rows="<?=$field->getRows()?>"><?=$field->getValue()?></textarea>
                        <?php elseif($field->getType() == "select"):
                            $options = $field->getSelectOptions();
                            ?>
                            <select id="<?=$field->getId()?>" name="<?=$field->getId()?>" class="form-control">
                                <?php
                                foreach ($options as $option) {
                                    $selected = "";
                                    if($option->isSelected()) $selected = " selected";

                                    if($field->getValue()==$option->getValue()) $selected = " selected";
                                    echo "<option value='" . $option->getValue() . "' title='" . $option->getTitle() . "'".$selected.">" . $option->getTitle(). "</option>";
                                }
                                ?>
                            </select>
                        <?php elseif($field->getType() == "radio"):
                            $options = $field->getRadioOptions();
                            foreach ($options as $option):
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?=$previousPrefix.$field->getId()?>" id="<?=$option->getId()?>" value="<?=$option->getValue()?>"<?php if($option->isChecked()) echo " checked";?>>
                                    <label class="form-check-label" for="<?=$option->getId()?>">
                                        <?=$option->getTitle()?>
                                    </label>
                                </div>
                            <?php endforeach;?>
                        <?php elseif($field->getType() == "checkbox"):?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="<?=$previousPrefix.$field->getId()?>" value="1" id="<?=$previousPrefix.$field->getId()?>" <?php if($field->getValue()=="1") echo "checked";?>>
                                <label class="form-check-label" for="<?=$previousPrefix.$field->getId()?>">
                                    <?=$field->getText()?>
                                </label>
                            </div>
                        <?php else: ?>
                            <input type='<?=$field->getType()?>' name='<?=$previousPrefix.$field->getId()?>' id='<?=$previousPrefix.$field->getId()?>' class="form-control" placeholder="<?=$field->getPlaceholder()?>" value="<?=$field->getValue()?>" <?php if($field->isReadOnly()) echo 'readonly';?>>
                        <?php endif; ?>
                    </div>
                <?php
            }
        }
    }

    /**
     * @param string $complexPrefix
     * @param FormField $field
     * @param int $fieldCounter
     * @param string $counterArray
     */
    private function echoComplexScript($complexPrefix = "", $field = null, $fieldCounter = 0, $counterArray = "") {
        ?>
        <script>
            function addEventsComplexButtons<?=$field->getId()?>() {
                $( '.addComplexListButton<?=$field->getId()?>' ).off();
                $( '.removeComplexListButton<?=$field->getId()?>' ).off();
                $( '.addComplexListButton<?=$field->getId()?>' ).on( "click", function(event) {
                    event.preventDefault();
                    var currentBlockName = $(this).data("complexid");
                    var currentPrefix = $(this).data("prefixcomplex");
                    if(currentPrefix === undefined) {
                        currentPrefix = "";
                    }
                    var currentBlockCount = $('#count-'+currentBlockName).attr("value");
                    currentBlockCount++;
                    $('#count-'+currentBlockName).attr("value",currentBlockCount);

                    var listTemplate = document.createElement("DIV");
                    listTemplate.innerHTML = $('#list'+currentBlockName).html();
                    var listTemplateArr = $(listTemplate);
                    listTemplateArr.attr("id",'block'+currentBlockName + currentBlockCount);
                    listTemplateArr.find('.header'+currentBlockName).html(currentBlockCount + ")");
                    <?php foreach ($field->getComplexFormFields() as $complexField):
                    $id = $complexPrefix.$complexField->getId();
                    if(!empty($id)):
                    if($complexField->getType()=="file" && $complexField->getFileField()->getFileType()=="pdf") {
                    $changableValues = $complexField->getFileField()->getChangableValues();
                    if(!empty($changableValues)) {
                        $currentValues = $changableValues;
                    } else {
                        $currentValues = $complexField->getFileField()->getValue();
                    }
                    $itemsCounter = 1;
                    ?>
                    listTemplateArr.find('#'+currentPrefix+'<?=$complexField->getId()?>-link').hide();
                    <?php
                    foreach ($currentValues as $item):
                    ?>
                    if(currentBlockCount==<?=$itemsCounter?> && "<?=$item[$complexField->getId()]?>"!=="") {
                        listTemplateArr.find('#<?=$complexField->getId()?>-link').find('a').attr("href",listTemplateArr.find('#<?=$complexField->getId()?>-link').find('a').attr("href")+"<?=$item[$complexField->getId()]?>");
                        listTemplateArr.find('#<?=$complexField->getId()?>-link').show();
                        listTemplateArr.find('#<?=$complexField->getId()?>-link').attr("id",currentPrefix+'<?=$complexField->getId()?>' + currentBlockCount);
                    }
                    <?php
                    $itemsCounter++;
                    endforeach;
                    }
                    if($complexField->getType()=="complex-block") {
                    ?>
                    listTemplateArr.find(".header<?=$complexField->getId()?>").attr("class",'header'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    listTemplateArr.find("#list<?=$complexField->getId()?>").attr("id",'list'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    var addListLink = listTemplateArr.find("#addList<?=$complexField->getId()?>");
                    addListLink.attr("id",'addList'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    addListLink.data("complexid",currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    addListLink.data("prefixcomplex",currentBlockName+currentBlockCount);
                    var removeListLink = listTemplateArr.find("#remove<?=$complexField->getId()?>");
                    removeListLink.attr("id",'remove'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    removeListLink.data("complexid",currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    removeListLink.data("prefixcomplex",currentBlockName+currentBlockCount);
                    listTemplateArr.find("#echoList<?=$complexField->getId()?>").attr("id",'echoList'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    var countBlock = listTemplateArr.find("#count-<?=$complexField->getId()?>");
                    countBlock.attr("id",'count-'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    countBlock.attr("name",'count-'+currentBlockName+currentBlockCount+'<?=$complexField->getId()?>' + currentBlockCount);
                    listTemplateArr.find('script').html('');
                    <?php
                    //$this->echoComplexScript($field->getId().$counterArray,$complexField,0,"' + complex_fields_counters['".$complexPrefix.$counterArray.$field->getId().$counterArray."'] + '");
                    }
                    if($complexField->getType()!="form-row" && $complexField->getType()!="form-row-end" && $complexField->getType()!="hr" && $complexField->getType()!="header" && $complexField->getType()!="header-text") {
                    ?>
                    listTemplateArr.find("#<?=$complexField->getId()?>").attr("name",currentPrefix+'<?=$complexField->getId()?>' + currentBlockCount);
                    listTemplateArr.find("#<?=$complexField->getId()?>").parent().find('label').attr("for",currentPrefix+'<?=$complexField->getId()?>' + currentBlockCount);
                    listTemplateArr.find("#<?=$complexField->getId()?>").attr("id",currentPrefix+'<?=$complexField->getId()?>' + currentBlockCount);
                    <?php }
                    endif;
                    endforeach;?>
                    $('#echoList' + currentBlockName).append(listTemplateArr);
                    <?php foreach ($field->getComplexFormFields() as $complexField):
                    if($complexField->getType()=="complex-block"):?>
                    addEventsComplexButtons<?=$complexField->getId()?>();
                    <?php endif;?>
                    <?php endforeach;?>
                    $( '#remove' + currentBlockName ).show();
                });
                $( '.removeComplexListButton<?=$field->getId()?>' ).on( "click", function(event) {
                    event.preventDefault();
                    var currentBlockName = $(this).data("complexid");
                    var currentBlockCount = $('#count-'+currentBlockName).attr("value");


                    $('#block'+currentBlockName+currentBlockCount).remove();
                    if(currentBlockCount>0) {
                        currentBlockCount--;
                        $('#count-'+currentBlockName).attr("value",currentBlockCount);
                    }
                    if(currentBlockCount == 0) {
                        $( '#remove' + currentBlockName ).hide();
                    }
                });
            }
            addEventsComplexButtons<?=$field->getId()?>();
        </script>
        <?php
        foreach ($field->getComplexFormFields() as $complexField) {
            if($complexField->getType()=="complex-block") {
                $this->echoComplexScript($complexPrefix.$field->getId(),$complexField);
            }
        }

    }

    private function echoCheckFields() {
        foreach ($this->fields as $field) {
            if($field->isRequired() && $field->getType()!="file"):?>
                if(!checkParam("<?=$field->getId()?>", "<?=$field->getCheckText()?>")) {
                    <?php if($field->getSwitchableRequiredField()!=""):?>
                    if (!document.getElementById("<?=$field->getSwitchableRequiredField()?>").checked) {
                        success = false;
                    }
                    <?php else:?>
                    success = false;
                    <?php endif;?>
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
                if($field->getType()=="password"):?>
                    if(!checkPass("<?=$field->getId()?>", "Пароль должен содержать минимум 8 символов")) {
                    success = false;
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
            complex_fields_counters = [];
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

                <?php if(!empty($this->rulesText)):?>
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
                <?endif;?>

                <?php
                $this->echoCheckFields();
                ?>

                if(!success) {
                    return false;
                }

                <?php if($this->antiSpam):?>
                if (!grecaptcha.getResponse()) {
                    if (param!="en")
                        alert("Пройдите спам проверку");
                    else alert("Spam protection failed");
                    return false;
                }
                <?php endif;?>

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
            function checkPass(attr,text) {
                if (document.getElementById(attr).value.length<8) {
                    $("#"+attr).parent().append("<div class=\"invalid-feedback\">"+text+"</div>");
                    $("#"+attr).addClass('is-invalid');
                    return false;
                } else {
                    $("#"+attr).addClass('is-valid');
                }
                return true;
            }

            function giveParamError(attr,text) {
                $("#"+attr).parent().append("<div class=\"invalid-feedback\">"+text+"</div>");
                $("#"+attr).addClass('is-invalid');
            }

            jQuery( document ).ready(function() {
                <?php foreach ($this->errorFields as $errorField):?>
                giveParamError('<?=$errorField->getId()?>',"<?=$errorField->getText()?>");
                <?php endforeach;?>
            });
        </script>


        <?

        if($this->result)
        {
            echo '<div class="sent-block"><p>'.$this->sendText.'</p></div>';
        }

        if ($_SESSION[lang]=="/en") $param='en'; else $param="";

        ?>

        <form name="feedform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return FeedCheck('<?=@$param?>')">
            <? if($this->result == false)
            {
                $this->echoFields();
                ?>
                <?php if($this->antiSpam):?>
                <div class="form-group mt-3">
                    <label for="spamp"><b><?php if($_SESSION[lang]!="/en") echo "Защита от спама<i class='text-danger'>*</i>"; else echo "Spam protection<i class='text-danger'>*</i>";?></b></label>
                    <div class="g-recaptcha" data-sitekey="6LecaG8UAAAAADsh6X_qAAM9NVd26fZggzJwh-HJ" name="spamp" id="spamp"></div>
                </div>
                <?php endif;?>
                <?php if(!empty($this->rulesText)):?>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="agreament" name="agreament">
                    <label class="form-check-label" for="agreament">
                        <?=$this->rulesText?>
                    </label>
                </div>
            <?php endif;?>

                <?php
                $submitClass = "";
                if(!$this->antiSpam) $submitClass=' mt-3';
                echo "	  <input type='submit' name='Submit' value='".$this->submitText."' class='btn btn-lg btn-primary imemo-button text-uppercase".$submitClass."'>";

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
     * @param FormField $field
     */
    private function fileUpload($field,$i="") {
        $fileUpload = new file_upload();

        $fileUpload->upload_dir = $field->getFileField()->getUploadPath();
        $fileUpload->extensions = $field->getFileField()->getExtensions();
        $fileUpload->language = "ru";
        $fileUpload->rename_file = true;
        $fileUpload->max_length_filename = 300;

        $fileUpload->the_temp_file = $_FILES[$field->getId().$i]['tmp_name'];
        $fileUpload->the_file = $_FILES[$field->getId().$i]['name'];
        $fileUpload->http_error = $_FILES[$field->getId().$i]['error'];
        $fileUpload->replace = "y";
        $fileUpload->do_filename_check = "n"; // use this boolean to check for a valid filename

        $guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        $newName = $field->getFileField()->getFilePrefix().$field->getId().$i.$guid.dechex( microtime(true) * 1000 );

        if ($fileUpload->upload($newName)) {
            if(is_file($field->getFileField()->getUploadPath().$field->getFileField()->getValue())) {
                unlink($field->getFileField()->getUploadPath().$field->getFileField()->getValue());
            }
            $this->uploadedFiles[$field->getId().$i] = $fileUpload->file_copy;
        }
    }

    protected function processPostBuild() {
        global $DB;

        if(isset($_POST['Submit']))
        {
            if($this->antiSpam) {
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $data_captcha['secret'] = '6LecaG8UAAAAAHtU8Ee0sF7_oxV61LBV8U1zHCun';
                $data_captcha['response'] = $_POST["g-recaptcha-response"];
                $options['http']['method'] = "POST";
                $options['http']['content'] = http_build_query($data_captcha);

                $context = stream_context_create($options);
                $verify = file_get_contents($url, false, $context);
                $captcha_success = json_decode($verify);

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
                }
            }
             if ($captcha_success->success==true || !$this->antiSpam) {


                foreach ($this->fields as $field) {

                    if($field->getType()=="complex-block") {
                        for($i=1; $i<=$_POST['count-'.$field->getId()]; $i++) {
                            foreach ($field->getComplexFormFields() as $complexField) {
                                if($complexField->getType()=="file") {
                                    $this->fileUpload($complexField, $i);
                                }
                            }
                        }
                    }

                    if($field->getType()=="file") {
                        $this->fileUpload($field);
                    }
                }


                return true;
            }
        }
        return false;
    }

    /**
     * @param FormField $field
     */
    private function fillComplexField($id, $field, $prefix = "") {
        $complexFieldsArr = array();
        for($i=1; $i<=$_POST['count-'.$prefix.$id]; $i++) {
            $currentField = array();
            foreach ($field->getComplexFormFields() as $complexField) {
                switch ($complexField->getType()) {
                    case "file":
                        $currentFile = $complexField->getValue();
//                                if(empty($this->uploadedFiles[$complexField->getId().$i]) && empty($currentFile)) {
//                                    return $field->getCheckText();
//                                }
                        $currentValues = $complexField->getFileField()->getValue();
                        if(!empty($this->uploadedFiles[$complexField->getId().$i])) {
                            if(is_file($complexField->getFileField()->getUploadPath().$currentValues[$field->getId().$i][$prefix.$complexField->getId()])) {
                                unlink($complexField->getFileField()->getUploadPath().$currentValues[$field->getId().$i][$prefix.$complexField->getId()]);
                            }
                            $currentField[$complexField->getId()] = $this->uploadedFiles[$complexField->getId().$i];
                        } else {
//                                    var_dump($currentValues,$currentValues[$complexField->getId().$i]);
//                                    exit;
                            $currentField[$complexField->getId()] = $currentValues[$field->getId().$i][$prefix.$complexField->getId()];
                        }
                        break;
                    case "form-row":
                        break;
                    case "form-row-end":
                        break;
                    case "hr":
                        break;
                    case "header":
                        break;
                    case "header-text":
                        break;
                    case "complex-block":
                        $currentField[$complexField->getId()] = $this->fillComplexField($complexField->getId().$i,$complexField,$prefix.$id.$i);
                        break;
                    default:
                        $currentField[$complexField->getId()] = $_POST[$prefix.$complexField->getId() . $i];
                }
            }
            $complexFieldsArr[$field->getId().$i] = $currentField;
        }
        foreach ($field->getComplexFormFields() as $complexField) {
            if($complexField->getType()=="file") {
                $currentValues = $complexField->getFileField()->getValue();
                if (count($currentValues)>$_POST['count-'.$prefix.$id]) {
                    for($i=(int)$_POST['count-'.$prefix.$id]+1; $i<=count($currentValues); $i++) {
                        if(is_file($complexField->getFileField()->getUploadPath().$currentValues[$field->getId().$i][$prefix.$complexField->getId()])) {
                            unlink($complexField->getFileField()->getUploadPath().$currentValues[$field->getId().$i][$prefix.$complexField->getId()]);
                        }
                    }
                }
            }
        }

        return $complexFieldsArr;
    }

    protected function fillFieldsForUpload($serializeComplexFields = true) {
        foreach ($this->fields as $field) {
            $required = $field->isRequired();
            $id = $field->getId();
            if(empty($_POST[$id]) && ($required && $field->getSwitchableRequiredField()=="") && $field->getType()!="file") {
                return "Ошибка. Одно из обязательных полей пустое: ".$field->getText();
            }
            if(!empty($id)) {
                if($field->getType()=="complex-block") {
                    $complexFieldsArr = $this->fillComplexField($id,$field);

                    if($serializeComplexFields) {
                        $complexValue = serialize($complexFieldsArr);
                        $this->sendFields[$id] = $complexValue;
                    } else {
                        $this->sendFields[$id] = $complexFieldsArr;
                    }
                } elseif($field->getType()=="file") {
                    $currentFile = $field->getFileField()->getValue();
                    if(empty($this->uploadedFiles[$id]) && empty($currentFile) && $required) {
                        return $field->getCheckText();
                    }
                    if(!empty($this->uploadedFiles[$id])) {
                        $this->sendFields[$id] = $this->uploadedFiles[$id];
                    }
                } elseif($field->getType()=="checkbox") {
                    if(empty($_POST[$id])) {
                        $this->sendFields[$id] = 0;
                    } else {
                        $this->sendFields[$id] = $_POST[$id];
                    }
                } elseif($field->getType()=="select") {
                    $options = $field->getSelectOptions();

                    $mappedOptions = array_map(function ($el) {
                        return $el->getValue();
                    }, $options);

                    if(in_array($_POST[$id],$mappedOptions)) {
                        $this->sendFields[$id] = $_POST[$id];
                    } else {
                        if(!empty($options[0])) {
                            $this->sendFields[$id] = $options[0]->getValue();
                        } else {
                            $this->sendFields[$id] = "";
                        }
                    }
                } else {
                    $this->sendFields[$id] = $_POST[$id];
                }
            }
        }
        return "";
    }

    /**
     * @return mixed
     */
    public function getUploadedDoc()
    {
        return $this->uploadedDoc;
    }

    /**
     * @return mixed
     */
    public function getUploadedPdf()
    {
        return $this->uploadedPdf;
    }

    /**
     * @param OptionField[] $array
     * @return OptionField[]
     */
    public function setSelectedOptionArr($array, $value) {
        $newArray = array();
        foreach ($array as $k=>$item) {
            $selected = false;
            if($item->getValue()==$value) {
                $selected = true;
            }
            $newArray[] = new OptionField($item->getValue(),$item->getTitle(),$selected);
        }
        return $newArray;
    }

}