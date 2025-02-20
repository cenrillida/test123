<?php

namespace AcademicCouncilModule\Services;

use AcademicCouncilModule\AcademicCouncilModule;

class AccountService {

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
        if($this->academicCouncilModule->getAuthorizationService()->checkLogin()) {
            switch ($mode) {
                case "":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("personal");
                    break;
                case "login":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("login");
                    break;
                case "questionnaireCreate":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireCreate");
                    break;
                case "questionnaireEdit":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireEdit");
                    break;
                case "questionnaire":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaire");
                    break;
                case "questionnaireResultList":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireResultList");
                    break;
                case "questionnaireParticipateList":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireParticipateList");
                    break;
                case "questionnaireMailer":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireMailer");
                    break;
                case "questionnaireProtocol":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireProtocol");
                    break;
                case "questionnaireCodeTable":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireCodeTable");
                    break;
                case "questionnaireCodeTableSource":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaireCodeTableSource");
                    break;
                default:
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("error");
            }
        } else {
            switch ($mode) {
                case "":
                case "login":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("login");
                    break;
                case "questionnaire":
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaire");
                    break;
                default:
                    $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("error");
            }
        }
    }

}