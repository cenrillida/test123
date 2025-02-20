<?php

require_once "AcademicCouncilPageBuilder.php";
require_once "class.AcademicCouncilAuthorizationService.php";
require_once "class.AcademicCouncilQuestionnaireService.php";
require_once "class.AcademicCouncilFormBuilders.php";
require_once "class.AcademicCouncilPageBuilderManager.php";
require_once "class.AcademicCouncilAccountManager.php";
require_once "class.AcademicCouncilDownloadService.php";

class AcademicCouncilModule {

    private static $instance = null;

    /** @var Pages */
    private $pages;
    /** @var AcademicCouncilPageBuilder */
    private $academicCouncilPageBuilder = null;
    /** @var AcademicCouncilAuthorizationService */
    private $academicCouncilAuthorizationService;
    /** @var AcademicCouncilQuestionnaireService */
    private $academicCouncilQuestionnaireService;
    /** @var AcademicCouncilPageBuilderManager */
    private $academicCouncilPageBuilderManager;
    /** @var AcademicCouncilAccountManager */
    private $academicCouncilAccountManager;
    /** @var AcademicCouncilDownloadService */
    private $academicCouncilDownloadService;

    private function __construct()
    {
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $this->pages = new Pages();

        $this->academicCouncilAuthorizationService = new AcademicCouncilAuthorizationService($this);
        $this->academicCouncilPageBuilderManager = new AcademicCouncilPageBuilderManager($this,$this->pages);
        $this->academicCouncilAccountManager = new AcademicCouncilAccountManager($this);
        $this->academicCouncilQuestionnaireService = new AcademicCouncilQuestionnaireService($this,$this->pages);
        $this->academicCouncilDownloadService = new AcademicCouncilDownloadService();
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
     * @return AcademicCouncilDownloadService
     */
    public function getAcademicCouncilDownloadService()
    {
        return $this->academicCouncilDownloadService;
    }

    /**
     * @return AcademicCouncilPageBuilder
     */
    public function getAcademicCouncilPageBuilder()
    {
        return $this->academicCouncilPageBuilder;
    }

    /**
     * @param AcademicCouncilPageBuilder $academicCouncilPageBuilder
     */
    public function setAcademicCouncilPageBuilder($academicCouncilPageBuilder)
    {
        $this->academicCouncilPageBuilder = $academicCouncilPageBuilder;
    }

    /**
     * @return AcademicCouncilAuthorizationService
     */
    public function getAcademicCouncilAuthorizationService()
    {
        return $this->academicCouncilAuthorizationService;
    }

    /**
     * @return AcademicCouncilPageBuilderManager
     */
    public function getAcademicCouncilPageBuilderManager()
    {
        return $this->academicCouncilPageBuilderManager;
    }

    /**
     * @return AcademicCouncilAccountManager
     */
    public function getAcademicCouncilAccountManager()
    {
        return $this->academicCouncilAccountManager;
    }

    /**
     * @return AcademicCouncilQuestionnaireService
     */
    public function getAcademicCouncilQuestionnaireService()
    {
        return $this->academicCouncilQuestionnaireService;
    }

}