<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class Admin implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * Admin constructor.
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
        global $DB,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->crossref->getAuthorizationService()->isAuthorized()):
            $this->crossref->getPageBuilderManager()->setPageBuilder("top");
            $this->crossref->getPageBuilder()->build(array("main_back" => true));
            ?>

            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=journalsList"
                           role="button">∆урналы</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=publsList"
                           role="button"> ниги</a>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}