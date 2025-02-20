<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class Top implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * Top constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
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