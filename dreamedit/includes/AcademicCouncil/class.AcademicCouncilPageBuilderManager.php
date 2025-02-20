<?php

class AcademicCouncilPageBuilderManager {

    /** @var AcademicCouncilPageBuilder[] */
    private $pageList;
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new AcademicCouncilLoginFormPageBuilder($this->academicCouncilModule,$this->pages),
            "questionnaireCreate" => new AcademicCouncilQuestionnaireCreateFormPageBuilder($this->academicCouncilModule,$this->pages),
            "questionnaireEdit" => new AcademicCouncilQuestionnaireEditFormPageBuilder($this->academicCouncilModule,$this->pages),
            "questionnaire" => new AcademicCouncilQuestionnaireFormPageBuilder($this->academicCouncilModule,$this->pages),
            "personal" => new AcademicCouncilPersonalPageBuilder($this->academicCouncilModule,$this->pages),
            "documentCreate" => new AcademicCouncilDocumentCreateFormPageBuilder($this->academicCouncilModule,$this->pages),
            "questionnaireMailer" => new AcademicCouncilQuestionnaireMailerFormPageBuilder($this->academicCouncilModule,$this->pages)
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->academicCouncilModule->setAcademicCouncilPageBuilder($this->pageList[$name]);
        }
    }

}