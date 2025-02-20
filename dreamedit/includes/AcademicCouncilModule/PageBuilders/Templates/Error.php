<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class Error implements PageBuilder {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    /**
     * Error constructor.
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
        global $DB,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()):
            $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("top");
            $this->academicCouncilModule->getPageBuilder()->build(array("main_back" => true));
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