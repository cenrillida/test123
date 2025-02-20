<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\AddUserFormBuilder;
use DissertationCouncils\Models\VoteResult;
use DissertationCouncils\PageBuilders\PageBuilder;

class ResultTableSource implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * ResultTableSource constructor.
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
            if(!empty($vote)) {
                if(isset($_GET['delete'])) {
                    $userId = (int)$_GET['delete'];
                    $results = $this->dissertationCouncils->getVoteResultService()->getAllVoteResultsByVoteIdAndUserId($_GET['vote_id'],$userId);
                    foreach ($results as $result) {
                        $this->dissertationCouncils->getVoteResultService()->deleteVoteResultById($result->getId());
                    }
                    exit;
                }

                $results = $this->dissertationCouncils->getVoteResultService()->getAllVoteResultsByVoteId($_GET['vote_id']);

                $resultsUsers = array_map(function (VoteResult $el) {
                    return $el->getUser()->getId();
                },$results);

                header("Content-type: application/json");

                $rows = array();

                $counter = 0;
                foreach ($vote->getParticipants() as $user) {
                    $firstname = "";
                    if($user->getFirstName()!="") {
                        $firstname = substr($user->getFirstName(),0,1).".";
                    }
                    $thirdname = "";
                    if($user->getThirdName()!="") {
                        $thirdname = substr($user->getThirdName(),0,1).".";
                    }
                    $rows[$counter] = array();
                    $rows[$counter]['user_fio'] = \Dreamedit::normJsonStr($user->getLastName() . " " . $firstname . " " . $thirdname);
                    $rows[$counter]['user_result_list'] = \Dreamedit::normJsonStr("<div class=\"cell-button\"><a href='/index.php?page_id={$_REQUEST['page_id']}&mode=userResultList&contest_id={$_GET['contest_id']}&user_id={$user->getId()}' target='_blank'><i class=\"dxi dxi-download\"></i></a></div>");
                    $rows[$counter]['del'] = \Dreamedit::normJsonStr("<div class=\"del-button\"><a href=\"#\" onclick=\"deleteLoginGet('{$user->getId()}');\"><i class=\"dxi dxi-eraser\"></i></a></div>");

                    if(in_array($user->getId(),$resultsUsers)) {
                        $rows[$counter]['participate'] = \Dreamedit::normJsonStr("Да");
                        if(!empty($results)) {
                            $resultsFilter = array_filter(
                                $results,
                                function (VoteResult $e) use (&$user) {
                                    return ($e->getUser()->getId() == $user->getId());
                                }
                            );
                            $result = array_shift($resultsFilter);

                            if(!empty($result)) {
                                $rows[$counter]['result'] = \Dreamedit::normJsonStr($result->getResult());
                            }
                        }
                    } else {
                        $rows[$counter]['participate'] = \Dreamedit::normJsonStr("Нет");
                        $rows[$counter]['result'] = \Dreamedit::normJsonStr("");
                    }
                    $counter++;
                }

                echo json_encode($rows);
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