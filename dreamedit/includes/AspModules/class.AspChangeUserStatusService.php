<?php

class AspChangeUserStatusService {

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
     * @var AspModuleUser $user
     * @return bool
     */
    public function sendData($fields,$user) {
        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());

        if($status->isAdminAllow()) {
            if($this->aspModule->getAspModuleUserManager()->updateStatus($user->getId(),$user->getEmail(),$fields['status'])) {
                if($this->aspModule->getAspModuleUserManager()->updateData($user->getId(), $user->getEmail(), $fields)) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

}