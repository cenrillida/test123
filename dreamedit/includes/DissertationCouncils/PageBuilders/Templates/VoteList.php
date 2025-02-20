<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;
use DissertationCouncils\Models\VoteResult;
use DissertationCouncils\PageBuilders\PageBuilder;

class VoteList implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * VoteList constructor.
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
            $deleteModal = new \ModalWindow(
                "<i class=\"fas fa-times\"></i>",
                "deleteElement",
                "Удаление голосования",
                "<p>Вы уверены, что хотите удалить это голосование?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->dissertationCouncils->getVoteService()->deleteVoteById($_GET['delete_id']);
                exit;
            }
            $startModal = new \ModalWindow(
                "<i class=\"fas fa-play\"></i>",
                "startElement",
                "Запуск голосования",
                "<p>Вы уверены, что хотите запустить голосование?</p>",
                "start_id",
                "Запустить"
            );
            if(!empty($_GET['start_id'])) {
                $this->dissertationCouncils->getVoteService()->startVoteById($_GET['start_id']);
                exit;
            }
            $stopModal = new \ModalWindow(
                "<i class=\"fas fa-stop\"></i>",
                "stopElement",
                "Остановка голосования",
                "<p>Вы уверены, что хотите остановить голосование?</p>",
                "stop_id",
                "Остановить"
            );
            if(!empty($_GET['stop_id'])) {
                $this->dissertationCouncils->getVoteService()->stopVoteById($_GET['stop_id']);
                exit;
            }

            $startPreviewModal = new \ModalWindow(
                "<i class=\"fas fa-play\"></i>",
                "startPreviewElement",
                "Запуск предпросмотра данных",
                "<p>Вы уверены, что хотите запустить предпросмотр данных?</p>",
                "start_preview_id",
                "Запустить"
            );
            if(!empty($_GET['start_preview_id'])) {
                $this->dissertationCouncils->getVoteService()->startPreviewVoteById($_GET['start_preview_id']);
                exit;
            }
            $stopPreviewModal = new \ModalWindow(
                "<i class=\"fas fa-stop\"></i>",
                "stopPreviewElement",
                "Остановка предпросмотра данных",
                "<p>Вы уверены, что хотите остановить предпросмотр данных?</p>",
                "stop_preview_id",
                "Остановить"
            );
            if(!empty($_GET['stop_preview_id'])) {
                $this->dissertationCouncils->getVoteService()->stopPreviewVoteById($_GET['stop_preview_id']);
                exit;
            }

            $dissertationCouncils =
                $this->dissertationCouncils->getDissertationCouncilService()->getAllDissertationCouncils();
        }

        if($currentUser->getStatus()->isAdmin() || $currentUser->getStatus()->isCanVote()) {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            if ($this->dissertationCouncils->getAuthorizationService()->isAuthorized()):
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
                $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));

                if ($currentUser->getStatus()->isAdmin()):
                    $deleteModal->echoModalWindow();
                    $startModal->echoModalWindow();
                    $stopModal->echoModalWindow();
                    $startPreviewModal->echoModalWindow();
                    $stopPreviewModal->echoModalWindow();
                    ?>
                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <?php foreach ($dissertationCouncils as $dissertationCouncil):?>
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addVote&dissertation_council_id=<?=$dissertationCouncil->getId()?>"
                                   role="button">Добавить новое голосование диссовета <?=$dissertationCouncil->getName()?></a>
                            </div>
                            <?php endforeach;?>
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
                                            <th scope="col">Название</th>
                                            <th class="text-center" scope="col" style="width: 200px;">Дата</th>
                                            <?php if ($currentUser->getStatus()->isAdmin()):?>
                                            <th class="text-center" scope="col" style="width: 200px;">Запуск голосования</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Результат</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Загрузки</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                            <?php endif;?>
                                            <?php if ($currentUser->getStatus()->isCanVote()):?>
                                                <th class="text-center" scope="col" style="width: 100px;">Голосовать</th>
                                            <?php endif;?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $votes = $this->dissertationCouncils->getVoteService()->getAllVotes("date");
                                        foreach ($votes as $vote):
                                            if(!$currentUser->getStatus()->isAdmin() && !$vote->isActive() && !$vote->isPreview()) {
                                                continue;
                                            }
                                            if(!$currentUser->getStatus()->isAdmin() && !in_array($currentUser, $vote->getParticipants())) {
                                                continue;
                                            }
                                            if(!$currentUser->getStatus()->isAdmin()) {
                                                try {
                                                    $results = $this->dissertationCouncils->getVoteResultService()->getAllVoteResultsByVoteId($vote->getId());
                                                    $resultsUsers = array_map(function (VoteResult $el) {
                                                        return $el->getUser()->getId();
                                                    },$results);
                                                    if(in_array($currentUser->getId(),$resultsUsers)) {
                                                        continue;
                                                    }
                                                } catch (Exception $exception) { continue; }
                                            }
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $vote->getTitle()?></th>
                                                <td class="text-center">
                                                    <?= $vote->getDate()?>
                                                </td>
                                                <?php if ($currentUser->getStatus()->isAdmin()):?>
                                                <td class="text-center">
                                                    <?php if($vote->isActive()) {
                                                        $stopModal->echoButton($vote->getId(),"text-danger");
                                                    } else {
                                                        $startModal->echoButton($vote->getId(),"text-success");
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><a class="text-info"
                                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addVote&id=<?= $vote->getId() ?>"
                                                                           role="button"><i class="fas fa-edit"></i></a>
                                                </td>
                                                <td class="text-center">
                                                    <a class="text-success"
                                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=result&vote_id=<?= $vote->getId() ?>"
                                                       role="button"><i
                                                                class="fas fa-list"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a class="text-success"
                                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=downloads&vote_id=<?= $vote->getId() ?>"
                                                       role="button"><i
                                                                class="fas fa-download"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <?php $deleteModal->echoButton($vote->getId(),"text-danger");?>
                                                </td>
                                                <?php endif;?>
                                                <?php if ($currentUser->getStatus()->isCanVote()):?>
                                                <td class="text-center">
                                                    <?php if($vote->isActive()):?>
                                                    <a class="text-success"
                                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=vote&vote_id=<?= $vote->getId() ?>"
                                                       role="button"><i class="fas fa-star"></i></a>
                                                    <?php endif;?>
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
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }
    }

}