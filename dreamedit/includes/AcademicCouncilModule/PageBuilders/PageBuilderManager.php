<?php

namespace AcademicCouncilModule\PageBuilders;

use AcademicCouncilModule\AcademicCouncilModule;

use AcademicCouncilModule\PageBuilders\Templates\Error;
use AcademicCouncilModule\PageBuilders\Templates\LoginForm;
use AcademicCouncilModule\PageBuilders\Templates\Personal;
use AcademicCouncilModule\PageBuilders\Templates\Questionnaire;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireCodeTable;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireCodeTableSource;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireCreate;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireEdit;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireMailer;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireParticipateList;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireProtocolWord;
use AcademicCouncilModule\PageBuilders\Templates\QuestionnaireResultList;
use AcademicCouncilModule\PageBuilders\Templates\Top;

class PageBuilderManager {

    /** @var PageBuilder[] */
    private $pageList;
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new LoginForm($this->academicCouncilModule,$this->pages),
            "personal" => new Personal($this->academicCouncilModule,$this->pages),
            "questionnaireCreate" => new QuestionnaireCreate($this->academicCouncilModule, $this->pages),
            "top" => new Top($this->academicCouncilModule, $this->pages),
            "questionnaireEdit" => new QuestionnaireEdit($this->academicCouncilModule,$this->pages),
            "questionnaire" => new Questionnaire($this->academicCouncilModule,$this->pages),
            "questionnaireResultList" => new QuestionnaireResultList($this->academicCouncilModule,$this->pages),
            "questionnaireParticipateList" => new QuestionnaireParticipateList($this->academicCouncilModule,$this->pages),
            "questionnaireMailer" => new QuestionnaireMailer($this->academicCouncilModule,$this->pages),
            "error" => new Error($this->academicCouncilModule, $this->pages),
            "questionnaireProtocol" => new QuestionnaireProtocolWord($this->academicCouncilModule,$this->pages),
            "questionnaireCodeTable" => new QuestionnaireCodeTable($this->academicCouncilModule,$this->pages),
            "questionnaireCodeTableSource" => new QuestionnaireCodeTableSource($this->academicCouncilModule,$this->pages)
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->academicCouncilModule->setPageBuilder($this->pageList[$name]);
        }
    }

}