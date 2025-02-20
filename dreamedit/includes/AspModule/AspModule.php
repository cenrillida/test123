<?php

namespace AspModule;

use AspModule\DocumentBuilders\DocumentBuilder;
use AspModule\DocumentBuilders\DocumentBuilderManager;
use AspModule\Models\User;
use AspModule\PageBuilders\PageBuilder;
use AspModule\PageBuilders\PageBuilderManager;
use AspModule\Services\AccountService;
use AspModule\Services\AddDataService;
use AspModule\Services\AdminEditService;
use AspModule\Services\ApplicationsYearService;
use AspModule\Services\ApplyForEntryService;
use AspModule\Services\ApplyForEntryUploadService;
use AspModule\Services\AuthorizationService;
use AspModule\Services\ChangeUserStatusService;
use AspModule\Services\DepartmentService;
use AspModule\Services\DocumentApplicationService;
use AspModule\Services\DocumentApplicationStatusService;
use AspModule\Services\DocumentService;
use AspModule\Services\DocumentUploadService;
use AspModule\Services\DownloadService;
use AspModule\Services\FieldErrorService;
use AspModule\Services\FieldOfStudyService;
use AspModule\Services\RegistrationService;
use AspModule\Services\ScienceWorkService;
use AspModule\Services\StatusService;
use AspModule\Services\TechSupportService;
use AspModule\Services\UserService;
use AspModule\Services\XlsxService;

class AspModule {

    private static $instance = null;

    /** @var UserService */
    private $userService;
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
    /** @var AddDataService */
    private $addDataService;
    /** @var DocumentService */
    private $documentService;
    /** @var PageBuilderManager */
    private $pageBuilderManager;
    /** @var FieldOfStudyService */
    private $fieldOfStudyService;
    /** @var DocumentApplicationService */
    private $documentApplicationService;
    /** @var StatusService */
    private $statusService;
    /** @var DownloadService */
    private $downloadService;
    /** @var DocumentBuilder */
    private $documentBuilder = null;
    /** @var DocumentBuilderManager */
    private $documentBuilderManager;
    /** @var DocumentUploadService */
    private $documentUploadService;
    /** @var TechSupportService */
    private $techSupportService;
    /** @var ChangeUserStatusService */
    private $changeUserStatusService;
    /** @var AdminEditService */
    private $adminEditService;
    /** @var XlsxService */
    private $xlsxService;
    /** @var ApplyForEntryService */
    private $applyForEntryService;
    /** @var ApplyForEntryUploadService */
    private $applyForEntryUploadService;
    /** @var DepartmentService */
    private $departmentService;
    /** @var FieldErrorService */
    private $fieldErrorService;
    /** @var ApplicationsYearService */
    private $applicationsYearService;
    /** @var ScienceWorkService */
    private $scienceWorkService;
    /** @var DocumentApplicationStatusService */
    private $documentApplicationStatusService;

    private function __construct()
    {
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $this->pages = new \Pages();

        $this->userService = new UserService($this);
        $this->authorizationService = new AuthorizationService($this);
        $this->registrationService = new RegistrationService($this,$this->pages);
        $this->accountService = new AccountService($this);
        $this->documentService = new DocumentService($this);
        $this->pageBuilderManager = new PageBuilderManager($this,$this->pages);
        $this->addDataService = new AddDataService($this,$this->pages);
        $this->fieldOfStudyService = new FieldOfStudyService();
        $this->documentApplicationService = new DocumentApplicationService($this,$this->pages);
        $this->statusService = new StatusService($this);
        $this->downloadService = new DownloadService($this);
        $this->documentBuilderManager = new DocumentBuilderManager($this);
        $this->documentUploadService = new DocumentUploadService($this,$this->pages);
        $this->techSupportService = new TechSupportService($this,$this->pages);
        $this->changeUserStatusService = new ChangeUserStatusService($this,$this->pages);
        $this->adminEditService = new AdminEditService($this,$this->pages);
        $this->xlsxService = new XlsxService($this,$this->pages);
        $this->applyForEntryService = new ApplyForEntryService($this,$this->pages);
        $this->applyForEntryUploadService = new ApplyForEntryUploadService($this,$this->pages);
        $this->departmentService = new DepartmentService($this);
        $this->fieldErrorService = new FieldErrorService($this);
        $this->applicationsYearService = new ApplicationsYearService();
        $this->scienceWorkService = new ScienceWorkService();
        $this->documentApplicationStatusService = new DocumentApplicationStatusService();
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
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->authorizationService->getCurrentUser();
    }

    /**
     * @param PageBuilder $pageBuilder
     */
    public function setAspPageBuilder($pageBuilder)
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
     * @return PageBuilderManager
     */
    public function getPageBuilderManager()
    {
        return $this->pageBuilderManager;
    }

    /**
     * @return AddDataService
     */
    public function getAddDataService()
    {
        return $this->addDataService;
    }

    /**
     * @return FieldOfStudyService
     */
    public function getFieldOfStudyService()
    {
        return $this->fieldOfStudyService;
    }

    /**
     * @return DocumentApplicationService
     */
    public function getDocumentApplicationService()
    {
        return $this->documentApplicationService;
    }

    /**
     * @return DocumentBuilderManager
     */
    public function getDocumentBuilderManager()
    {
        return $this->documentBuilderManager;
    }

    /**
     * @return DocumentUploadService
     */
    public function getDocumentUploadService()
    {
        return $this->documentUploadService;
    }

    /**
     * @return TechSupportService
     */
    public function getTechSupportService()
    {
        return $this->techSupportService;
    }

    /**
     * @return ChangeUserStatusService
     */
    public function getChangeUserStatusService()
    {
        return $this->changeUserStatusService;
    }

    /**
     * @return AdminEditService
     */
    public function getAdminEditService()
    {
        return $this->adminEditService;
    }

    /**
     * @return XlsxService
     */
    public function getXlsxService()
    {
        return $this->xlsxService;
    }

    /**
     * @return ApplyForEntryService
     */
    public function getApplyForEntryService()
    {
        return $this->applyForEntryService;
    }

    /**
     * @return ApplyForEntryUploadService
     */
    public function getApplyForEntryUploadService()
    {
        return $this->applyForEntryUploadService;
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
     * @return DocumentService
     */
    public function getDocumentService()
    {
        return $this->documentService;
    }

    /**
     * @return DownloadService
     */
    public function getDownloadService()
    {
        return $this->downloadService;
    }

    /**
     * @return PageBuilder
     */
    public function getPageBuilder()
    {
        return $this->pageBuilder;
    }

    /**
     * @return DocumentBuilder
     */
    public function getDocumentBuilder()
    {
        return $this->documentBuilder;
    }

    /**
     * @param DocumentBuilder $documentBuilder
     */
    public function setDocumentBuilder($documentBuilder)
    {
        $this->documentBuilder = $documentBuilder;
    }

    /**
     * @return DepartmentService
     */
    public function getDepartmentService()
    {
        return $this->departmentService;
    }

    /**
     * @return FieldErrorService
     */
    public function getFieldErrorService()
    {
        return $this->fieldErrorService;
    }

    /**
     * @return ApplicationsYearService
     */
    public function getApplicationsYearService()
    {
        return $this->applicationsYearService;
    }

    /**
     * @return ScienceWorkService
     */
    public function getScienceWorkService()
    {
        return $this->scienceWorkService;
    }

    /**
     * @return DocumentApplicationStatusService
     */
    public function getDocumentApplicationStatusService()
    {
        return $this->documentApplicationStatusService;
    }

}