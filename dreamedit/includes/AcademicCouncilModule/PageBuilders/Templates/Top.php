<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class Top implements PageBuilder {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    /**
     * Top constructor.
     * @param AcademicCouncilModule $academicCouncilModule
     * @param \Pages $pages
     */
    public function __construct(AcademicCouncilModule $academicCouncilModule, $pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }


    public function build($params = array())
    {

        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode']) && $params['main_back']):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                               role="button">Главная страница личного кабинета</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
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