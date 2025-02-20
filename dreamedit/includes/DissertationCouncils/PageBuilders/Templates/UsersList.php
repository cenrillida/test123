<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\PageBuilder;

class UsersList implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * UsersList constructor.
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
                "Удаление пользователя",
                "<p>Вы уверены, что хотите удалить этого пользователя?</p>",
                "delete_id",
                "Удалить"
            );
            if(!empty($_GET['delete_id'])) {
                $user = $this->dissertationCouncils->getUserService()->getUserById($_GET['delete_id']);
                if(!empty($user)) {
                    if($user->getStatus()->getId()==5) {
                        $this->dissertationCouncils->getUserService()->deleteUserById($_GET['delete_id']);
                    } else {
                        $this->dissertationCouncils->getUserService()->changeUserStatusByIdWithId($_GET['delete_id'],3);
                    }
                }
                exit;
            }
            $recoverModal = new \ModalWindow(
                "<i class=\"fas fa-undo-alt\"></i>",
                "recoverElement",
                "Активирование пользователя",
                "<p>Вы уверены, что хотите активировать этого пользователя?</p>",
                "recover_id",
                "Активировать"
            );
            if(!empty($_GET['recover_id'])) {
                $this->dissertationCouncils->getUserService()->changeUserStatusByIdWithId($_GET['recover_id'],2);
                exit;
            }
        }
        if($_GET['deleted']==1) {
            $_GET['register_confirm']='';
        }

        if($currentUser->getStatus()->isAdmin()) {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            if ($this->dissertationCouncils->getAuthorizationService()->isAuthorized()):
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
                $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));

                if ($currentUser->getStatus()->isAdmin()):
                    $deleteModal->echoModalWindow();
                    $recoverModal->echoModalWindow();
                    ?>

                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <?php if($_GET['deleted']!=1 && $_GET['register_confirm']!=1):?>
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addUser"
                                   role="button">Добавить нового пользователя</a>
                            </div>
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=<?= $_GET['mode']?>&deleted=1"
                                   role="button">Список неактивных пользователей</a>
                            </div>
<!--                            <div class="mr-3 mt-3">-->
<!--                                <a class="btn btn-lg imemo-button text-uppercase"-->
<!--                                   href="/index.php?page_id=--><?//= $_REQUEST['page_id'] ?><!--&mode=--><?//= $_GET['mode']?><!--&register_confirm=1"-->
<!--                                   role="button">Список ожидающих подтверждения регистрации пользователей</a>-->
<!--                            </div>-->
                            <?php else:?>
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=<?= $_GET['mode']?>"
                                   role="button">Вернутся к списку пользователей</a>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center" scope="col" style="width: 600px;">e-mail</th>
                                            <?php if($_GET['deleted']==1):?>
                                                <th class="text-center" scope="col" style="width: 100px;">Активировать</th>
                                            <?php elseif($_GET['register_confirm']==1):?>
                                                <th class="text-center" scope="col" style="width: 100px;">Подтвердить</th>
                                                <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                            <?php else:?>
                                                <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                                <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                                            <?php endif;?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $users = $this->dissertationCouncils->getUserService()->getAllUsers("id");
                                        foreach ($users as $user):
                                            if($user->getStatus()->getId()==1) {
                                                continue;
                                            }
                                            if($_GET['register_confirm']==1 && $user->getStatus()->getId()!=5)
                                                continue;
                                            if(($_GET['deleted']==1 && $user->getStatus()->getId()!=3))
                                                continue;
                                            if($_GET['deleted']!=1 && $_GET['register_confirm']!=1 && !$user->getStatus()->isCanVote())
                                                continue;

                                            ?>
                                            <tr>
                                                <th scope="row"><?= $user->getEmail() ?></th>
                                                <?php if($_GET['deleted']==1):?>
                                                    <td class="text-center">
                                                        <?php $recoverModal->echoButton($user->getId(), "text-success"); ?>
                                                    </td>
                                                <?php elseif($_GET['register_confirm']==1):?>
                                                    <td class="text-center">
                                                        <?php $recoverModal->echoButton($user->getId(), "text-success"); ?>
                                                    </td>
                                                    <td class="text-center">
                                                    <?php $deleteModal->echoButton($user->getId(), "text-danger"); ?>
                                                    </td>
                                                <?php else:?>
                                                    <td class="text-center"><a class="text-info"
                                                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addUser&id=<?= $user->getId() ?>"
                                                                               role="button"><i class="fas fa-edit"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (!$user->getStatus()->isAdmin() || $user->getStatus()->isCanVote()): ?>
                                                            <?php $deleteModal->echoButton($user->getId(), "text-danger"); ?>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif;?>
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