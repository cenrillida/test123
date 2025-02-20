<?php

namespace Crossref;

use Crossref\PageBuilders\PageBuilder;
use Crossref\PageBuilders\PageBuilderManager;
use Crossref\Services\AccountService;
use Crossref\Services\AuthorizationService;
use Crossref\Services\NumberCheckService;

class Crossref {

    /** @var Crossref */
    private static $_instance = null;
    /** @var \Pages */
    private $pages;
    /** @var PageBuilder */
    private $pageBuilder = null;
    /** @var AuthorizationService */
    private $authorizationService;
    /** @var AccountService */
    private $accountService;
    /** @var NumberCheckService */
    private $numberCheckService;
    /** @var PageBuilderManager */
    private $pageBuilderManager;

    private function __construct()
    {
        $this->pages = new \Pages();

        $this->pageBuilderManager = new PageBuilderManager($this,$this->pages);
        $this->authorizationService = new AuthorizationService($this);
        $this->accountService = new AccountService($this);
        $this->numberCheckService = new NumberCheckService($this);
    }

    /**
     * @return Crossref
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new Crossref();
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
     * @return NumberCheckService
     */
    public function getNumberCheckService()
    {
        return $this->numberCheckService;
    }

}