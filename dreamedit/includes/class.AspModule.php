<?php

require_once "AspModules/class.AspFieldOfStudyManager.php";
require_once "AspModules/class.AspPageBuilder.php";
require_once "AspModules/class.AspFormBuilders.php";
require_once "AspModules/class.AspAuthorizationService.php";
require_once "AspModules/class.AspRegistrationService.php";
require_once "AspModules/class.AspAddDataService.php";
require_once "AspModules/class.AspModuleUser.php";
require_once "AspModules/class.AspAccountManager.php";
require_once "AspModules/class.AspDocumentService.php";
require_once "AspModules/class.AspPageBuilderManager.php";
require_once "AspModules/class.AspDocumentApplicationService.php";
require_once "AspModules/class.AspDocumentUploadService.php";
require_once "AspModules/class.AspStatusManager.php";
require_once "AspModules/class.AspDownloadService.php";
require_once "AspModules/class.AspDocumentTemplater.php";
require_once "AspModules/class.AspDocumentTemplaterManager.php";
require_once "AspModules/class.AspTechSupportService.php";
require_once "AspModules/class.AspChangeUserStatusService.php";
require_once "AspModules/class.AspAdminEditService.php";
require_once "AspModules/class.AspApplyForEntryService.php";
require_once "AspModules/class.AspApplyForEntryUploadService.php";
require_once "AspModules/class.AspXlsxService.php";


class AspModule {

    private static $instance = null;

    /** @var AspModuleUserManager */
    private $aspModuleUserManager;
    /** @var Pages */
    private $pages;
    /** @var AspPageBuilder */
    private $aspPageBuilder = null;
    /** @var AspAuthorizationService */
    private $aspAuthorizationService;
    /** @var AspRegistrationService */
    private $aspRegistrationService;
    /** @var AspAccountManager */
    private $aspAccountManager;
    /** @var AspAddDataService */
    private $aspAddDataService;
    /** @var AspDocumentService */
    private $aspDocumentService;
    /** @var AspPageBuilderManager */
    private $aspPageBuilderManager;
    /** @var AspFieldOfStudyManager */
    private $aspFieldOfStudyManager;
    /** @var AspDocumentApplicationService */
    private $aspDocumentApplicationService;
    /** @var AspStatusManager */
    private $aspStatusManager;
    /** @var AspDownloadService */
    private $aspDownloadService;
    /** @var AspDocumentTemplater */
    private $aspDocumentTemplater = null;
    /** @var AspDocumentTemplaterManager */
    private $aspDocumentTemplaterManager;
    /** @var AspDocumentUploadService */
    private $aspDocumentUploadService;
    /** @var AspTechSupportService */
    private $aspTechSupportService;
    /** @var AspChangeUserStatusService */
    private $aspChangeUserStatusService;
    /** @var AspAdminEditService */
    private $aspAdminEditService;
    /** @var AspXlsxService */
    private $aspXlsxService;
    /** @var AspApplyForEntryService */
    private $aspApplyForEntryService;
    /** @var AspApplyForEntryUploadService */
    private $aspApplyForEntryUploadService;

    private function __construct()
    {
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $this->pages = new Pages();

        $this->aspModuleUserManager = new AspModuleUserManager($this);
        $this->aspAuthorizationService = new AspAuthorizationService($this);
        $this->aspRegistrationService = new AspRegistrationService($this,$this->pages);
        $this->aspAccountManager = new AspAccountManager($this);
        $this->aspDocumentService = new AspDocumentService($this);
        $this->aspPageBuilderManager = new AspPageBuilderManager($this,$this->pages);
        $this->aspAddDataService = new AspAddDataService($this,$this->pages);
        $this->aspFieldOfStudyManager = new AspFieldOfStudyManager();
        $this->aspDocumentApplicationService = new AspDocumentApplicationService($this,$this->pages);
        $this->aspStatusManager = new AspStatusManager($this);
        $this->aspDownloadService = new AspDownloadService($this);
        $this->aspDocumentTemplaterManager = new AspDocumentTemplaterManager($this);
        $this->aspDocumentUploadService = new AspDocumentUploadService($this,$this->pages);
        $this->aspTechSupportService = new AspTechSupportService($this,$this->pages);
        $this->aspChangeUserStatusService = new AspChangeUserStatusService($this,$this->pages);
        $this->aspAdminEditService = new AspAdminEditService($this,$this->pages);
        $this->aspXlsxService = new AspXlsxService($this,$this->pages);
        $this->aspApplyForEntryService = new AspApplyForEntryService($this,$this->pages);
        $this->aspApplyForEntryUploadService = new AspApplyForEntryUploadService($this,$this->pages);
    }

