<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class Top implements PageBuilder {
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
        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($admin->getStatus());

        ?>
        <div class="container-fluid">
            <?php if(!$status->isAdminAllow()):?>
            <div class="row justify-content-between mb-1">
                <div class="text-danger"с>Внимание! Документы считаются поданными только после нажатия на кнопку "Подать документы".</div>
            </div>
            <?php endif;?>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode']) && $params['main_back']):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                               role="button">Вернуться в личный кабинет</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <?php if(!$status->isAdminAllow()):?>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">Инструкция по работе с личным кабинетом</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=faq"
                           role="button">Техническая поддержка</a>
                    </div>
                    <?php endif;?>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=login&logout=1"
                           role="button">Выход</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}