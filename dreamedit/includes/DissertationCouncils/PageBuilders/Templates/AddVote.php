<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\AddVoteFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class AddVote implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * AddVote constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->dissertationCouncils->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin()) {

            $sendText = "Голосование успешно добавлено.";
            $buttonText = "Добавить";
            $date = "";
            $title = "";
            $dissertationCouncilName = "";
            $attended = 0;
            $withTechnicalProblem = 0;
            $dissertationProfile = "";
            $chairmanName = "";
            $chairmanPosition = "";
            $secretaryName = "";
            $secretaryPosition = "";
            $doctors = 0;
            $currentParticipants = array();
            if(!empty($_GET['id'])) {
                $vote = $this->dissertationCouncils->getVoteService()->getVoteById($_GET['id']);
                if(!empty($vote)) {
                    $date = $vote->getDate();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                    $currentParticipants = $vote->getParticipants();
                    $title = $vote->getTitle();
                    $dissertationCouncilName = $vote->getDissertationCouncilName();
                    $attended = $vote->getAttended();
                    $withTechnicalProblem = $vote->getWithTechnicalProblem();
                    $dissertationProfile = $vote->getDissertationProfile();
                    $chairmanName = $vote->getChairmanName();
                    $chairmanPosition = $vote->getChairmanPosition();
                    $secretaryName = $vote->getSecretaryName();
                    $secretaryPosition = $vote->getSecretaryPosition();
                    $doctors = $vote->getDoctors();
                } else {
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                    $this->dissertationCouncils->getPageBuilder()->build(array('error' => 'Голосование не найдено'));
                    exit;
                }
            }

            $formBuilder = new AddVoteFormBuilder($sendText, "", "", $buttonText, false);

            $formBuilder->registerField(new \FormField("title", "text", true, "Название (Вопрос)", "Не введенно название","",false,"",$title));
            $formBuilder->registerField(new \FormField("date", "date", true, "Дата", "Не введена дата","",false,"",$date));
            $formBuilder->registerField(new \FormField("attended", "number", false, "Присутствовало на заседании (количество)", "Не введенно название","0",false,"",$attended));
            $formBuilder->registerField(new \FormField("doctors", "number", false, "Присутствовало докторов наук по профилю рассматриваемой диссертации (количество)", "Не введенно название","0",false,"",$doctors));
            $formBuilder->registerField(new \FormField("with_technical_problem", "number", false, "По техническим причинам не проголосовало (количество)", "Не введенно название","0",false,"",$withTechnicalProblem));
            $formBuilder->registerField(new \FormField("dissertation_profile", "text", false, "Профиль диссертации", "Не введенно название","",false,"",$dissertationProfile));
            $formBuilder->registerField(new \FormField("chairman_name", "text", false, "ФИО председателя диссертационного совета", "Не введенно название","",false,"",$chairmanName));
            $formBuilder->registerField(new \FormField("chairman_position", "text", false, "Должность председателя диссертационного совета", "Не введенно название","",false,"",$chairmanPosition));
            $formBuilder->registerField(new \FormField("secretary_name", "text", false, "ФИО секретаря диссертационного совета", "Не введенно название","",false,"",$secretaryName));
            $formBuilder->registerField(new \FormField("secretary_position", "text", false, "Должность секретаря диссертационного совета", "Не введенно название","",false,"",$secretaryPosition));

            $participants = $this->dissertationCouncils->getUserService()->getAllUsers("lastname","ASC");

            $dissertationCouncil = $this->dissertationCouncils->getDissertationCouncilService()->getDissertationCouncilById($_GET['dissertation_council_id']);

            $dissertationCouncilTeam = array();
            if(!empty($dissertationCouncil)) {
                $dissertationCouncilTeam = $dissertationCouncil->getTeam();
                $dissertationCouncilName = $dissertationCouncil->getName();
            }

            $formBuilder->registerField(new \FormField("dissertation_council_name", "text", false, "Наименование диссертационного совета", "Не введенно название","",false,"",$dissertationCouncilName));

            $formBuilder->registerField(new \FormField("", "header", false, "Выбор участников"));

            foreach ($participants as $participant) {
                if(!empty($_GET['id'])) {
                    if(in_array($participant,$currentParticipants)) {
                        $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getEmail(), "", "", false, "", true, array(), array()));
                    } else {
                        if ($participant->getStatus()->isCanVote()) {
                            $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getEmail(), "", "", false, "", false, array(), array()));
                        }
                    }
                } else {
                    if(in_array($participant,$dissertationCouncilTeam)) {
                        $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getEmail(), "", "", false, "", true, array(), array()));
                    } else {
                        if ($participant->getStatus()->isCanVote()) {
                            $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getEmail(), "", "", false, "", false, array(), array()));
                        }
                    }
                }
            }

            $posError = $formBuilder->processPostBuild();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
            $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));

            ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=voteList"
                           role="button">Вернуться к списку</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </div>

            <?php

            if(!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?=$posError?>
                </div>
                <?php
            }

            $formBuilder->build();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}