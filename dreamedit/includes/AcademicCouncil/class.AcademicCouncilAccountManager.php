<?php

class AcademicCouncilAccountManager {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;

    public function __construct($academicCouncilModule)
    {
        $this->academicCouncilModule = $academicCouncilModule;
    }

    public function setBuilderWithMode($mode) {
        if(empty($mode)) {
            $mode = "";
        }
        switch ($mode) {
            case "questionnaireMailer":
                $this->academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("questionnaireMailer");
                break;
            case "documentCreate":
                $this->academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("documentCreate");
                break;
            case "questionnaire":
                $this->academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("questionnaire");
                break;
            case "questionnaireCreate":
                $this->academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("questionnaireCreate");
                break;
            case "questionnaireEdit":
                $this->academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("questionnaireEdit");
                break;
            case "":
                $this->academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("personal");
                break;
            default:
                echo "Ошибка доступа.";
        }
    }

}