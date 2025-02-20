<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class Error implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * Error constructor.
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
        global $DB,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->contest->getAuthorizationService()->isAuthorized()):
            $this->contest->getPageBuilderManager()->setPageBuilder("top");
            $this->contest->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
            <div class="mt-3"></div>
            <div class="alert alert-danger" role="alert">
                <?php if(!empty($params['error'])) echo $params['error']; else echo 'Ошибка. Нет доступа';?>
            </div>
        <?php

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}