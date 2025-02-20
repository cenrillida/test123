<?php

namespace AspModule\DocumentBuilders\Templates;

use AspModule\DocumentBuilders\DocumentBuilder;

class ApplicationDocumentBuilder extends DocumentBuilder {

    /** @var string */
    private $templateFile="zayavlenie_template_6.pdf";

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
        $templateFields["field_of_study_profile_id_1"] = new \DocumentTextField("",1,30,6.2,24.8,151.9,"field_of_study_profile_id_1","L","15");
        $templateFields["field_of_study_profile_id_3"] = new \DocumentTextField("",1,30,6.2,24.8,157.8,"field_of_study_profile_id_3","L","15");
        $templateFields["field_of_study_profile_id_4"] = new \DocumentTextField("",1,30,6.2,24.8,163.7,"field_of_study_profile_id_4","L","15");
        $templateFields["will_pay_0"] = new \DocumentTextField("",1,30,5,24.5,171.7,"will_pay_0","L","11");
        $templateFields["will_pay_1"] = new \DocumentTextField("",1,30,5,24.5,177.7,"will_pay_1","L","11");
        $templateFields["prioritet_1"] = new \DocumentTextField("",2,168,5,29,195.7,"prioritet_1","L","11");
        $templateFields["prioritet_2"] = new \DocumentTextField("",2,168,5,29,206.5,"prioritet_2","L","11");
        $templateFields["university_year_end"] = new \DocumentTextField("",1,17,9.8,50,220.9,"university_year_end","C","11");
        $templateFields["university"] = new \DocumentTextField("",2,155,9.8,32,220.9,"university","L","11", array(),"                                             ");
        $templateFields["diplom_series_number"] = new \DocumentTextField("",1,145,5,40,238.9,"diplom_series_number","C","11");
        $templateFields["pension_certificate"] = new \DocumentTextField("",1,44,5,40,248.6,"pension_certificate","C","11");
        $templateFields["individual_awards"] = new \DocumentTextField("",1,81,5.8,106,253.7,"individual_awards","C","11");
        $templateFields["exam"] = new \DocumentTextField("",1,31.5,5,148.5,261.2,"exam","C","11");

        $this->documentPages[] = new \DocumentPage($templateFields);

        $templateFields = array();
        $templateFields["exam_spec_cond_0"] = new \DocumentTextField("",1,30,5,24.5,32.2,"exam_spec_cond_0","L","11");
        $templateFields["exam_spec_cond_1"] = new \DocumentTextField("",1,30,5,72,32.2,"exam_spec_cond_1","L","11");
        $templateFields["exam_spec_cond_discipline"] = new \DocumentTextField("",1,61,6.2,71.9,38,"exam_spec_cond_discipline","L", "11");
        $templateFields["exam_spec_cond_list"] = new \DocumentTextField("",1,103,6.2,71.9,46,"exam_spec_cond_list","L", "11");
        $templateFields["obsh_0"] = new \DocumentTextField("",1,30,5,24.5,64.7,"obsh_0","L", "11");
        $templateFields["obsh_1"] = new \DocumentTextField("",1,30,5,72,64.7,"obsh_1","L", "11");
        $templateFields["send_back_type_1"] = new \DocumentTextField("",1,30,5,24.5,180,"send_back_type_1","L", "11");
        $templateFields["send_back_type_2"] = new \DocumentTextField("",1,30,5,24.5,185,"send_back_type_2","L", "11");


        $this->documentPages[] = new \DocumentPage($templateFields);

        //$this->documentPages[] = new \DocumentPage(array());

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}