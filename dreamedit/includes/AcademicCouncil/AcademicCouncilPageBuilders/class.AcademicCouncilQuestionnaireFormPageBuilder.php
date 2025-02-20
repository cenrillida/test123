<?php

class AcademicCouncilQuestionnaireFormPageBuilder implements AcademicCouncilPageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build()
    {
        global $DB,$_CONFIG,$site_templater;



        $member = $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->getMemberByCode($_GET['code'],$_GET['questionnaire_id']);
        $exist = false;
        if(!empty($member)) {
            if($this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->isActive($_GET['questionnaire_id'])) {
                $exist = true;
                $questionnaire = $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->getQuestionnaireById($_GET['questionnaire_id']);

                if ($_SESSION[lang] != "/en") {
                    $formBuilder = new AcademicCouncilQuestionnaireFormBuilder("Данные успешно отправлены.", "", "", "Отправить",false);

                    $formBuilder->registerField(new FormField("", "header", false, $questionnaire->getName()));

                    $meetingParticipateSelectArr = array(new OptionField("принял участие","Принял участие"),new OptionField("не принял участие","Не принял участие"));
                    $voteResultSelectArr = array(
                        new OptionField("да","Да"),
                        new OptionField("нет","Нет"),
                        new OptionField("воздержался","Воздержался")
                    );

                    $fioField = new FormField("fio", "text", true, "ФИО", "Не введено ФИО","",false,"",$member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName());
                    $fioField->setReadOnly(true);
                    $formBuilder->registerField($fioField);
                    $formBuilder->registerField(new FormField("meeting_participation", "select", true, "Отметка об участии в заседании Ученого совета", "","",false,"",$member->getMeetingParticipation(),$meetingParticipateSelectArr));
                    $formBuilder->registerField(new FormField("vote_result", "select", true, "Результаты голосования", "","",false,"",$member->getVoteResult(),$voteResultSelectArr));
                    $formBuilder->registerField(new FormField("notes", "textarea", false, "Примечания (замечания, возражения, особое мнение)", "","",false,"",$member->getNotes(),array(),array(),"",array(),10));
                    $formBuilder->registerField(new FormField("code", "hidden", true, "", "","",false,"",$_GET['code']));
                    $formBuilder->registerField(new FormField("questionnaire_id", "hidden", true, "", "","",false,"",$_GET['questionnaire_id']));
                    $posError = $formBuilder->processPostBuild();

                }
            }
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>

        <?php

        if(!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?=$posError?>
            </div>
            <?php
        }
        if(!empty($member)) {
            if($exist) {
                $formBuilder->build();
            } else {
                echo "Опрос закончился.";
            }
        } else {
            echo "Опрос не найден.";
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}