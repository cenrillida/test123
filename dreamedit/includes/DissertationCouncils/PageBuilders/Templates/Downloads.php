<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;
use DissertationCouncils\PageBuilders\PageBuilder;

class Downloads implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * Downloads constructor.
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

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['vote_id']) && is_numeric($_GET['vote_id'])) {
            $vote = $this->dissertationCouncils->getVoteService()->getVoteById($_GET['vote_id']);

            try {
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

                if ($this->dissertationCouncils->getAuthorizationService()->isAuthorized()):
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
                    $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));

                    ?>
                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=voteList"
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
                                <h5 class="font-weight-bold"><?=$vote->getTitle()?> - Загрузки: </h5>
                            </div>
                        </div>
                        <div class="row justify-content-start mb-3">
                            <div class="col-12">
                                <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=protocolWord&vote_id=<?= $vote->getId() ?>"
                                                                                 role="button">Скачать протокол</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php

                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
            } catch (Exception $exception)  {
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                $this->dissertationCouncils->getPageBuilder()->build(array("error" => $exception->getMessage()));
            }
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}