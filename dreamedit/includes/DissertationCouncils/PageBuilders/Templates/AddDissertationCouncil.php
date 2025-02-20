<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\AddDissertationCouncilFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class AddDissertationCouncil implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * AddDissertationCouncil constructor.
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

            $sendText = "Диссовет успешно добавлен.";
            $buttonText = "Добавить";
            $name = "";
            $currentTeam = array();
            if(!empty($_GET['id'])) {
                $dissertationCouncil = $this->dissertationCouncils->getDissertationCouncilService()->getDissertationCouncilById($_GET['id']);
                if(!empty($dissertationCouncil)) {
                    $name = $dissertationCouncil->getName();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                    $currentTeam = $dissertationCouncil->getTeam();
                } else {
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                    $this->dissertationCouncils->getPageBuilder()->build(array('error' => 'Диссовет не найден'));
                    exit;
                }
            }

            $formBuilder = new AddDissertationCouncilFormBuilder($sendText, "", "", $buttonText, false);

            $formBuilder->registerField(new \FormField("name", "text", true, "Название", "Не введено название","",false,"",$name));

            $team = $this->dissertationCouncils->getUserService()->getAllUsers("lastname","ASC");

            $formBuilder->registerField(new \FormField("", "header", false, "Состав"));

            foreach ($team as $teamMember) {
                if(!empty($_GET['id'])) {
                    if(in_array($teamMember,$currentTeam)) {
                        $formBuilder->registerField(new \FormField($teamMember->getId() . "__team-member", "checkbox", false, $teamMember->getEmail(), "", "", false, "", true, array(), array()));
                    } else {
                        if ($teamMember->getStatus()->isCanVote()) {
                            $formBuilder->registerField(new \FormField($teamMember->getId() . "__team-member", "checkbox", false, $teamMember->getEmail(), "", "", false, "", false, array(), array()));
                        }
                    }
                } else {
                    if ($teamMember->getStatus()->isCanVote()) {
                        $formBuilder->registerField(new \FormField($teamMember->getId() . "__team-member", "checkbox", false, $teamMember->getEmail(), "", "", false, "", true, array(), array()));
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
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=dissertationCouncilsList"
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