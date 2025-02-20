<?php

namespace AspModule\Services;

use AspModule\AspModule;
use AspModule\Models\User;

class AdminEditService {

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
     * @var User $user
     * @return bool
     */
    public function sendData($fields,$user) {
        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());

        if($status->isAdminAllow()) {
            if($this->aspModule->getUserService()->updateData($user->getId(), $user->getEmail(), $fields)) {
                return true;
            }
            return false;
        }
        return false;
    }

}