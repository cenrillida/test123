<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class Photo implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        if(empty($_GET['user_id'])) {
            $this->aspModule->getDownloadService()->getAspPhoto($this->aspModule->getCurrentUser()->getPhoto());
        } else {
            if($this->aspModule->getStatusService()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $user = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
                if($_GET['download']!="1") {
                    $this->aspModule->getDownloadService()->getAspPhoto($user->getPhoto());
                } else {
                    $this->aspModule->getDocumentService()->getDocument("getPhoto","",$user);
                }
            } else {
                echo "Ошибка доступа.";
            }
        }
    }
}