<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class PositionsList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * PositionsList constructor.
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

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin()) {
            $deleteModal = new \ModalWindow(
                "<i class=\"fas fa-times\"></i>",
                "deleteElement",
                "Удаление должности",
                "<p>Вы уверены, что хотите удалить эту должность?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $this->contest->getPositionService()->deletePositionById($_GET['delete_id']);
                exit;
            }
        }

        if($currentUser->getStatus()->isAdmin()) {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            if ($this->contest->getAuthorizationService()->isAuthorized()):
                $this->contest->getPageBuilderManager()->setPageBuilder("top");
                $this->contest->getPageBuilder()->build(array("main_back" => true));

                if ($currentUser->getStatus()->isAdmin()):
                    $deleteModal->echoModalWindow();
                    ?>

                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addPosition"
                                   role="button">Добавить новую должность</a>
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
                                            <th class="text-center" scope="col" style="width: 600px;">Наименование в род. падеже</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                            <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $positions = $this->contest->getPositionService()->getAllPositions();
                                        foreach ($positions as $position):
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $position->getTitle() ?></th>
                                                <td class="text-center"><?= $position->getTitleR() ?></td>
                                                <td class="text-center"><a class="text-info"
                                                                           href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addPosition&id=<?= $position->getId() ?>"
                                                                           role="button"><i class="fas fa-edit"></i></a>
                                                </td>
                                                <td class="text-center">
                                                    <?php $deleteModal->echoButton($position->getId(), "text-danger"); ?>
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
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }
    }

}