<?php

namespace DissertationCouncils;

use DissertationCouncils\PageBuilders\PageBuilder;
use DissertationCouncils\PageBuilders\PageBuilderManager;
use DissertationCouncils\Services\AccountService;
use DissertationCouncils\Services\AntiSpamService;
use DissertationCouncils\Services\AuthorizationService;
use DissertationCouncils\Services\DissertationCouncilService;
use DissertationCouncils\Services\RegistrationService;
use DissertationCouncils\Services\StatusService;
use DissertationCouncils\Services\TokenService;
use DissertationCouncils\Services\UserService;
use DissertationCouncils\Services\VoteResultService;
use DissertationCouncils\Services\VoteService;

class DissertationCouncils {

    /** @var DissertationCouncils */
    private static $_instance = null;

    /** @var \Pages */
    private $pages;
    /** @var PageBuilder */
    private $pageBuilder = null;
    /** @var AuthorizationService */
    private $authorizationService;
    /** @var RegistrationService */
    private $registrationService;
    /** @var AccountService */
    private $accountService;
    /** @var UserService */
    private $userService;
    /** @var StatusService */
    private $statusService;
    /** @var AntiSpamService */
    private $antiSpamService;
    /** @var TokenService */
    private $tokenService;
    /** @var DissertationCouncilService */
    private $dissertationCouncilService;
    /** @var VoteService */
    private $voteService;
    /** @var VoteResultService */
    private $voteResultService;
    /** @var PageBuilderManager */
    private $pageBuilderManager;

    private function __construct()
    {
        $this->pages = new \Pages();

        $this->pageBuilderManager = new PageBuilderManager($this,$this->pages);
        $this->authorizationService = new AuthorizationService($this);
        $this->registrationService = new RegistrationService($this);
        $this->accountService = new AccountService($this);
        $this->userService = new UserService($this);
        $this->statusService = new StatusService($this);
        $this->antiSpamService = new AntiSpamService($this);
        $this->tokenService = new TokenService();
        $this->dissertationCouncilService = new DissertationCouncilService($this);
        $this->voteService = new VoteService($this);
        $this->voteResultService = new VoteResultService($this);

    }

    /**
     * @return DissertationCouncils
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new DissertationCouncils();
        }
        return self::$_instance;
    }

    /**
     * @return PageBuilder
     */
    public function getPageBuilder()
    {
        return $this->pageBuilder;
    }

    /**
     * @param PageBuilder $pageBuilder
     */
    public function setPageBuilder($pageBuilder)
    {
        $this->pageBuilder = $pageBuilder;
    }

    /**
     * @return PageBuilderManager
     */
    public function getPageBuilderManager()
    {
        return $this->pageBuilderManager;
    }

    /**
     * @return AuthorizationService
     */
    public function getAuthorizationService()
    {
        return $this->authorizationService;
    }

    /**
     * @return RegistrationService
     */
    public function getRegistrationService()
    {
        return $this->registrationService;
    }

    /**
     * @return AccountService
     */
    public function getAccountService()
    {
        return $this->accountService;
    }

    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @return StatusService
     */
    public function getStatusService()
    {
        return $this->statusService;
    }

    /**
     * @return AntiSpamService
     */
    public function getAntiSpamService()
    {
        return $this->antiSpamService;
    }

    /**
     * @return TokenService
     */
    public function getTokenService()
    {
        return $this->tokenService;
    }

    /**
     * @return DissertationCouncilService
     */
    public function getDissertationCouncilService()
    {
        return $this->dissertationCouncilService;
    }

    /**
     * @return VoteService
     */
    public function getVoteService()
    {
        return $this->voteService;
    }

    /**
     * @return VoteResultService
     */
    public function getVoteResultService()
    {
        return $this->voteResultService;
    }

}