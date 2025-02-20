<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\PageBuilder;

class DissertationCouncilsList implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * DissertationCouncilsList constructor.
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

        $currentUser = $this->dissertationCouncils->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin()) {
            $deleteModal = new \ModalWindow(
                "<i class=\"fas fa-times\"></i>",
                "deleteElement",
                "Удаление диссовета",
                "<p>Вы уверены, что хотите удалить этот диссовет?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->dissertationCouncils->getDissertationCouncilService()->deleteDissertationCouncilById($_GET['delete_id']);
                exit;
            }
        }

        if($currentUser->getStatus()->isAdmin()) {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            if ($this->dissertationCouncils->getAuthorizationService()->isAuthorized()):
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
                $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));

                if ($currentUser->getStatus()->isAdmin()):
                    $deleteModal->echoModalWindow();
                    ?>

                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addDissertationCouncil"
                                   role="button">Добавить новый диссовет</a>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Наименование</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $dissertationCouncils = $this->dissertationCouncils->getDissertationCouncilService()->getAllDissertationCouncils();

                                        foreach ($dissertationCouncils as $dissertationCouncil):
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $dissertationCouncil->getName() ?></th>
                                                <td class="text-center"><a class="text-info"
                                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addDissertationCouncil&id=<?= $dissertationCouncil->getId() ?>"
                                                                           role="button"><i class="fas fa-edit"></i></a>
                                                </td>
                                                <td class="text-center">
                                                    <?php $deleteModal->echoButton($dissertationCouncil->getId(), "text-danger"); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }
    }

}