<?php

namespace AcademicCouncilModule;

use AcademicCouncilModule\PageBuilders\PageBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilderManager;
use AcademicCouncilModule\Services\AccountService;
use AcademicCouncilModule\Services\AuthorizationService;
use AcademicCouncilModule\Services\DownloadService;
use AcademicCouncilModule\Services\QuestionnaireService;

class AcademicCouncilModule {

    private static $instance = null;

    /** @var \Pages */
    private $pages;
    /** @var PageBuilder */
    private $pageBuilder = null;
    /** @var PageBuilderManager */
    private $pageBuilderManager;
    /** @var AuthorizationService */
    private $authorizationService;
    /** @var AccountService */
    private $accountService;
    /** @var QuestionnaireService */
    private $questionnaireService;
    /** @var DownloadService */
    private $downloadService;

    /**
     * AcademicCouncilModule constructor.
     */
    public function __construct()
    {
        $this->pages = new \Pages();

        $this->pageBuilderManager = new PageBuilderManager($this,$this->pages);
        $this->authorizationService = new AuthorizationService($this);
        $this->accountService = new AccountService($this);
        $this->questionnaireService = new QuestionnaireService($this,$this->pages);
        $this->downloadService = new DownloadService();
    }

    /**
     * @return AcademicCouncilModule
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new AcademicCouncilModule();
        }

        return self::$instance;
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
     * @return AccountService
     */
    public function getAccountService()
    {
        return $this->accountService;
    }

    /**
     * @return PageBuilderManager
     */
    public function getPageBuilderManager()
    {
        return $this->pageBuilderManager;
    }

    /**
     * @return PageBuilder
     */
    public function getPageBuilder()
    {
        return $this->pageBuilder;
    }

    /**
     * @return QuestionnaireService
     */
    public function getQuestionnaireService()
    {
        return $this->questionnaireService;
    }

    /**
     * @return DownloadService
     */
    public function getDownloadService()
    {
        return $this->downloadService;
    }

}