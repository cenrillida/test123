<?php

namespace AspModule\DocumentBuilders\Templates;

use AspModule\DocumentBuilders\DocumentBuilder;

class ApplyForEntryBuilder extends DocumentBuilder {

    /** @var string */
    private $templateFile="zayavlenie_zachislenie4.pdf";

    public function __construct()
    {
        parent::__construct();


        $templateFields = array();
        $templateFields["fio_r"] = new \DocumentTextField("",2,100,6.2,100,48.3,"fio_r","L","11",array(),"          ");
        $templateFields["citizenship"] = new \DocumentTextField("",1,75,6.2,125,60.6,"citizenship","C", "11");
        $templateFields["birthdate"] = new \DocumentTextField("",1,70,6.2,130,66.8,"birthdate","C","11");
        $templateFields["passport_series"] = new \DocumentTextField("",1,27,6.2,130,73,"passport_series","C","11");
        $templateFields["passport_number"] = new \DocumentTextField("",1,32,6.2,168,73,"passport_number","C","11");
        $templateFields["passport_place"] = new \DocumentTextField("",2,100,6.2,100,79.2,"passport_place","L","11",array(),"               ");
        //$templateFields["passport_date"] = new \DocumentTextField("",1,75,5.3,125,98,"passport_date","C","11");
        $templateFields["passport_address"] = new \DocumentTextField("",3,100,6.2,100,91.6,"passport_address", "L","11", array(), "                                                                           ");
        $templateFields["phone"] = new \DocumentTextField("",1,57,6.2,143,110.1,"phone","C","11");
        $templateFields["email"] = new \DocumentTextField("",1,62.5,6.2,137.5,116.3,"email","C","11");

        $templateFields["field_of_study"] = new \DocumentTextField("",2,83,5,24,174.6,"field_of_study","C");
        $templateFields["field_of_study_profile"] = new \DocumentTextField("",2,89,5,108,174.6,"field_of_study_profile","C");
        $templateFields["will_budget_entry"] = new \DocumentTextField("",1,30,5,24.4,186.0,"will_budget_entry");
        $templateFields["will_pay_entry"] = new \DocumentTextField("",1,30,5,24.4,192.4,"will_pay_entry");
        $templateFields["fio"] = new \DocumentTextField("",1,55,8.8,142,234.1,"fio","C", "12");
        $templateFields["c_year"] = new \DocumentTextField("",1,12,8.8,183.8,257.6,"c_year","L", "12");

        $this->documentPages[] = new \DocumentPage($templateFields);

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}