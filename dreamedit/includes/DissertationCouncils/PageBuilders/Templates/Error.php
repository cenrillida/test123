<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\PageBuilder;

class Error implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * Error constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->dissertationCouncils->getAuthorizationService()->isAuthorized()):
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
            $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));
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