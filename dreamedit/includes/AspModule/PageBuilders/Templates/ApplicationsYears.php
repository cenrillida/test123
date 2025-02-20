<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class ApplicationsYears implements PageBuilder {
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
            $deleteModal = new \ModalWindow(
                "<i class=\"fas fa-times\"></i>",
                "deleteElement",
                "Удаление приема",
                "<p>Вы уверены, что хотите удалить этот прием?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->aspModule->getApplicationsYearService()->deleteApplicationsYearById($_GET['delete_id']);
                exit;
            }
        }

        if(!$status->isAdminAllow()) {
            $this->aspModule->getPageBuilderManager()->setPageBuilder("error");
            $this->aspModule->getPageBuilder()->build();
        } else {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            $deleteModal->echoModalWindow();

            ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase"
                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addApplicationsYear"
                           role="button">Добавить новый прием</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=adminTable"
                           role="button">Общая таблица заявлений</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=adminTable&applications_year_id=0"
                           role="button">Таблица неопределенных заявлений</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Прием</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Таблица
                                    </th>
                                    <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $applicationsYears = $this->aspModule->getApplicationsYearService()->getApplicationsYearList();
                                foreach ($applicationsYears as $applicationsYear):
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $applicationsYear->getName() ?></th>
<!--                                        <td class="text-center">--><?//= $contest->getDate() ?><!--</td>-->
                                        <td class="text-center">
                                            <a class="text-success" target="_blank"
                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=adminTable&applications_year_id=<?= $applicationsYear->getId() ?>"
                                               role="button"><i
                                                        class="fas fa-list"></i>
                                            </a>
                                        </td>
                                        <td class="text-center"><a class="text-info"
                                                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addApplicationsYear&id=<?= $applicationsYear->getId() ?>"
                                                                   role="button"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <?php $deleteModal->echoButton($applicationsYear->getId(), "text-danger"); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
        }

    }
}