    /**
     * @return AspModule
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new AspModule();
        }

        return self::$instance;
    }

    /**
     * @return AspModuleUser
     */
    public function getCurrentUser()
    {
        return $this->aspAuthorizationService->getCurrentUser();
    }

    /**
     * @return AspPageBuilder
     */
    public function getAspPageBuilder()
    {
        return $this->aspPageBuilder;
    }

    /**
     * @param AspPageBuilder $aspPageBuilder
     */
    public function setAspPageBuilder($aspPageBuilder)
    {
        $this->aspPageBuilder = $aspPageBuilder;
    }

    /**
     * @return AspModuleUserManager
     */
    public function getAspModuleUserManager()
    {
        return $this->aspModuleUserManager;
    }

    /**
     * @return AspAuthorizationService
     */
    public function getAspAuthorizationService()
    {
        return $this->aspAuthorizationService;
    }

    /**
     * @return AspRegistrationService
     */
    public function getAspRegistrationService()
    {
        return $this->aspRegistrationService;
    }

    /**
     * @return AspAccountManager
     */
    public function getAspAccountManager()
    {
        return $this->aspAccountManager;
    }

    /**
     * @return AspDocumentService
     */
    public function getAspDocumentService()
    {
        return $this->aspDocumentService;
    }

    /**
     * @return AspPageBuilderManager
     */
    public function getAspPageBuilderManager()
    {
        return $this->aspPageBuilderManager;
    }

    /**
     * @return AspAddDataService
     */
    public function getAspAddDataService()
    {
        return $this->aspAddDataService;
    }

    /**
     * @return AspFieldOfStudyManager
     */
    public function getAspFieldOfStudyManager()
    {
        return $this->aspFieldOfStudyManager;
    }

    /**
     * @return AspDocumentApplicationService
     */
    public function getAspDocumentApplicationService()
    {
        return $this->aspDocumentApplicationService;
    }

    /**
     * @return AspStatusManager
     */
    public function getAspStatusManager()
    {
        return $this->aspStatusManager;
    }

    /**
     * @return AspDownloadService
     */
    public function getAspDownloadService()
    {
        return $this->aspDownloadService;
    }

    /**
     * @return AspDocumentTemplaterManager
     */
    public function getAspDocumentTemplaterManager()
    {
        return $this->aspDocumentTemplaterManager;
    }

    /**
     * @return AspDocumentTemplater
     */
    public function getAspDocumentTemplater()
    {
        return $this->aspDocumentTemplater;
    }

    /**
     * @param AspDocumentTemplater $aspDocumentTemplater
     */
    public function setAspDocumentTemplater($aspDocumentTemplater)
    {
        $this->aspDocumentTemplater = $aspDocumentTemplater;
    }

    /**
     * @return AspDocumentUploadService
     */
    public function getAspDocumentUploadService()
    {
        return $this->aspDocumentUploadService;
    }

    /**
     * @return AspTechSupportService
     */
    public function getAspTechSupportService()
    {
        return $this->aspTechSupportService;
    }

    /**
     * @return AspChangeUserStatusService
     */
    public function getAspChangeUserStatusService()
    {
        return $this->aspChangeUserStatusService;
    }

    /**
     * @return AspAdminEditService
     */
    public function getAspAdminEditService()
    {
        return $this->aspAdminEditService;
    }

    /**
     * @return AspXlsxService
     */
    public function getAspXlsxService()
    {
        return $this->aspXlsxService;
    }

    /**
     * @return AspApplyForEntryService
     */
    public function getAspApplyForEntryService()
    {
        return $this->aspApplyForEntryService;
    }

    /**
     * @return AspApplyForEntryUploadService
     */
    public function getAspApplyForEntryUploadService()
    {
        return $this->aspApplyForEntryUploadService;
    }
}