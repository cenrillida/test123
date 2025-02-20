<?php

class AspDocumentApplicationService {

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

        if($status->isDocumentApplicationAllow() && $status->getNextStatus()!=0) {
            if($this->aspModule->getAspModuleUserManager()->updateStatus($id,$email,$status->getNextStatus())) {
                if($this->aspModule->getAspModuleUserManager()->updateData($id, $email, $fields)) {
                    return true;
                }
                return false;
            }
            return false;
        }
        if($status->isEditDocumentApplicationAllow() || ($status->isEducationCanUpload() && $currentUser->getPdfEducation()=="") || ($status->isEducationCanUpload() && $status->isDocumentSendAllow())) {
            if($this->aspModule->getAspModuleUserManager()->updateData($id, $email, $fields)) {
                return true;
            }
        }
        return false;
    }

}