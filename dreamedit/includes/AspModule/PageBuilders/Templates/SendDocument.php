<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class SendDocument implements PageBuilder {
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
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <?php
        if(!$status->isDocumentSendAllow()) {
            echo "������ �������.";
        } else {
            if($currentUser->cantSendDocuments()) {
                echo "������ ��� ������ ���������, ��������� ��� ����������� ��������� �� ������ \"��������� ���������\"";
            } else {
                if($this->aspModule->getUserService()->updateStatus($currentUser->getId(),$currentUser->getEmail(),$status->getNextStatus())) {

                    $data = array();
                    $data['pdf_last_upload_date'] = date("Y-m-d H:i:s");
                    $this->aspModule->getUserService()->updateData($currentUser->getId(),$currentUser->getEmail(),$data);
                    echo "��������� ������� ����������.";
                } else {
                    echo "������.";
                }
            }
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}