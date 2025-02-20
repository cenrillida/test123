<?php

namespace AspModule\DocumentBuilders\Templates;

use AspModule\DocumentBuilders\DocumentBuilder;

class ApplicationDissertationDocumentBuilder extends DocumentBuilder {

    /** @var string */
    private $templateFile="zayavlenie_dissertation_template3.pdf";

    public function __construct()
    {
        parent::__construct();


        $templateFields = array();
        $templateFields["fio_r"] = new \DocumentTextField("",2,100,6.2,100,50.5,"fio_r","L","12",array(),"          ");
        $templateFields["citizenship"] = new \DocumentTextField("",1,77,6.2,123,62.9,"citizenship","C", "12");
        $templateFields["birthdate"] = new \DocumentTextField("",1,72,6.2,128,69.1,"birthdate","C", "12");
        $templateFields["passport_series"] = new \DocumentTextField("",1,31,6.2,128,75.3,"passport_series","C","12");
        $templateFields["passport_number"] = new \DocumentTextField("",1,34,6.2,166,75.3,"passport_number","C","12");
        $templateFields["passport_place"] = new \DocumentTextField("",2,100,6.2,100,81.5,"passport_place","L","12",array(),"              ");
        //$templateFields["passport_date"] = new \DocumentTextField("",1,69,6.2,123,93.9,"passport_date","C","12");
        $templateFields["passport_address"] = new \DocumentTextField("",3,100,6.2,100,93.9,"passport_address","L","12", array(), "                                                                     ");
        $templateFields["phone"] = new \DocumentTextField("",1,60,6.2,140,112.4,"phone","C","12");
        $templateFields["email"] = new \DocumentTextField("",1,65,6.2,135,118.5,"email","C", "12");
        $templateFields["field_of_study_profile_1"] = new \DocumentTextField("",1,30,5,24.9,157.9,"field_of_study_profile_1");
        $templateFields["field_of_study_profile_3"] = new \DocumentTextField("",1,30,5,24.9,163.9,"field_of_study_profile_3");
        $templateFields["field_of_study_profile_4"] = new \DocumentTextField("",1,30,5,24.9,169.7,"field_of_study_profile_4");
        $templateFields["university_year_end"] = new \DocumentTextField("",1,18,5,52,182.8,"university_year_end","C");
        $templateFields["university"] = new \DocumentTextField("",2,166,8.2,31,181.1,"university","L","13",array(),"                                           ");
        $templateFields["diplom_series_number"] = new \DocumentTextField("",1,156,5,42,196.8,"diplom_series_number","L");
        $templateFields["individual_awards"] = new \DocumentTextField("",1,85,5.8,112,206.7,"individual_awards","C");
        $templateFields["inform_type_1"] = new \DocumentTextField("",1,30,5,25.2,225.4,"inform_type_1","L");
        $templateFields["inform_type_2"] = new \DocumentTextField("",1,30,5,125,225.4,"inform_type_2","L");

        $this->documentPages[] = new \DocumentPage($templateFields);

        $templateFields = array();
        $templateFields["dissertation_theme"] = new \DocumentTextField("",4,172,6.7,24.6,20.3,"dissertation_theme","L","13",array(2 => 5.4),"                                                             ");
        $templateFields["dissertation_supervisor"] = new \DocumentTextField("",1,128,8.8,71,42.4,"dissertation_supervisor","C");
        $templateFields["dissertation_department"] = new \DocumentTextField("",2,172,6.3,24.6,49.9,"dissertation_department","L","13",array(),"                                          ");


        $this->documentPages[] = new \DocumentPage($templateFields);

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}