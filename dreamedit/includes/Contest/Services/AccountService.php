<?php

namespace Contest\Services;

use Contest\Contest;

class AccountService
{

    /** @var Contest */
    private $contest;

    /**
     * AccountService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function setBuilderWithMode($mode)
    {
        if (empty($mode)) {
            $mode = "";
        }
        if($this->contest->getAuthorizationService()->checkLogin()) {
            switch ($mode) {
                case "resultTableSource":
                    $this->contest->getPageBuilderManager()->setPageBuilder("resultTableSource");
                    break;
                case "resultTable":
                    $this->contest->getPageBuilderManager()->setPageBuilder("resultTable");
                    break;
                case "resultList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("resultList");
                    break;
                case "userResultList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("userResultList");
                    break;
                case "zipUsersResultLists":
                    $this->contest->getPageBuilderManager()->setPageBuilder("zipUsersResultLists");
                    break;
                case "downloads":
                    $this->contest->getPageBuilderManager()->setPageBuilder("downloads");
                    break;
                case "ratingList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("ratingList");
                    break;
                case "getPdfFile":
                    $this->contest->getPageBuilderManager()->setPageBuilder("getPdfFile");
                    break;
                case "addApplicant":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addApplicant");
                    break;
                case "applicantsList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("applicantsList");
                    break;
                case "addContest":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addContest");
                    break;
                case "addContestGroup":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addContestGroup");
                    break;
                case "addOnlineVoteResult":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addOnlineVoteResult");
                    break;
                case "addOpenVoteResult":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addOpenVoteResult");
                    break;
                case "contestsList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("contestsList");
                    break;
                case "contestsVoteList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("contestsVoteList");
                    break;
                case "contestsGroupsList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("contestsGroupsList");
                    break;
                case "addUser":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addUser");
                    break;
                case "usersList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("usersList");
                    break;
                case "addPosition":
                    $this->contest->getPageBuilderManager()->setPageBuilder("addPosition");
                    break;
                case "positionsList":
                    $this->contest->getPageBuilderManager()->setPageBuilder("positionsList");
                    break;
                case "protocolWord":
                    $this->contest->getPageBuilderManager()->setPageBuilder("protocolWord");
                    break;
                case "updatePassword":
                    $this->contest->getPageBuilderManager()->setPageBuilder("updatePassword");
                    break;
                case "resetPassword":
                    $this->contest->getPageBuilderManager()->setPageBuilder("resetPassword");
                    break;
                case "getSign":
                    $this->contest->getPageBuilderManager()->setPageBuilder("getSign");
                    break;
                case "login":
                    $this->contest->getPageBuilderManager()->setPageBuilder("login");
                    break;
                case "":
                    $this->contest->getPageBuilderManager()->setPageBuilder("admin");
                    break;
                default:
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
            }
        } else {
            switch ($mode) {
                case "updatePassword":
                    $this->contest->getPageBuilderManager()->setPageBuilder("updatePassword");
                    break;
                case "resetPassword":
                    $this->contest->getPageBuilderManager()->setPageBuilder("resetPassword");
                    break;
                case "registerConfirm":
                    $this->contest->getPageBuilderManager()->setPageBuilder("registerConfirm");
                    break;
                case "register":
                    $this->contest->getPageBuilderManager()->setPageBuilder("register");
                    break;
                case "login":
                    $this->contest->getPageBuilderManager()->setPageBuilder("login");
                    break;
                case "":
                    $this->contest->getPageBuilderManager()->setPageBuilder("login");
                    break;
                default:
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
            }
        }
    }
}