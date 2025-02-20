<?php

class AspDocumentUploadService {

    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    /**
     * @return bool
     */
    public function sendData($fields) {
        $currentUser = $this->aspModule->getCurrentUser();
        $id = $currentUser->getId();
        $email = $currentUser->getEmail();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());
        if($status->isDocumentUploadAllow() || ($status->isEducationCanUpload() && $currentUser->getPdfEducation()=="") || ($status->isEducationCanUpload() && $status->isDocumentSendAllow())) {
            if($this->aspModule->getAspModuleUserManager()->updateData($id, $email, $fields)) {
                return true;
            }
        }
        return false;
    }

}