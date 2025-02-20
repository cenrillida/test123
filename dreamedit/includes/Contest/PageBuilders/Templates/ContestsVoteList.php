<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\Models\User;
use Contest\PageBuilders\PageBuilder;

class ContestsVoteList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ContestsVoteList constructor.
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

        if($currentUser->getStatus()->isCanVote()) {

                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

                if ($this->contest->getAuthorizationService()->isAuthorized()):
                    $this->contest->getPageBuilderManager()->setPageBuilder("top");
                    $this->contest->getPageBuilder()->build(array("main_back" => true));
                     ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <h2>Необходимо заполнение рейтингового листа</h2>
                                <?php $this->buildTable($currentUser, true)?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h2>Решение принимается открытым голосованием</h2>
                                <?php $this->buildTable($currentUser, false)?>
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

    /**
     * @param User $currentUser
     * @param bool $isOnlineVote
     */
    private function buildTable($currentUser, $isOnlineVote) {
        ?>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Вакантная должность</th>
                    <th class="text-center" scope="col" style="width: 150px;">Дата</th>
                    <th class="text-center" scope="col" style="width: 150px;">Претенденты
                    <th class="text-center" scope="col" style="width: 150px;"><?php if($isOnlineVote) echo 'Голосовать'; else echo '';?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $contestsGroups = $this->contest->getContestGroupService()->getAllContestsGroups("date");
                foreach ($contestsGroups as $contestGroup):
                    if(!$contestGroup->isActive() && !$contestGroup->isPreview())
                        continue;

                    if(!in_array($currentUser, $contestGroup->getParticipants())) {
                        continue;
                    }


                    if($contestGroup->getParticipants())
                        foreach ($contestGroup->getContests() as $contest):
                            if($isOnlineVote && $contest->isOnlineVote()):
                            ?>
                            <tr>
                                <th scope="row"><?= $contest->getPosition() ?></th>
                                <td class="text-center"><?= $contest->getDate() ?></td>
                                <td class="text-center"><a class="text-success"
                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=applicantsList&contest_id=<?= $contest->getId() ?>"
                                                           role="button"><i class="fas fa-list"></i></a>
                                </td>
                                <td class="text-center">
                                    <?php if($contestGroup->isActive()):?>
                                    <a class="text-success"
                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=ratingList&contest_id=<?= $contest->getId() ?>"
                                                           role="button"><i class="fas fa-star"></i></a>
                                    <?php else:?>
                                    <i class="fas fa-star" style="color: #bdc3c7" data-toggle="tooltip" data-placement="top" data-html="true" title="" data-original-title="Голосование пока не началось"></i>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php
                            elseif(!$isOnlineVote && !$contest->isOnlineVote()):
                                ?>
                                <tr>
                                    <th scope="row"><?= $contest->getPosition() ?></th>
                                    <td class="text-center"><?= $contest->getDate() ?></td>
                                    <td class="text-center"><a class="text-success"
                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=applicantsList&contest_id=<?= $contest->getId() ?>"
                                                               role="button"><i class="fas fa-list"></i></a>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php
                            endif;
                            endforeach;
                endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

}