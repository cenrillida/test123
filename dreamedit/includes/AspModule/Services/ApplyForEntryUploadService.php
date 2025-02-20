<?php

namespace AspModule\Services;

use AspModule\AspModule;

class ApplyForEntryUploadService {

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
        if($status->isCanApplyForEntrySend() && $status->getNextStatus()!=0 && !empty($fields['pdf_apply_for_entry'])) {
            if($this->aspModule->getUserService()->updateStatus($id,$email,$status->getNextStatus())) {
                $fields['pdf_last_upload_date'] = date("Y-m-d H:i:s");
                if($this->aspModule->getUserService()->updateData($id, $email, $fields)) {
                    return true;
                }
                return false;
            }
            return false;
        }
        if($status->isCanApplyForEntrySend() && !empty($fields['pdf_apply_for_entry'])) {
            if($this->aspModule->getUserService()->updateData($id, $email, $fields)) {
                return true;
            }
        }
        return false;
    }

}