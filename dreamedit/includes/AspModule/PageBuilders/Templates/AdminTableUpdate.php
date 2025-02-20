<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class AdminTableUpdate implements PageBuilder {
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
        $currentUser = $this->aspModule->getCurrentUser();

        if($this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus())->isAdminAllow()) {
            if (!empty($_GET['delete'])) {
                $deleteId = (int)$_GET['delete'];
                $this->aspModule->getUserService()->deleteUserById($deleteId);
            }
        } else {
            echo "Ошибка доступа.";
        }
    }
}