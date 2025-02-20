<?php

class AspPageBuilderManager {

    /** @var AspPageBuilder[] */
    private $pageList;
    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new AspLoginFormPageBuilder($this->aspModule,$this->pages),
            "register" => new AspRegisterFormPageBuilder($this->aspModule,$this->pages),
            "personal" => new AspPersonalPageBuilder($this->aspModule,$this->pages),
            "passwordReset" => new AspResetPasswordFormPageBuilder($this->aspModule,$this->pages),
            "passwordUpdate" => new AspUpdatePasswordFormPageBuilder($this->aspModule,$this->pages),
            "addData" => new AspAddDataPageBuilder($this->aspModule,$this->pages),
            "documentApplication" => new AspDocumentApplicationPageBuilder($this->aspModule,$this->pages),
            "getUserPhoto" => new AspPhotoPageBuilder($this->aspModule,$this->pages),
            "createDocument" => new AspCreateDocumentPageBuilder($this->aspModule,$this->pages),
            "uploadDocument" => new AspDocumentUploadPageBuilder($this->aspModule,$this->pages),
            "getPdfFile" => new AspGetPdfPageBuilder($this->aspModule,$this->pages),
            "sendDocument" => new AspSendDocumentPageBuilder($this->aspModule,$this->pages),
            "techSupportContact" => new AspTechSupportPageBuilder($this->aspModule,$this->pages),
            "adminTable" => new AspAdminTablePageBuilder($this->aspModule,$this->pages),
            "adminTableSource" => new AspAdminTablePageSourceBuilder($this->aspModule,$this->pages),
            "changeUserStatus" => new AspChangeUserStatusPageBuilder($this->aspModule,$this->pages),
            "getUserData" => new AspUserDataPageBuilder($this->aspModule,$this->pages),
            "editRegData" => new AspEditRegDataPageBuilder($this->aspModule,$this->pages),
            "addEducation" => new AspEducationChoosePageBuilder($this->aspModule,$this->pages),
            "educationUpload" => new AspEducationUploadPageBuilder($this->aspModule,$this->pages),
            "createXlsx" => new AspXlsxPageBuilder($this->aspModule,$this->pages),
            "applyForEntry" => new AspApplyForEntryPageBuilder($this->aspModule,$this->pages),
            "applyForEntryUpload" => new AspApplyForEntryUploadPageBuilder($this->aspModule,$this->pages)
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->aspModule->setAspPageBuilder($this->pageList[$name]);
        }
    }

}