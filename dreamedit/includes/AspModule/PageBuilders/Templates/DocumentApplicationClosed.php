<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class DocumentApplicationClosed implements PageBuilder {
    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build();
            $currentUser = $this->aspModule->getCurrentUser();
            ?>
        <?php endif;?>
        <div class="mb-2">
            <h5 class="font-weight-bold">Подача документов закрыта</h5>
        </div>
        <div>
            <?php if(!$currentUser->isForDissertationAttachment()):?>
                <?=\Dreamedit::LineBreakToBrAll($this->aspModule->getDocumentApplicationStatusService()->getClosedTextStudy())?>
            <?php else:?>
                <?=\Dreamedit::LineBreakToBrAll($this->aspModule->getDocumentApplicationStatusService()->getClosedTextDissertation())?>
            <?php endif;?>
        </div>
        <?php
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}