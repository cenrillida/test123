<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class Personal implements PageBuilder {
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

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

//                error_reporting(E_ALL);
//        ini_set('display_errors', 1);


        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()):?>
            <?php

            $deleteModal = new \ModalWindow(
                "<i class=\"fas fa-times\"></i>",
                "deleteElement",
                "Удаление элемента",
                "<p>Вы уверены, что хотите удалить этот элемент?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->academicCouncilModule->getQuestionnaireService()->deleteQuestionnaireById($_GET['delete_id']);
                exit;
            }

            $deleteModal->echoModalWindow();

            $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("top");
            $this->academicCouncilModule->getPageBuilder()->build(array("main_back" => false));
            ?>

            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireCreate"
                           role="button">Создать опрос для текущего состава ученого совета</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireCreate&test=1"
                           role="button">Создать опрос с одним участником</a>
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
                                    <th scope="col">Название</th>
                                    <th class="text-center" scope="col" style="width: 200px;">Дата начала</th>
                                    <th class="text-center" scope="col" style="width: 200px;">Дата окончания</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Таблица кодов</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Протокол</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Регистрация</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Опросный лист</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Рассылка</th>
                                    <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $questionnaires = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnairesList();
                                foreach ($questionnaires as $questionnaire):
                                    ?>
                                    <tr>
                                        <th scope="row"><?=$questionnaire->getName()?></th>
                                        <td class="text-center"><?=$questionnaire->getDtStart()?></td>
                                        <td class="text-center"><?=$questionnaire->getDtEnd()?></td>
                                        <td class="text-center"><a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireEdit&id=<?=$questionnaire->getId()?>"
                                                                   role="button"><i class="fas fa-edit"></i></a></td>
                                        <td class="text-center">
                                            <?php if($questionnaire->isSecret()):?>
                                                <a class="text-success" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireCodeTable&id=<?=$questionnaire->getId()?>"
                                                   role="button"><i class="fas fa-table"></i></a>
                                            <?php endif;?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($questionnaire->isSecret()):?>
                                            <a class="text-success" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireProtocol&id=<?=$questionnaire->getId()?>"
                                                                   role="button"><i class="fas fa-download"></i></a>
                                            <?php endif;?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($questionnaire->isSecret()):?>
                                                <a class="text-success" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireParticipateList&id=<?=$questionnaire->getId()?>"
                                                   role="button"><i class="fas fa-download"></i></a>
                                            <?php endif;?>
                                        </td>
                                        <td class="text-center"><a class="text-success" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireResultList&id=<?=$questionnaire->getId()?>"
                                                                   role="button"><i class="fas fa-download"></i></a></td>
                                        <td class="text-center"><a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireMailer&id=<?=$questionnaire->getId()?>"
                                                                   role="button"><i class="fas fa-share-square"></i></a></td>
                                        <td class="text-center">
                                            <?php $deleteModal->echoButton($questionnaire->getId(), "text-danger"); ?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}