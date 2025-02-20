<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class ContestsList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ContestsList constructor.
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
                "Удаление конкурса",
                "<p>Вы уверены, что хотите удалить этот конкурс?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->contest->getContestService()->deleteContestById($_GET['delete_id']);
                exit;
            }
        }

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['contest_group_id']) && is_numeric($_GET['contest_group_id'])) {

            $contestGroupId = $this->contest->getContestGroupService()->getContestGroupById($_GET['contest_group_id']);
            if(!empty($contestGroupId)) {

                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

                if ($this->contest->getAuthorizationService()->isAuthorized()):
                    $this->contest->getPageBuilderManager()->setPageBuilder("top");
                    $this->contest->getPageBuilder()->build(array("main_back" => true));

                    if ($currentUser->getStatus()->isAdmin()):
                        $deleteModal->echoModalWindow();
                        ?>
                        <div class="container-fluid">
                            <div class="row justify-content-start mb-3">
                                <div class="mr-3 mt-3">
                                    <a class="btn btn-lg imemo-button text-uppercase"
                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addContest&contest_group_id=<?= $_GET['contest_group_id'] ?>"
                                       role="button">Добавить новую вакансию</a>
                                </div>
                                <div class="mr-3 mt-3">
                                    <a class="btn btn-lg imemo-button text-uppercase"
                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=contestsGroupsList"
                                       role="button">Вернутся к списку групп конкурсов</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Вакантная должность</th>
                                            <th class="text-center" scope="col" style="width: 150px;">Дата</th>
                                            <?php if ($currentUser->getStatus()->isAdmin()): ?>
                                                <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                                <th class="text-center" scope="col" style="width: 100px;">Претенденты
                                                </th>
                                                <th class="text-center" scope="col" style="width: 150px;">Загрузки
                                                </th>
                                                <th class="text-center" scope="col" style="width: 100px;">Сводный лист
                                                </th>
                                                <th class="text-center" scope="col" style="width: 100px;">Результат
                                                </th>
                                                <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                            <?php else:; ?>
                                                <th class="text-center" scope="col" style="width: 100px;">Голосовать
                                                </th>
                                            <?php endif; ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $contests = $this->contest->getContestService()->getAllContestsByContestGroupId($_GET['contest_group_id'], "id");
                                        foreach ($contests as $contest):
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $contest->getPosition() ?></th>
                                                <td class="text-center"><?= $contest->getDate() ?></td>
                                                <?php if ($currentUser->getStatus()->isAdmin()): ?>
                                                    <td class="text-center"><a class="text-info"
                                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addContest&id=<?= $contest->getId() ?>"
                                                                               role="button"><i class="fas fa-edit"></i></a>
                                                    </td>
                                                    <td class="text-center"><a class="text-success"
                                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=applicantsList&contest_id=<?= $contest->getId() ?>"
                                                                               role="button"><i class="fas fa-list"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="text-success"
                                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=downloads&contest_id=<?= $contest->getId() ?>"
                                                                               role="button"><i
                                                                    class="fas fa-download"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if($contest->isOnlineVote()): ?>
                                                            <a class="text-success" target="_blank"
                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=resultTable&contest_id=<?= $contest->getId() ?>"
                                                               role="button"><i
                                                                        class="fas fa-list"></i>
                                                            </a>
                                                        <?php endif;?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if($contest->isOnlineVote()): ?>
                                                            <a class="text-success"
                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addOnlineVoteResult&contest_id=<?= $contest->getId() ?>"
                                                               role="button"><i class="fas fa-star"></i>
                                                            </a>
                                                        <?php endif;?>
                                                        <?php if(!$contest->isOnlineVote()): ?>
                                                        <a class="text-success"
                                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addOpenVoteResult&contest_id=<?= $contest->getId() ?>"
                                                                               role="button"><i class="fas fa-star"></i>
                                                        </a>
                                                        <?php endif;?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php $deleteModal->echoButton($contest->getId(), "text-danger"); ?>
                                                    </td>
                                                <?php else:; ?>
                                                    <td class="text-center">
                                                        <?php if($contest->isOnlineVote()): ?>
                                                        <a class="text-success"
                                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=ratingList&contest_id=<?= $contest->getId() ?>"
                                                                               role="button"><i class="fas fa-star"></i>
                                                        </a>
                                                         <?php endif;?>
                                                    </td>
                                                <?php endif; ?>
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
                $this->contest->getPageBuilder()->build(array("error" => "Не найдена группа конкурсов"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }
    }

}