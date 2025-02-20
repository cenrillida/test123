<?php

namespace DissertationCouncils\PageBuilders;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\Templates\AddDissertationCouncil;
use DissertationCouncils\PageBuilders\Templates\AddUser;
use DissertationCouncils\PageBuilders\Templates\AddVote;
use DissertationCouncils\PageBuilders\Templates\Admin;
use DissertationCouncils\PageBuilders\Templates\CheckPhone;
use DissertationCouncils\PageBuilders\Templates\DissertationCouncilsList;
use DissertationCouncils\PageBuilders\Templates\Downloads;
use DissertationCouncils\PageBuilders\Templates\Error;
use DissertationCouncils\PageBuilders\Templates\LoginForm;
use DissertationCouncils\PageBuilders\Templates\ProtocolWord;
use DissertationCouncils\PageBuilders\Templates\RegisterConfirm;
use DissertationCouncils\PageBuilders\Templates\RegisterForm;
use DissertationCouncils\PageBuilders\Templates\ResetPassword;
use DissertationCouncils\PageBuilders\Templates\Result;
use DissertationCouncils\PageBuilders\Templates\ResultTable;
use DissertationCouncils\PageBuilders\Templates\ResultTableSource;
use DissertationCouncils\PageBuilders\Templates\SmsAuthForm;
use DissertationCouncils\PageBuilders\Templates\Top;
use DissertationCouncils\PageBuilders\Templates\UpdatePassword;
use DissertationCouncils\PageBuilders\Templates\UsersList;
use DissertationCouncils\PageBuilders\Templates\Vote;
use DissertationCouncils\PageBuilders\Templates\VoteList;

class PageBuilderManager {

    /** @var PageBuilder[] */
    private $pageList;
    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    public function __construct($dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new LoginForm($this->dissertationCouncils,$this->pages),
            "admin" => new Admin($this->dissertationCouncils,$this->pages),
            "error" => new Error($this->dissertationCouncils,$this->pages),
            "top" => new Top($this->dissertationCouncils,$this->pages),
            "registerConfirm" => new RegisterConfirm($this->dissertationCouncils, $this->pages),
            "register" => new RegisterForm($this->dissertationCouncils, $this->pages),
            "resetPassword" => new ResetPassword($this->dissertationCouncils, $this->pages),
            "updatePassword" => new UpdatePassword($this->dissertationCouncils, $this->pages),
            "smsAuth" => new SmsAuthForm($this->dissertationCouncils, $this->pages),
            "checkPhone" => new CheckPhone($this->dissertationCouncils, $this->pages),
            "usersList" => new UsersList($this->dissertationCouncils, $this->pages),
            "addUser" => new AddUser($this->dissertationCouncils, $this->pages),
            "dissertationCouncilsList" => new DissertationCouncilsList($this->dissertationCouncils, $this->pages),
            "addDissertationCouncil" => new AddDissertationCouncil($this->dissertationCouncils, $this->pages),
            "voteList" => new VoteList($this->dissertationCouncils, $this->pages),
            "addVote" => new AddVote($this->dissertationCouncils, $this->pages),
            "vote" => new Vote($this->dissertationCouncils, $this->pages),
            "resultTable" => new ResultTable($this->dissertationCouncils, $this->pages),
            "resultTableSource" => new ResultTableSource($this->dissertationCouncils, $this->pages),
            "result" => new Result($this->dissertationCouncils, $this->pages),
            "protocolWord" => new ProtocolWord($this->dissertationCouncils, $this->pages),
            "downloads" => new Downloads($this->dissertationCouncils, $this->pages)
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->dissertationCouncils->setPageBuilder($this->pageList[$name]);
        } else {
            $this->dissertationCouncils->setPageBuilder($this->pageList['error']);
        }
    }

}