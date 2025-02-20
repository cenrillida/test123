<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireCodeTable implements PageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()) {

            $questionnaire = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireById($_GET['id']);
            if(!empty($questionnaire)) {
                $dhtmlBuilder = new \DhtmlxBuilder("/index.php?page_id=".$_REQUEST['page_id']."&mode=questionnaireCodeTableSource&id={$questionnaire->getId()}","/index.php?page_id=".$_REQUEST['page_id']."&mode=questionnaireCodeTableUpdate");

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText("<b>Таблица кодов</b>","16"));
                $header->registerField(new \DhtmlxText("ФИО"));
                $header->registerField(new \DhtmlxContent("inputFilter"));
                $column = new \DhtmlxColumn("","fio",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Код"));
                $header->registerField(new \DhtmlxContent("inputFilter"));
                $column = new \DhtmlxColumn("","code",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Зарегистрировался в голосовании"));
                $header->registerField(new \DhtmlxContent("selectFilter"));
                $column = new \DhtmlxColumn("","vote_registration",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Результат"));
                $header->registerField(new \DhtmlxContent("selectFilter"));
                $column = new \DhtmlxColumn("","vote_result",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Примечания"));
                $header->registerField(new \DhtmlxContent("inputFilter"));
                $column = new \DhtmlxColumn("","notes",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $dhtmlBuilder->build();
            }


        } else {
            echo "Ошибка доступа";
        }
    }

}