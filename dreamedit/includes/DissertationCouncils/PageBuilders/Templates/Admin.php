<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\PageBuilder;

class Admin implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * Admin constructor.
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

        if($this->dissertationCouncils->getAuthorizationService()->isAuthorized()):

            if(!$currentUser->getStatus()->isAdmin() && $currentUser->getStatus()->isCanVote()) {
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("voteList");
                $this->dissertationCouncils->getPageBuilder()->build($params);
                return;
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
            $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));
                ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <?php if($currentUser->getStatus()->isAdmin()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=usersList"
                           role="button">Пользователи</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=voteList"
                           role="button">Список голосований</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=dissertationCouncilsList"
                           role="button">Списки диссоветов</a>
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