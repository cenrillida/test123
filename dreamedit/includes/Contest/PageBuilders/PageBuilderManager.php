<?php

namespace Contest\PageBuilders;

use Contest\Contest;
use Contest\PageBuilders\Templates\AddApplicant;
use Contest\PageBuilders\Templates\AddContest;
use Contest\PageBuilders\Templates\AddContestGroup;
use Contest\PageBuilders\Templates\AddOnlineVoteResult;
use Contest\PageBuilders\Templates\AddOpenVoteResult;
use Contest\PageBuilders\Templates\AddPosition;
use Contest\PageBuilders\Templates\AddUser;
use Contest\PageBuilders\Templates\Admin;
use Contest\PageBuilders\Templates\ApplicantsList;
use Contest\PageBuilders\Templates\ContestsGroupsList;
use Contest\PageBuilders\Templates\ContestsList;
use Contest\PageBuilders\Templates\ContestsVoteList;
use Contest\PageBuilders\Templates\Downloads;
use Contest\PageBuilders\Templates\Error;
use Contest\PageBuilders\Templates\GetPdf;
use Contest\PageBuilders\Templates\GetProtocol;
use Contest\PageBuilders\Templates\GetSign;
use Contest\PageBuilders\Templates\LoginForm;
use Contest\PageBuilders\Templates\PositionsList;
use Contest\PageBuilders\Templates\ProtocolWord;
use Contest\PageBuilders\Templates\RatingList;
use Contest\PageBuilders\Templates\RegisterConfirm;
use Contest\PageBuilders\Templates\RegisterForm;
use Contest\PageBuilders\Templates\ResetPassword;
use Contest\PageBuilders\Templates\ResultList;
use Contest\PageBuilders\Templates\ResultTable;
use Contest\PageBuilders\Templates\ResultTableSource;
use Contest\PageBuilders\Templates\Top;
use Contest\PageBuilders\Templates\UpdatePassword;
use Contest\PageBuilders\Templates\UserResultList;
use Contest\PageBuilders\Templates\UsersList;
use Contest\PageBuilders\Templates\ZipUsersResultLists;

class PageBuilderManager {

    /** @var PageBuilder[] */
    private $pageList;
    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    public function __construct($contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new LoginForm($this->contest,$this->pages),
            "admin" => new Admin($this->contest,$this->pages),
            "error" => new Error($this->contest,$this->pages),
            "top" => new Top($this->contest,$this->pages),
            "usersList" => new UsersList($this->contest, $this->pages),
            "addUser" => new AddUser($this->contest, $this->pages),
            "positionsList" => new PositionsList($this->contest, $this->pages),
            "addPosition" => new AddPosition($this->contest, $this->pages),
            "contestsList" => new ContestsList($this->contest, $this->pages),
            "contestsVoteList" => new ContestsVoteList($this->contest, $this->pages),
            "contestsGroupsList" => new ContestsGroupsList($this->contest, $this->pages),
            "addContest" => new AddContest($this->contest, $this->pages),
            "addContestGroup" => new AddContestGroup($this->contest, $this->pages),
            "addOnlineVoteResult" => new AddOnlineVoteResult($this->contest, $this->pages),
            "addOpenVoteResult" => new AddOpenVoteResult($this->contest, $this->pages),
            "applicantsList" => new ApplicantsList($this->contest, $this->pages),
            "addApplicant" => new AddApplicant($this->contest, $this->pages),
            "getPdfFile" => new GetPdf($this->contest, $this->pages),
            "ratingList" => new RatingList($this->contest, $this->pages),
            "resultList" => new ResultList($this->contest, $this->pages),
            "resultTable" => new ResultTable($this->contest, $this->pages),
            "resultTableSource" => new ResultTableSource($this->contest, $this->pages),
            "protocolWord" => new ProtocolWord($this->contest, $this->pages),
            "registerConfirm" => new RegisterConfirm($this->contest, $this->pages),
            "register" => new RegisterForm($this->contest, $this->pages),
            "resetPassword" => new ResetPassword($this->contest, $this->pages),
            "updatePassword" => new UpdatePassword($this->contest, $this->pages),
            "getSign" => new GetSign($this->contest,$this->pages),
            "userResultList" => new UserResultList($this->contest, $this->pages),
            "zipUsersResultLists" => new ZipUsersResultLists($this->contest, $this->pages),
            "downloads" => new Downloads($this->contest, $this->pages),
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->contest->setPageBuilder($this->pageList[$name]);
        } else {
            $this->contest->setPageBuilder($this->pageList['error']);
        }
    }

}