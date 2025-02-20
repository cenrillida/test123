<?php

namespace AspModule\DocumentBuilders\Templates;

use AspModule\DocumentBuilders\DocumentBuilder;

class PersonalSheetBuilder extends DocumentBuilder {

    /** @var string */
    private $templateFile="personal_data_sheet_on_personnel_tracking2.pdf";

    public function __construct()
    {
        parent::__construct();


        $templateFields = array();
        $templateFields["lastname"] = new \DocumentTextField("",1,125,5,32,35,"lastname", "C");
        $templateFields["firstname"] = new \DocumentTextField("",1,55,5,17.2,42,"firstname", "C");
        $templateFields["thirdname"] = new \DocumentTextField("",1,70,5,88.2,42,"thirdname", "C");
        $templateFields["gender"] = new \DocumentTextField("",1,30,5,22,49.5,"gender", "C");
        $templateFields["birthdate"] = new \DocumentTextField("",1,53,5,105.3,49.5,"birthdate", "C");
        $templateFields["birthplace"] = new \DocumentTextField("",3,150,9.8,10,54.2,"birthplace","L",13,array(2 => 7.3),"                               ");
        $templateFields["nationality"] = new \DocumentTextField("",1,155,7.2,45,78.5,"nationality", "C");
        $templateFields["education"] = new \DocumentTextField("",1,161,7.2,39,85.9,"education", "C");

        $universityParamsHeight = array(1 => 7.5, 2 => 3.5, 3 => 2.3);

        for ($i=1; $i<=12; $i++) {
            $coordinate = 124 + (($i - 1) * 7.5);
            $universityNamePlace = new \DocumentTextField("", 3, 43, 2.3, 9, $coordinate, "university_name_place".$i, "C", 7);
            $universityNamePlace->setLinesParam($universityParamsHeight);
            $templateFields["university_name_place".$i] = $universityNamePlace;
            $templateFields["university_faculty".$i] = new \DocumentTextField("", 3, 22, 2.3, 51.5, $coordinate, "university_faculty".$i, "C", 7);
            $templateFields["university_faculty".$i]->setLinesParam($universityParamsHeight);
            $templateFields["university_form".$i] = new \DocumentTextField("", 1, 22, 7.5, 73.5, $coordinate, "university_form".$i, "C", 7);
            $templateFields["university_year_in".$i] = new \DocumentTextField("", 1, 20, 7.5, 95.5, $coordinate, "university_year_in".$i, "C", 7);
            $templateFields["university_year_out".$i] = new \DocumentTextField("", 1, 20, 7.5, 114.5, $coordinate, "university_year_out".$i, "C", 7);
            $templateFields["university_level_out".$i] = new \DocumentTextField("", 1, 23, 7.5, 133.5, $coordinate, "university_level_out".$i, "C", 7);
            $templateFields["university_special_number".$i] = new \DocumentTextField("", 3, 45, 2.3, 155.8, $coordinate, "university_special_number".$i, "C", 7);
            $templateFields["university_special_number".$i]->setLinesParam($universityParamsHeight);
        }

        $templateFields["languages"] = new \DocumentTextField("",2,190,7.3,9,217.5,"languages","L","13",array(),"                                                                      ");
        $templateFields["academic_rank_degree"] = new \DocumentTextField("",1,129,7.3,70,237,"", "C");
        $templateFields["science_work_and_invents"] = new \DocumentTextField("",5,190,7.3,9,244.3,"","L","13",array(),"                                                                          ");

        $templatePhotoFields["photo"] = new \DocumentPhotoField("","30","40","170","35");

        $this->documentPages[] = new \DocumentPage($templateFields,$templatePhotoFields);

        $templateFields = array();

        $workParamsHeight = array(1 => 6.53, 2 => 3.23);

        for ($i=1; $i<=34; $i++) {
            $counter=$i;
            $coordinate = 61 + (($i - 1) * 6.53);
            $templateFields["work_in".$counter] = new \DocumentTextField("", 1, 28,6.53,8, $coordinate, "", "C", 7);
            $templateFields["work_out".$counter] = new \DocumentTextField("", 1, 31,6.53,36, $coordinate, "", "C", 7);
            $templateFields["work_position".$counter] = new \DocumentTextField("", 2, 84,3.23,67, $coordinate, "", "C", 7);
            $templateFields["work_position".$counter]->setLinesParam($workParamsHeight);
            $templateFields["work_place".$counter] = new \DocumentTextField("", 2, 53,3.23,149.5, $coordinate, "", "C", 7);
            $templateFields["work_place".$counter]->setLinesParam($workParamsHeight);
        }

        $this->documentPages[] = new \DocumentPage($templateFields);

        $templateFields = array();

        for ($i=1; $i<=18; $i++) {
            $counter++;
            $coordinate = 31.7 + (($i - 1) * 6.53);
            $templateFields["work_in".$counter] = new \DocumentTextField("", 1, 28,6.53,8, $coordinate, "", "C", 7);
            $templateFields["work_out".$counter] = new \DocumentTextField("", 1, 31,6.53,36, $coordinate, "", "C", 7);
            $templateFields["work_position".$counter] = new \DocumentTextField("", 2, 84,3.23,67, $coordinate, "", "C", 7);
            $templateFields["work_position".$counter]->setLinesParam($workParamsHeight);
            $templateFields["work_place".$counter] = new \DocumentTextField("", 2, 53,3.23,149.5, $coordinate, "", "C", 7);
            $templateFields["work_place".$counter]->setLinesParam($workParamsHeight);
        }


        for ($i=1; $i<=16; $i++) {
            $coordinate = 176.5 + (($i - 1) * 6.53);
            $templateFields["abroad_in".$i] = new \DocumentTextField("", 1, 28,6.53,8, $coordinate, "", "C", 7);
            $templateFields["abroad_out".$i] = new \DocumentTextField("", 1, 31,6.53,36, $coordinate, "", "C", 7);
            $templateFields["abroad_country".$i] = new \DocumentTextField("", 1, 64,6.53,67, $coordinate, "", "C", 7);
            $templateFields["abroad_purpose".$i] = new \DocumentTextField("", 1, 72,6.53,130.5, $coordinate, "", "C", 7);
        }

        $this->documentPages[] = new \DocumentPage($templateFields);

        $templateFields = array();
        $templateFields["gov_awards"] = new \DocumentTextField("",11,190,9.5,9,15.5,"gov_awards","L",13,array(2 => 7.3),"                                                                          ");
        $templateFields["army_rank"] = new \DocumentTextField("",2,190,7.3,9,98,"education", "L",13,array(),"                                                                                              ");
        $templateFields["army_structure"] = new \DocumentTextField("",1,104,7.3,23,112.5,"education", "C");
        $templateFields["army_type"] = new \DocumentTextField("",1,54,7.3,145,112.5,"education", "C");
        $templateFields["relatives"] = new \DocumentTextField("",6,190,14.9,9,119.7,"education", "L", "13", array(2=>7.3),"                                                                                                    ");
        $templateFields["home_address_phone"] = new \DocumentTextField("",2,190,7.3,9,171.2,"education", "L",13,array(),"                                                                     ");
        $templateFields["passport_series"] = new \DocumentTextField("",1,73,7.3,35,185.7,"education", "C");
        $templateFields["passport_number"] = new \DocumentTextField("",1,73,7.3,35,196.7,"education", "C");
        $templateFields["passport_place"] = new \DocumentTextField("",1,163,7.3,35,207.7,"education", "C");

        $this->documentPages[] = new \DocumentPage($templateFields);

    }

    public function getDocument($downloadFileName)
    {
        $this->fillFileWithTemplate($this->templatesPath.$this->templateFile,$this->documentPages,$downloadFileName.".pdf");
    }

}