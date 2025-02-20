<?php

namespace Contest;

use Contest\Models\User;
use Contest\PageBuilders\PageBuilder;
use Contest\PageBuilders\PageBuilderManager;
use Contest\Services\AccountService;
use Contest\Services\AntiSpamService;
use Contest\Services\ApplicantService;
use Contest\Services\AuthorizationService;
use Contest\Services\ContestGroupService;
use Contest\Services\ContestService;
use Contest\Services\DepartmentService;
use Contest\Services\DocumentService;
use Contest\Services\DownloadService;
use Contest\Services\OnlineVoteService;
use Contest\Services\OpenVoteService;
use Contest\Services\PositionService;
use Contest\Services\RegistrationService;
use Contest\Services\StatusService;
use Contest\Services\UserService;

class Contest {

    /** @var Contest */
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
    /** @var ContestService */
    private $contestService;
    /** @var ContestGroupService */
    private $contestGroupService;
    /** @var ApplicantService */
    private $applicantService;
    /** @var DownloadService */
    private $downloadService;
    /** @var DocumentService */
    private $documentService;
    /** @var OpenVoteService */
    private $openVoteService;
    /** @var OnlineVoteService */
    private $onlineVoteService;
    /** @var PositionService */
    private $positionService;
    /** @var DepartmentService */
    private $departmentService;
    /** @var AntiSpamService */
    private $antiSpamService;
    /** @var PageBuilderManager */
    private $pageBuilderManager;

    private function __construct()
    {
        $this->pages = new \Pages();

        $this->pageBuilderManager = new PageBuilderManager($this,$this->pages);
        $this->authorizationService = new AuthorizationService($this);
        $this->accountService = new AccountService($this);
        $this->userService = new UserService($this);
        $this->statusService = new StatusService($this);
        $this->contestService = new ContestService($this);
        $this->applicantService = new ApplicantService($this);
        $this->downloadService = new DownloadService($this);
        $this->documentService = new DocumentService($this);
        $this->contestGroupService = new ContestGroupService($this);
        $this->openVoteService = new OpenVoteService($this);
        $this->onlineVoteService = new OnlineVoteService($this);
        $this->positionService = new PositionService($this);
        $this->departmentService = new DepartmentService($this);
        $this->registrationService = new RegistrationService($this);
        $this->antiSpamService = new AntiSpamService($this);
    }

    /**
     * @return Contest
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new Contest();
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
     * @return AuthorizationService
     */
    public function getAuthorizationService()
    {
        return $this->authorizationService;
    }

    /**
     * @return PageBuilderManager
     */
    public function getPageBuilderManager()
    {
        return $this->pageBuilderManager;
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
     * @return ContestService
     */
    public function getContestService()
    {
        return $this->contestService;
    }

    /**
     * @return ApplicantService
     */
    public function getApplicantService()
    {
        return $this->applicantService;
    }

    /**
     * @return DownloadService
     */
    public function getDownloadService()
    {
        return $this->downloadService;
    }

    /**
     * @return DocumentService
     */
    public function getDocumentService()
    {
        return $this->documentService;
    }

    /**
     * @return ContestGroupService
     */
    public function getContestGroupService()
    {
        return $this->contestGroupService;
    }

    /**
     * @return OpenVoteService
     */
    public function getOpenVoteService()
    {
        return $this->openVoteService;
    }

    /**
     * @return OnlineVoteService
     */
    public function getOnlineVoteService()
    {
        return $this->onlineVoteService;
    }

    /**
     * @return PositionService
     */
    public function getPositionService()
    {
        return $this->positionService;
    }

    /**
     * @return DepartmentService
     */
    public function getDepartmentService()
    {
        return $this->departmentService;
    }

    /**
     * @return RegistrationService
     */
    public function getRegistrationService()
    {
        return $this->registrationService;
    }

    /**
     * @return AntiSpamService
     */
    public function getAntiSpamService()
    {
        return $this->antiSpamService;
    }

}