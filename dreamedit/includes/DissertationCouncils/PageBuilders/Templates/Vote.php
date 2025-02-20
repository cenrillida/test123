<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\AddUserFormBuilder;
use DissertationCouncils\FormBuilders\Templates\VoteFormBuilder;
use DissertationCouncils\Models\VoteResult;
use DissertationCouncils\PageBuilders\PageBuilder;

class Vote implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * Vote constructor.
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

        if($currentUser->getStatus()->isCanVote() && !empty($_GET['vote_id'])) {
            $vote = $this->dissertationCouncils->getVoteService()->getVoteById($_GET['vote_id']);
            if(!empty($vote)) {
                if($vote->isActive()) {
                    if (in_array($currentUser, $vote->getParticipants())) {
                        $voteResult = $this->dissertationCouncils->getVoteResultService()->getAllVoteResultsByVoteIdAndUserId($_GET['vote_id'], $currentUser->getId());
                        if(empty($voteResult[0])) {
                            $sendText = "Вы успешно проголосовали.";
                            $buttonText = "Подтвердить";

                            $formBuilder = new VoteFormBuilder($sendText, "", "", $buttonText, false);

                            $formBuilder->registerField(new \FormField("", "hr", false, ""));
                            $formBuilder->registerField(new \FormField("", "header", false, $vote->getTitle()));

                            $resultSelectArr = array();
                            $resultSelectArr[] = new \OptionField("", "");
                            $resultSelectArr[] = new \OptionField("Да", "Да");
                            $resultSelectArr[] = new \OptionField("Нет", "Нет");
                            $resultSelectArr[] = new \OptionField("Воздержался", "Воздержался");

                            if (empty($vote)) {
                                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                                $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Не найдено голосование"));
                                exit;
                            }

                            $result = "";

                            if(!empty($voteResult[0])) {
                                $result = $voteResult[0]->getResult();
                            }

                            $formBuilder->registerField(new \FormField("result", "select", true, "Результат", "Выберите один из предложенных вариантов", "0", false, "", $result, $resultSelectArr, array()));

                            $posError = $formBuilder->processPostBuild();

                            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
                            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
                            $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));


                            if ($currentUser->getStatus()->isAdmin()):?>
                            <div class="container-fluid">
                                <div class="row justify-content-between mb-3">
                                    <div>
                                        <div class="mr-3 mt-3">
                                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=voteList"
                                               role="button">К списку голосований</a>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">

                                    </div>
                                </div>
                            </div>

                            <?php

                            if (!empty($posError)) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $posError ?>
                                </div>
                                <?php
                            }

                            $formBuilder->build();

                            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
                        } else {
                            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                            $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Вы уже проголосовали"));
                        }
                    } else {
                        $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                        $this->dissertationCouncils->getPageBuilder()->build();
                    }
                } else {
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                    $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Голосование закончилось"));
                }
            } else {
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Не найдено голосование"));
            }
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}