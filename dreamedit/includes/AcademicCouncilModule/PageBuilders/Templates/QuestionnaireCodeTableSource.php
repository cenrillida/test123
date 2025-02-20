<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireCodeTableSource implements PageBuilder {
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

                $members = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireMembersListById($questionnaire->getId());
                //$this->academicCouncilModule->getQuestionnaireService()->getSecretMemberByUserId()


                header("Content-type: application/json");

                $rows = array();

                $counter = 0;
                foreach ($members as $member) {
                    $rows[$counter] = array();
                    $rows[$counter]['fio'] = \Dreamedit::normJsonStr($member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName());
                    $secretMember = $this->academicCouncilModule->getQuestionnaireService()->getSecretMemberByUserId($member->getUserId(),$questionnaire->getId());
                    $code = "";
                    $voteResult = "";
                    if($member->isRegistrationCompleted()) {
                        $voteRegistration = "да";
                    } else {
                        $voteRegistration = "нет";
                    }

                    $notes = "";
                    if(!empty($secretMember)) {
                        $code = $secretMember->getCode();
                        $voteResult = $secretMember->getVoteResult();
                        $notes = $secretMember->getNotes();
                    }
                    $rows[$counter]['code'] = \Dreamedit::normJsonStr($code);
                    $rows[$counter]['vote_registration'] = \Dreamedit::normJsonStr($voteRegistration);
                    $rows[$counter]['meeting_participation'] = \Dreamedit::normJsonStr($member->getMeetingParticipation());
                    $rows[$counter]['vote_result'] = \Dreamedit::normJsonStr($voteResult);
                    $rows[$counter]['notes'] = \Dreamedit::normJsonStr($notes);
                    $counter++;
                }

                echo json_encode($rows);
            }
        } else {
            echo "Ошибка доступа";
        }
    }

}