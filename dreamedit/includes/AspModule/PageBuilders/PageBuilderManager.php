<?php

namespace AspModule\PageBuilders;

use AspModule\AspModule;
use AspModule\PageBuilders\Templates\AddApplicationsYear;
use AspModule\PageBuilders\Templates\AddData;
use AspModule\PageBuilders\Templates\AdminTable;
use AspModule\PageBuilders\Templates\AdminTableSource;
use AspModule\PageBuilders\Templates\AdminTableUpdate;
use AspModule\PageBuilders\Templates\ApplicationsYears;
use AspModule\PageBuilders\Templates\ApplyForEntry;
use AspModule\PageBuilders\Templates\ApplyForEntryUpload;
use AspModule\PageBuilders\Templates\ChangeUserStatus;
use AspModule\PageBuilders\Templates\CreateDocument;
use AspModule\PageBuilders\Templates\CreateUser;
use AspModule\PageBuilders\Templates\DocumentApplication;
use AspModule\PageBuilders\Templates\DocumentApplicationClosed;
use AspModule\PageBuilders\Templates\DocumentApplicationControl;
use AspModule\PageBuilders\Templates\DocumentUpload;
use AspModule\PageBuilders\Templates\EditReg;
use AspModule\PageBuilders\Templates\EducationChoose;
use AspModule\PageBuilders\Templates\EducationUpload;
use AspModule\PageBuilders\Templates\Error;
use AspModule\PageBuilders\Templates\Faq;
use AspModule\PageBuilders\Templates\GetPdf;
use AspModule\PageBuilders\Templates\LoginForm;
use AspModule\PageBuilders\Templates\Personal;
use AspModule\PageBuilders\Templates\Photo;
use AspModule\PageBuilders\Templates\RegisterConfirm;
use AspModule\PageBuilders\Templates\RegisterForm;
use AspModule\PageBuilders\Templates\ResetPassword;
use AspModule\PageBuilders\Templates\SendDocument;
use AspModule\PageBuilders\Templates\TechSupport;
use AspModule\PageBuilders\Templates\Top;
use AspModule\PageBuilders\Templates\UpdatePasswordForm;
use AspModule\PageBuilders\Templates\UserData;
use AspModule\PageBuilders\Templates\Xlsx;

class PageBuilderManager {

    /** @var PageBuilder[] */
    private $pageList;
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new LoginForm($this->aspModule,$this->pages),
            "register" => new RegisterForm($this->aspModule,$this->pages),
            "registerConfirm" => new RegisterConfirm($this->aspModule,$this->pages),
            "error" => new Error($this->aspModule,$this->pages),
            "top" => new Top($this->aspModule,$this->pages),
            "personal" => new Personal($this->aspModule,$this->pages),
            "passwordReset" => new ResetPassword($this->aspModule,$this->pages),
            "passwordUpdate" => new UpdatePasswordForm($this->aspModule,$this->pages),
            "addData" => new AddData($this->aspModule,$this->pages),
            "documentApplication" => new DocumentApplication($this->aspModule,$this->pages),
            "getUserPhoto" => new Photo($this->aspModule,$this->pages),
            "createDocument" => new CreateDocument($this->aspModule,$this->pages),
            "uploadDocument" => new DocumentUpload($this->aspModule,$this->pages),
            "getPdfFile" => new GetPdf($this->aspModule,$this->pages),
            "sendDocument" => new SendDocument($this->aspModule,$this->pages),
            "techSupportContact" => new TechSupport($this->aspModule,$this->pages),
            "faq" => new Faq($this->aspModule,$this->pages),
            "adminTable" => new AdminTable($this->aspModule,$this->pages),
            "adminTableSource" => new AdminTableSource($this->aspModule,$this->pages),
            "adminTableUpdate" => new AdminTableUpdate($this->aspModule,$this->pages),
            "changeUserStatus" => new ChangeUserStatus($this->aspModule,$this->pages),
            "getUserData" => new UserData($this->aspModule,$this->pages),
            "editRegData" => new EditReg($this->aspModule,$this->pages),
            "addEducation" => new EducationChoose($this->aspModule,$this->pages),
            "educationUpload" => new EducationUpload($this->aspModule,$this->pages),
            "createXlsx" => new Xlsx($this->aspModule,$this->pages),
            "applyForEntry" => new ApplyForEntry($this->aspModule,$this->pages),
            "applyForEntryUpload" => new ApplyForEntryUpload($this->aspModule,$this->pages),
            "applicationsYears" => new ApplicationsYears($this->aspModule,$this->pages),
            "addApplicationsYear" => new AddApplicationsYear($this->aspModule,$this->pages),
            "createUser" => new CreateUser($this->aspModule,$this->pages),
            "documentApplicationClosed" => new DocumentApplicationClosed($this->aspModule),
            "documentApplicationControl" => new DocumentApplicationControl($this->aspModule),
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->aspModule->setAspPageBuilder($this->pageList[$name]);
        }
    }

}