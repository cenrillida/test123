<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;

class AccountService
{

    /** @var DissertationCouncils */
    private $dissertationCouncils;

    /**
     * AccountService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    public function setBuilderWithMode($mode)
    {
        if (empty($mode)) {
            $mode = "";
        }
        if($this->dissertationCouncils->getAuthorizationService()->checkLogin()) {
            switch ($mode) {
                case "usersList":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("usersList");
                    break;
                case "addUser":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("addUser");
                    break;
                case "voteList":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("voteList");
                    break;
                case "addVote":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("addVote");
                    break;
                case "result":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("result");
                    break;
//                case "resultTable":
//                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("resultTable");
//                    break;
//                case "resultTableSource":
//                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("resultTableSource");
//                    break;
                case "downloads":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("downloads");
                    break;
                case "protocolWord":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("protocolWord");
                    break;
                case "vote":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("vote");
                    break;
                case "dissertationCouncilsList":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("dissertationCouncilsList");
                    break;
                case "addDissertationCouncil":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("addDissertationCouncil");
                    break;
                case "updatePassword":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("updatePassword");
                    break;
                case "resetPassword":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("resetPassword");
                    break;
                case "login":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("login");
                    break;
                case "":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("admin");
                    break;
                default:
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            }
        } else {
            switch ($mode) {
                case "updatePassword":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("updatePassword");
                    break;
                case "resetPassword":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("resetPassword");
                    break;
//                case "registerConfirm":
//                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("registerConfirm");
//                    break;
//                case "register":
//                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("register");
//                    break;
                case "smsAuth":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("smsAuth");
                    break;
                case "checkPhone":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("checkPhone");
                    break;
                case "":
                case "login":
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("login");
                    break;
                default:
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            }
        }
    }
}