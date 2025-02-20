<?php

namespace AspModule\DocumentBuilders\Templates;

use AspModule\DocumentBuilders\DocumentBuilder;

class ConsentDataProcessingDocumentBuilder extends DocumentBuilder {

    /** @var string */
    private $templateFile="personal_data_processing_consent2.pdf";

    public function __construct()
    {
        parent::__construct();


        $templateFields = array();
        $templateFields["fio"] = new \DocumentTextField("",2,180,4.8,20,35.3,"fio","L","12",array(),"                ");
        $templateFields["passport_address"] = new \DocumentTextField("",2,180,4.9,20,49,"passport_address","L", "12",array(),"                                                             ");
        $templateFields["passport"] = new \DocumentTextField("",4,180,4.85,20,58.8,"passport","L","12", array(),"                                                                                                  ");
        $templateFields["study"] = new \DocumentTextField("",1,15,4.9,18,117,"study","L","12");
        $templateFields["dissertation"] = new \DocumentTextField("",1,15,4.9,18,132,"dissertation","L","12");
        //$templateFields["exam"] = new \DocumentTextField("",1,15,4.9,18,150,"exam","L","12");

        $this->documentPages[] = new \DocumentPage($templateFields);

        $this->documentPages[] = new \DocumentPage(array());

        $this->documentPages[] = new \DocumentPage(array());

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}