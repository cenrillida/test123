<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddContestFormBuilder;
use Contest\FormBuilders\Templates\AddOpenVoteResultFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\OnlineVoteResult;
use Contest\PageBuilders\PageBuilder;

class ResultTableSource implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ResultTableSource constructor.
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
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($contest->getContestGroupId());
                if(!empty($contestGroup)) {

                    if(isset($_GET['delete'])) {
                        $userId = (int)$_GET['delete'];
                        $results = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestIdAndUserId($_GET['contest_id'],$userId);
                        foreach ($results as $result) {
                            $this->contest->getOnlineVoteService()->deleteOnlineVoteResultById($result->getId());
                        }
                        exit;
                    }

                    $results = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestId($_GET['contest_id']);

                    $resultsUsers = array_map(function (OnlineVoteResult $el) {
                        return $el->getUser()->getId();
                    },$results);

                    header("Content-type: application/json");

                    $rows = array();

                    $counter = 0;
                    foreach ($contestGroup->getParticipants() as $user) {
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
                            $counterApplicant = 1;
                            foreach ($contest->getApplicants() as $applicant) {
                                $rows[$counter]['applicant_'.$counterApplicant] = \Dreamedit::normJsonStr("");
                                if(!empty($results)) {
                                    $result = array_shift(array_filter(
                                        $results,
                                        function (OnlineVoteResult $e) use (&$applicant,&$user) {
                                            return ($e->getApplicant()->getId() == $applicant->getId() && $e->getUser()->getId() == $user->getId());
                                        }
                                    ));

                                    if(!empty($result)) {
                                        $rows[$counter]['applicant_'.$counterApplicant."_science_results"] = \Dreamedit::normJsonStr($result->getScienceResults());
                                        $rows[$counter]['applicant_'.$counterApplicant."_experience"] = \Dreamedit::normJsonStr($result->getExperience());
                                        $interview = $result->getInterview();
                                        if($interview=="-1") {
                                            $interview = "Нет";
                                        }
                                        $rows[$counter]['applicant_'.$counterApplicant."_interview"] = \Dreamedit::normJsonStr($interview);
                                        $rows[$counter]['applicant_'.$counterApplicant."_total"] = \Dreamedit::normJsonStr("<b>".$result->getTotal()."</b>");
                                    }
                                }


                                $counterApplicant++;
                            }
                        } else {
                            $rows[$counter]['participate'] = \Dreamedit::normJsonStr("Нет");
                            $counterApplicant = 1;
                            foreach ($contest->getApplicants() as $applicant) {
                                $rows[$counter]['applicant_'.$counterApplicant] = \Dreamedit::normJsonStr("");
                                $counterApplicant++;
                            }
                        }
                        $counter++;
                    }

                    echo json_encode($rows);
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array("error" => "Не найдена группа конкурсов"));
                }
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