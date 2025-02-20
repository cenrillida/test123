<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddContestFormBuilder;
use Contest\FormBuilders\Templates\AddContestGroupFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\PageBuilders\PageBuilder;

class AddContestGroup implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * AddContestGroup constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin()) {

            $sendText = "Группа конкурсов успешно добавлена.";
            $buttonText = "Добавить";
            $date = "";
            $currentParticipants = array();
            if(!empty($_GET['id'])) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($_GET['id']);
                if(!empty($contestGroup)) {
                    $date = $contestGroup->getDate();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                    $currentParticipants = $contestGroup->getParticipants();
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array('error' => 'Группа конкурсов не найдена'));
                    exit;
                }
            }

            $formBuilder = new AddContestGroupFormBuilder($sendText, "", "", $buttonText, false);

            $formBuilder->registerField(new \FormField("date", "date", true, "Дата", "Не введена дата","",false,"",$date));

            $participants = $this->contest->getUserService()->getAllUsers("lastname","ASC");

            $formBuilder->registerField(new \FormField("", "header", false, "Выбор участников"));

            foreach ($participants as $participant) {
                if(!empty($_GET['id'])) {
                    if(in_array($participant,$currentParticipants)) {
                        $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getLastName() . " " . $participant->getFirstName() . " " . $participant->getThirdName(), "", "", false, "", true, array(), array()));
                    } else {
                        if ($participant->getStatus()->isCanVote()) {
                            $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getLastName() . " " . $participant->getFirstName() . " " . $participant->getThirdName(), "", "", false, "", false, array(), array()));
                        }
                    }
                } else {
                    if ($participant->getStatus()->isCanVote()) {
                        $formBuilder->registerField(new \FormField($participant->getId() . "__participant", "checkbox", false, $participant->getLastName() . " " . $participant->getFirstName() . " " . $participant->getThirdName(), "", "", false, "", true, array(), array()));
                    }
                }
            }

            $posError = $formBuilder->processPostBuild();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->contest->getPageBuilderManager()->setPageBuilder("top");
            $this->contest->getPageBuilder()->build(array("main_back" => true));

            ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=contestsGroupsList"
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
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}