<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireCreateFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireEditFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireRegistrationFormBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class Questionnaire implements PageBuilder {
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

        $questionnaire = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireById($_GET['questionnaire_id']);
        $exist = false;
        if(!empty($questionnaire)) {
            $alreadyDone = false;
            $secretRegistration = false;
            if($questionnaire->isSecret()) {
                if(!empty($_GET['code'])) {
                    $secretRegistration = true;
                    $member = $this->academicCouncilModule->getQuestionnaireService()->getMemberByCode($_GET['code'],$questionnaire->getId());
                    if($member->getMeetingParticipation()!="" || $member->isRegistrationCompleted()) {
                        $alreadyDone = true;
                    }
                }
                elseif(!empty($_GET['secret_code'])) {
                    $secretMember = $this->academicCouncilModule->getQuestionnaireService()->getSecretMemberByCode($_GET['secret_code'],$questionnaire->getId());
                    if($secretMember->getMeetingParticipation()!="" || $secretMember->getVoteResult()!="") {
                        $alreadyDone = true;
                    }
                }
            } else {
                $member = $this->academicCouncilModule->getQuestionnaireService()->getMemberByCode($_GET['code'],$questionnaire->getId());
                if($member->getMeetingParticipation()!="" || $member->getVoteResult()!="") {
                    $alreadyDone = true;
                }
            }

            if((!empty($member) || !empty($secretMember)) && !$alreadyDone) {
                if($this->academicCouncilModule->getQuestionnaireService()->isActive($questionnaire->getId())) {
                    $exist = true;

                    if ($_SESSION['lang'] != "/en") {
                        if($secretRegistration) {
                            $formBuilder = new QuestionnaireRegistrationFormBuilder("����������� ���������.", "", "", "������������������",false);
                        } else {
                            $formBuilder = new QuestionnaireFormBuilder("������ ������� ����������.", "", "", "���������",false);
                        }

                        $formBuilder->registerField(new \FormField("", "header", false, $questionnaire->getName()));

                        if($secretRegistration) {
                            $formBuilder->registerField(new \FormField("", "header", false, "����������� � �����������"));
                        }

                        $meetingParticipateSelectArr = array(
                            new \OptionField("������ �������","������ �������"),
                            new \OptionField("�� ������ �������","�� ������ �������")
                        );
                        $voteResultSelectArr = array(
                            new \OptionField("��","��"),
                            new \OptionField("���","���"),
                            new \OptionField("�����������","�����������")
                        );

                        $meetingParticipation = "";
                        $voteResult = "";
                        $notes = "";
                        if(!empty($member)) {
                            $fioField = new \FormField("fio", "text", true, "���", "�� ������� ���","",false,"",$member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName());
                            $fioField->setReadOnly(true);
                            $formBuilder->registerField($fioField);

                            $meetingParticipation = $member->getMeetingParticipation();
                            $voteResult = $member->getVoteResult();
                            $notes = $member->getNotes();

                            if($questionnaire->isSecret()) {
                                //if($secretRegistration)
                                    //$formBuilder->registerField(new \FormField("meeting_participation", "select", true, "������� �� ������� � ����������� ������� ������", "","",false,"",$meetingParticipation,$meetingParticipateSelectArr));
                            } else {
                                $formBuilder->registerField(new \FormField("meeting_participation", "select", true, "������� �� ������� � ��������� ������� ������", "", "", false, "", $meetingParticipation, $meetingParticipateSelectArr));
                                $formBuilder->registerField(new \FormField("vote_result", "select", true, "���������� �����������", "", "", false, "", $voteResult, $voteResultSelectArr));
                                $formBuilder->registerField(new \FormField("notes", "textarea", false, "���������� (���������, ����������, ������ ������)", "", "", false, "", $notes, array(), array(), "", array(), 10));
                            }
                            $formBuilder->registerField(new \FormField("code", "hidden", true, "", "", "", false, "", $_GET['code']));
                        }
                        if(!empty($secretMember)) {
                            $voteResult = $secretMember->getVoteResult();
                            $notes = $secretMember->getNotes();

                            $formBuilder->registerField(new \FormField("vote_result", "select", true, "���������� �����������", "","",false,"",$voteResult,$voteResultSelectArr));
                            $formBuilder->registerField(new \FormField("notes", "textarea", false, "���������� (���������, ����������, ������ ������)", "","",false,"",$notes,array(),array(),"",array(),10));
                            $formBuilder->registerField(new \FormField("code", "hidden", true, "", "","",false,"",$_GET['secret_code']));

                        }

                        $formBuilder->registerField(new \FormField("questionnaire_id", "hidden", true, "", "","",false,"",$questionnaire->getId()));
                        $posError = $formBuilder->processPostBuild();

                        if($posError == "redirectToVote" && !empty($member)) {
                            $secretMember = $this->academicCouncilModule->getQuestionnaireService()->getSecretMemberByUserId($member->getUserId(),$questionnaire->getId());

                            $linkRedirect = "https://www.imemo.ru/index.php?page_id={$_REQUEST['page_id']}&secret_code={$secretMember->getCode()}&questionnaire_id={$questionnaire->getId()}";

//                            \Dreamedit::sendHeaderByCode(301);
//                            \Dreamedit::sendLocationHeader($linkRedirect);
//                            exit;
                        }

                    }
                }
            }
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>

        <?php

        if($posError=="redirectToVote" && !empty($linkRedirect)) {
            ?>
            ��������������� �� ����������� ����� 3 �������. ��� ��������� �� <a href="<?=$linkRedirect?>">������</a>
            <meta http-equiv=refresh content="3; url=<?=$linkRedirect?>">
            <?php
        }
        elseif(!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?=$posError?>
            </div>
            <?php
        }
        if(!empty($member) || !empty($questionnaire)) {
            if($alreadyDone) {
                if($secretRegistration) {
                    echo "�� ��� ������������������. ������ ��� ����������� ���� ���������� �� �����.";
                } else {
                    echo "�� ��� ������������";
                }
            } else {
                if($exist) {
                    $formBuilder->build();
                } else {
                    echo "����� ���������� ��� ��� �� �������.";
                }
            }
        } else {
            echo "����� �� ������.";
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}