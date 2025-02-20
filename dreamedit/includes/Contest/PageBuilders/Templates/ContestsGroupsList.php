<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class ContestsGroupsList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ContestsGroupsList constructor.
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
            $deleteModal = new \ModalWindow(
                "<i class=\"fas fa-times\"></i>",
                "deleteElement",
                "Удаление группы конкурсов",
                "<p>Вы уверены, что хотите удалить эту группу конкурсов?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->contest->getContestGroupService()->deleteContestGroupById($_GET['delete_id']);
                exit;
            }
            $startModal = new \ModalWindow(
                "<i class=\"fas fa-play\"></i>",
                "startElement",
                "Запуск голосования группы конкурсов",
                "<p>Вы уверены, что хотите запустить голосование конкурсов этой группы?</p>",
                "start_id",
                "Запустить"
            );
            if(!empty($_GET['start_id'])) {
                $this->contest->getContestGroupService()->startContestGroupById($_GET['start_id']);
                exit;
            }
            $stopModal = new \ModalWindow(
                "<i class=\"fas fa-stop\"></i>",
                "stopElement",
                "Остановка голосования группы конкурсов",
                "<p>Вы уверены, что хотите остановить голосование конкурсов этой группы?</p>",
                "stop_id",
                "Остановить"
            );
            if(!empty($_GET['stop_id'])) {
                $this->contest->getContestGroupService()->stopContestGroupById($_GET['stop_id']);
                exit;
            }

            $startPreviewModal = new \ModalWindow(
                "<i class=\"fas fa-play\"></i>",
                "startPreviewElement",
                "Запуск предпросмотра данных группы конкурсов",
                "<p>Вы уверены, что хотите запустить предпросмотр данных конкурсов этой группы?</p>",
                "start_preview_id",
                "Запустить"
            );
            if(!empty($_GET['start_preview_id'])) {
                $this->contest->getContestGroupService()->startPreviewContestGroupById($_GET['start_preview_id']);
                exit;
            }
            $stopPreviewModal = new \ModalWindow(
                "<i class=\"fas fa-stop\"></i>",
                "stopPreviewElement",
                "Остановка предпросмотра данных группы конкурсов",
                "<p>Вы уверены, что хотите остановить предпросмотр данных конкурсов этой группы?</p>",
                "stop_preview_id",
                "Остановить"
            );
            if(!empty($_GET['stop_preview_id'])) {
                $this->contest->getContestGroupService()->stopPreviewContestGroupById($_GET['stop_preview_id']);
                exit;
            }
        }

        if($currentUser->getStatus()->isAdmin()) {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            if ($this->contest->getAuthorizationService()->isAuthorized()):
                $this->contest->getPageBuilderManager()->setPageBuilder("top");
                $this->contest->getPageBuilder()->build(array("main_back" => true));

                if ($currentUser->getStatus()->isAdmin()):
                    $deleteModal->echoModalWindow();
                    $startModal->echoModalWindow();
                    $stopModal->echoModalWindow();
                    $startPreviewModal->echoModalWindow();
                    $stopPreviewModal->echoModalWindow();
                    ?>
                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addContestGroup"
                                   role="button">Добавить новую группу конкурсов</a>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Дата</th>
                                            <th class="text-center" scope="col" style="width: 200px;">Список вакансий</th>
                                            <?php if ($currentUser->getStatus()->isAdmin()):?>
                                            <th class="text-center" scope="col" style="width: 200px;">Запуск голосования</th>
                                            <th class="text-center" scope="col" style="width: 200px;">Запуск предпросмотра</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                            <?php endif;?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $contestsGroups = $this->contest->getContestGroupService()->getAllContestsGroups("date");
                                        foreach ($contestsGroups as $contestGroup):
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $contestGroup->getDate()?></th>
                                                <td class="text-center"><a class="text-info"
                                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=contestsList&contest_group_id=<?= $contestGroup->getId() ?>"
                                                                           role="button"><i class="fas fa-list"></i></a>
                                                </td>
                                                <?php if ($currentUser->getStatus()->isAdmin()):?>
                                                <td class="text-center">
                                                    <?php if($contestGroup->isActive()) {
                                                        $stopModal->echoButton($contestGroup->getId(),"text-danger");
                                                    } else {
                                                        $startModal->echoButton($contestGroup->getId(),"text-success");
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($contestGroup->isPreview()) {
                                                        $stopPreviewModal->echoButton($contestGroup->getId(),"text-danger");
                                                    } else {
                                                        $startPreviewModal->echoButton($contestGroup->getId(),"text-success");
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><a class="text-info"
                                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addContestGroup&id=<?= $contestGroup->getId() ?>"
                                                                           role="button"><i class="fas fa-edit"></i></a>
                                                </td>
                                                <td class="text-center">
                                                    <?php $deleteModal->echoButton($contestGroup->getId(),"text-danger");?>
                                                </td>
                                                <?php endif;?>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
            <?php

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }
    }

}