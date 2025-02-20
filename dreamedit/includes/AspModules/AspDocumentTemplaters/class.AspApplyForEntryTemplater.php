<?php

class AspApplyForEntryTemplater extends AspDocumentTemplater {

    /** @var string */
    private $templateFile="zayavlenie_zachislenie2.pdf";

    public function __construct()
    {
        parent::__construct();


        $templateFields = array();
        $templateFields["fio_r"] = new DocumentTextField("",2,95,8.8,100,55.8,"fio_r","L","13",array(),"    ");
        $templateFields["citizenship"] = new DocumentTextField("",1,75,8.8,125,70,"citizenship","C");
        $templateFields["birthdate"] = new DocumentTextField("",1,70,8.8,130,75.1,"birthdate","C");
        $templateFields["passport_series"] = new DocumentTextField("",1,20,8.8,129,80.5,"passport_series","C");
        $templateFields["passport_number"] = new DocumentTextField("",1,41,8.8,155,80.5,"passport_number","C");
        $templateFields["passport_place"] = new DocumentTextField("",2,97,5.3,100,87.5,"passport_place","L","13",array(),"           ");
        $templateFields["passport_date"] = new DocumentTextField("",1,75,5.3,125,98,"passport_date","C");
        $templateFields["passport_address"] = new DocumentTextField("",2,98,6,100,108.2,"passport_address");
        $templateFields["phone"] = new DocumentTextField("",1,55,6,142,119.2,"phone","C");

        $templateFields["field_of_study"] = new DocumentTextField("",3,83,5,24,177.9,"field_of_study","C");
        $templateFields["field_of_study_profile"] = new DocumentTextField("",3,89,5,108,177.9,"field_of_study_profile","C");
        $templateFields["will_budget_entry"] = new DocumentTextField("",1,30,5,24.3,194.8,"will_budget_entry");
        $templateFields["will_pay_entry"] = new DocumentTextField("",1,30,5,24.3,201.1,"will_pay_entry");
        $templateFields["fio"] = new DocumentTextField("",1,55,8.8,142,242.7,"fio","C");

        $this->documentPages[] = new DocumentPage($templateFields);

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}