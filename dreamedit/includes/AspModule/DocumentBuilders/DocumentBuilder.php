<?php

namespace AspModule\DocumentBuilders;

abstract class DocumentBuilder extends \DocumentTemplater {

    /** @var string */
    protected $templatesPath;
    /** @var \DocumentPage[] */
    protected $documentPages;

    public function __construct()
    {
        parent::__construct();
        $this->templatesPath = __DIR__."/../Documents/Templates/";
    }

    public function addField($text,$field,$namePrefix="") {
        foreach ($this->documentPages as $documentPage) {
            $findArr = $documentPage->getDocumentTextFields();
            if(!empty($findArr[$field])) {
                $findArr[$field]->setText($findArr[$field]->getText().$text);
                $findArr[$field]->setFilePrefix($namePrefix."_".$findArr[$field]->getFilePrefix());
            }
        }
    }

    public function addPhoto($fileName,$field) {
        foreach ($this->documentPages as $documentPage) {
            $findArr = $documentPage->getDocumentPhotoFields();
            if(!empty($findArr[$field])) {
                $findArr[$field]->setFileName($fileName);
            }
        }
    }

    abstract public function getDocument($downloadFileName);
}