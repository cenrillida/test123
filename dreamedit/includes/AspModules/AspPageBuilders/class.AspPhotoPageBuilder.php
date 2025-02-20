<?php

class AspPhotoPageBuilder implements AspPageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build()
    {
        if(empty($_GET['user_id'])) {
            $this->aspModule->getAspDownloadService()->getAspPhoto($this->aspModule->getCurrentUser()->getPhoto());
        } else {
            if($this->aspModule->getAspStatusManager()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $user = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                if($_GET['download']!="1") {
                    $this->aspModule->getAspDownloadService()->getAspPhoto($user->getPhoto());
                } else {
                    $this->aspModule->getAspDocumentService()->getDocument("getPhoto","",$user);
                }
            } else {
                echo "Ошибка доступа.";
            }
        }
    }
}