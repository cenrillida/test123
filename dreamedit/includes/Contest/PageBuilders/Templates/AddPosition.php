<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddPositionFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\PageBuilders\PageBuilder;

class AddPosition implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * AddPosition constructor.
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
            $sendText = "Должность успешно добавлена.";
            $buttonText = "Добавить";
            $title = "";
            $titleR = "";
            $departmentCase = "";
            if(!empty($_GET['id'])) {
                $position = $this->contest->getPositionService()->getPositionById($_GET['id']);
                if(!empty($position)) {
                    $title = $position->getTitle();
                    $titleR = $position->getTitleR();
                    $departmentCase = $position->getDepartmentCase();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array('error' => 'Должность не найдена'));
                    exit;
                }
            }

            $caseSelectArr = array();
            $caseSelectArr[] = new \OptionField("R", "Родительный");
            $caseSelectArr[] = new \OptionField("T", "Творительный");


            $formBuilder = new AddPositionFormBuilder($sendText, "", "", $buttonText, false);

            $formBuilder->registerField(new \FormField("title", "text", true, "Наименование", "Не введено наименование","",false,"",$title));
            $formBuilder->registerField(new \FormField("title_r", "text", true, "Наименование в род. падеже", "Не введено наименование в род. падеже","",false,"",$titleR));
            $formBuilder->registerField(new \FormField("department_case", "select", false, "Падеж подразделения", "","",false,"",$departmentCase,$caseSelectArr));
            $posError = $formBuilder->processPostBuild();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->contest->getPageBuilderManager()->setPageBuilder("top");
            $this->contest->getPageBuilder()->build(array("main_back" => true));

            ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=positionsList"
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