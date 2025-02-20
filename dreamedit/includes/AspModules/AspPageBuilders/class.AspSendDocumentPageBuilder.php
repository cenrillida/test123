<?php

class AspSendDocumentPageBuilder implements AspPageBuilder {
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
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">��������! ��������� ��������� ��������� ������ ����� ������� �� ������ "������ ���������".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                           role="button">��������� � ������ �������</a>
                    </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">���������� �� ������ � ������ ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">����������� ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">�����</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!$status->isDocumentSendAllow()) {
            echo "������ �������.";
        } else {
            if($currentUser->getPdfApplication()=="" || $currentUser->getPdfPersonalSheet()=="" || $currentUser->getPdfPersonalDocument()=="" || $currentUser->getPdfAutoBiography()=="") {
                echo "������ ��� ������ ���������, ��������� ��� ����������� ��������� �� ������ \"��������� ���������\"";
            } else {
                if($this->aspModule->getAspModuleUserManager()->updateStatus($currentUser->getId(),$currentUser->getEmail(),$status->getNextStatus())) {

                    $data = array();
                    $data['pdf_last_upload_date'] = date("Y-m-d H:i:s");
                    $this->aspModule->getAspModuleUserManager()->updateData($currentUser->getId(),$currentUser->getEmail(),$data);
                    echo "��������� ������� ����������.";
                } else {
                    echo "������.";
                }
            }
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}