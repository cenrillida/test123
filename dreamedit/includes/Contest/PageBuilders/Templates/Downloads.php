<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddContestFormBuilder;
use Contest\FormBuilders\Templates\AddOnlineVoteResultFormBuilder;
use Contest\FormBuilders\Templates\AddOpenVoteResultFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\Applicant;
use Contest\Models\OpenVoteResult;
use Contest\PageBuilders\PageBuilder;

class Downloads implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * Downloads constructor.
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

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
                $this->contest->getPageBuilderManager()->setPageBuilder("top");
                $this->contest->getPageBuilder()->build(array("main_back" => true));
                ?>
                <div class="container-fluid">
                    <div class="row justify-content-start mb-3">
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase"
                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=contestsList&contest_group_id=<?= $contest->getContestGroupId() ?>"
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <hr>
                            <h5 class="font-weight-bold"><?=$contest->getPosition()?> - Загрузки: </h5>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <div class="col-12">
                            <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=protocolWord&contest_id=<?= $contest->getId() ?>"
                                                                           role="button">Скачать протокол</a>
                        </div>
                        <?php if($contest->isOnlineVote()):?>
                        <div class="col-12">
                            <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=resultList&contest_id=<?= $contest->getId() ?>"
                                                                            role="button">Скачать сводный лист</a>
                        </div>
                        <div class="col-12">
                            <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=userResultList&contest_id=<?= $contest->getId() ?>&all_users=1"
                                                                            role="button">Скачать рейтинговые листы одним документом без учета пустых листов</a>
                        </div>
                        <div class="col-12">
                            <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=userResultList&contest_id=<?= $contest->getId() ?>&all_users=1&empty_too=1"
                                                                            role="button">Скачать рейтинговые листы одним документом c учетом пустых листов</a>
                        </div>
                        <div class="col-12">
                            <i class="fas fa-file-archive text-dark"></i> <a target="_blank" href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=zipUsersResultLists&contest_id=<?= $contest->getId() ?>"
                                                                            role="button">Скачать рейтинговые листы в архиве</a>
                        </div>
                        <?php endif;?>
                    </div>
                </div>

                <?php
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
            } else {
                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                $this->contest->getPageBuilder()->build(array("error" => "Не найден конкурс"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}