<?php

namespace AspModule\Services;

use AspModule\AspModule;

class ApplyForEntryService {

    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
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
        $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());

        if($status->isCanApplyForEntry() && $status->getNextStatus()!=0) {
            if($this->aspModule->getUserService()->updateStatus($id,$email,$status->getNextStatus())) {
                if($this->aspModule->getUserService()->updateData($id, $email, $fields)) {
                    return true;
                }
                return false;
            }
            return false;
        }
        if($status->isCanEditApplyForEntry()) {
            if($this->aspModule->getUserService()->updateData($id, $email, $fields)) {
                return true;
            }
        }
        return false;
    }

}