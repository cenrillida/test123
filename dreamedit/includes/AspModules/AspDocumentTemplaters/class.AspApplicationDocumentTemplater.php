<?php

class AspApplicationDocumentTemplater extends AspDocumentTemplater {

    /** @var string */
    private $templateFile="zayavlenie_template_4.pdf";

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
        $templateFields["email"] = new DocumentTextField("",1,80,6,117,124.7,"email","C");
        $templateFields["field_of_study"] = new DocumentTextField("",3,83,5,24,175.7,"field_of_study","C");
        $templateFields["field_of_study_profile"] = new DocumentTextField("",3,89,5,108,175.7,"field_of_study_profile","C");
        $templateFields["will_pay_0"] = new DocumentTextField("",1,30,5,24.3,192.4,"will_pay_0");
        $templateFields["will_pay_1"] = new DocumentTextField("",1,30,5,24.3,198.7,"will_pay_1");
        $templateFields["prioritet_1"] = new DocumentTextField("",1,168,5,29,223.3,"prioritet_1","C");
        $templateFields["prioritet_2"] = new DocumentTextField("",1,168,5,29,235.8,"prioritet_2","C");
        $templateFields["university_year_end"] = new DocumentTextField("",1,18,5,52,248.5,"university_year_end","C");
        $templateFields["university"] = new DocumentTextField("",1,119,5,80,248.5,"university","C");
        $templateFields["diplom_series_number"] = new DocumentTextField("",1,153,5,45,259.1,"diplom_series_number","C");

        $this->documentPages[] = new DocumentPage($templateFields);

        $templateFields = array();
        $templateFields["exam"] = new DocumentTextField("",1,28,8.8,158,18.7,"exam","C");
        $templateFields["exam_spec_cond_0"] = new DocumentTextField("",1,30,8.8,24.3,55.6,"exam_spec_cond_0");
        $templateFields["exam_spec_cond_1"] = new DocumentTextField("",1,30,8.8,71.9,56.8,"exam_spec_cond_1");
        $templateFields["exam_spec_cond_discipline"] = new DocumentTextField("",1,125,8.8,71.9,63.1,"exam_spec_cond_discipline","L");
        $templateFields["exam_spec_cond_list"] = new DocumentTextField("",1,125,8.8,71.9,71.8,"exam_spec_cond_list","L");
        $templateFields["obsh_1"] = new DocumentTextField("",1,30,8.8,25.6,101.3,"obsh_1");
        $templateFields["obsh_0"] = new DocumentTextField("",1,30,8.8,57.3,101.3,"obsh_0");
        $templateFields["individual_awards"] = new DocumentTextField("",20,170,5.8,24,130,"individual_awards");

        $this->documentPages[] = new DocumentPage($templateFields);

        $this->documentPages[] = new DocumentPage(array());

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}