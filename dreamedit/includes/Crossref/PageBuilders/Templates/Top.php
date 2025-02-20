<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class Top implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * Top constructor.
     * @param Crossref $crossref
     * @param \Pages $pages
     */
    public function __construct(Crossref $crossref, $pages)
    {
        $this->crossref = $crossref;
        $this->pages = $pages;
    }


    public function build($params = array())
    {

        $exitPageId = $this->pages->getFirstPageIdByTemplate("crossref_lk_login");
        ?>
        <div class="container-fluid">
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
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">Выход</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}