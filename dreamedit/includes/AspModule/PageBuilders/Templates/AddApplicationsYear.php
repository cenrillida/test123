<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AddApplicationsYearFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class AddApplicationsYear implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($admin->getStatus());
        if($status->isAdminAllow()) {
            $sendText = "Прием успешно добавлен.";
            $buttonText = "Добавить";
            $name = "";
            if(!empty($_GET['id'])) {
                $applicationsYear = $this->aspModule->getApplicationsYearService()->getApplicationsYearById($_GET['id']);

                if(!empty($applicationsYear)) {
                    $name = $applicationsYear->getName();
                    $sendText = "Прием успешно изменен.";
                    $buttonText = "Изменить";
                } else {
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("error");
                    $this->aspModule->getPageBuilder()->build(array('error' => 'Прием не найден'));
                    exit;
                }
            }

            $formBuilder = new AddApplicationsYearFormBuilder($sendText,"","",$buttonText,false);

            $formBuilder->registerField(new \FormField("name", "text", true, "Наименование", "","",false,"",$name));

            $posError = $formBuilder->processPostBuild();
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applicationsYears"
                           role="button">Вернуться к списку приемов</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php
        if(!$status->isAdminAllow()) {
            echo "Ошибка доступа.";
        } else {
            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}