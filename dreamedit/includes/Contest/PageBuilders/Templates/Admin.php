<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class Admin implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * Admin constructor.
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

        if($this->contest->getAuthorizationService()->isAuthorized()):

            if(!$currentUser->getStatus()->isAdmin() && $currentUser->getStatus()->isCanVote()) {
                $this->contest->getPageBuilderManager()->setPageBuilder("contestsVoteList");
                $this->contest->getPageBuilder()->build($params);
                return;
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->contest->getPageBuilderManager()->setPageBuilder("top");
            $this->contest->getPageBuilder()->build(array("main_back" => true));
                ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <?php if($currentUser->getStatus()->isAdmin()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=usersList"
                           role="button">Пользователи</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=contestsGroupsList"
                           role="button">Группы конкурсов</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=positionsList"
                           role="button">Список должностей</a>
                    </div>
                    <?php endif;?>
                    <?php if($currentUser->getStatus()->isCanVote()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=contestsVoteList"
                               role="button">Голосовать</a>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <?php if(!$currentUser->getStatus()->isAdmin() && !$currentUser->getStatus()->isCanVote()):?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        На данный момент аккаунт не активен.
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

             endif;?>
        <?php


    }

}