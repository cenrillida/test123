<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class ApplicantsList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ApplicantsList constructor.
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
            if(!empty($_GET['delete_id'])) {
                $this->contest->getApplicantService()->deleteApplicantById($_GET['delete_id']);
                exit;
            }
        }

        if(($currentUser->getStatus()->isAdmin() || $currentUser->getStatus()->isCanVote()) && !empty($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($contest->getContestGroupId());
                if(!empty($contestGroup)) {
                    if ($contestGroup->isActive() || $currentUser->getStatus()->isAdmin() || $contestGroup->isPreview()) {
                        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

                        if ($this->contest->getAuthorizationService()->isAuthorized()):
                            $this->contest->getPageBuilderManager()->setPageBuilder("top");
                            $this->contest->getPageBuilder()->build(array("main_back" => true));

                            if ($currentUser->getStatus()->isAdmin()):
                                ?>
                                <div class="modal fade" id="deleteElement" tabindex="-1" role="dialog"
                                     aria-labelledby="deleteElementLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteElementLabel">Удаление
                                                    претендента</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Вы уверены, что хотите удалить этого претендента?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-lg imemo-button text-uppercase"
                                                        data-dismiss="modal">Закрыть
                                                </button>
                                                <button type="button" class="btn btn-lg imemo-button text-uppercase"
                                                        id="deleteElementButton" data-dismiss="modal"
                                                        data-delete_id="#">Удалить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>

                                    $("#deleteElementButton").on("click", function (event) {
                                        event.preventDefault();
                                        jQuery.ajax({
                                            type: 'GET',
                                            data: {delete_id: $(this).data('delete_id')},
                                            complete: function () {
                                                location.reload();
                                            }
                                        })
                                    });
                                    $('#deleteElement').on('show.bs.modal', function (event) {
                                        var button = $(event.relatedTarget);
                                        var id = button.data('delete_id');
                                        var modal = $(this);
                                        modal.find('#deleteElementButton').attr('data-delete_id', id);
                                        modal.find('#deleteElementButton').data('delete_id', id);
                                    });

                                </script>
                                <div class="container-fluid">
                                    <div class="row justify-content-start mb-3">
                                        <div class="mr-3 mt-3">
                                            <a class="btn btn-lg imemo-button text-uppercase"
                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addApplicant&contest_id=<?= $_GET['contest_id'] ?>"
                                               role="button">Добавить нового претендента</a>
                                        </div>
                                        <div class="mr-3 mt-3">
                                            <a class="btn btn-lg imemo-button text-uppercase"
                                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=contestsList&contest_group_id=<?= $contest->getContestGroupId() ?>"
                                               role="button">Вернутся к списку конкурсов</a>
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
                                                        <th scope="col">Ф.И.О.</th>
                                                        <th class="text-center" scope="col" style="width: 100px;">
                                                            Изменить
                                                        </th>
                                                        <th class="text-center" scope="col" style="width: 100px;">
                                                            Удалить
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $applicants = $this->contest->getApplicantService()->getApplicantsByContestId($_GET['contest_id'], "id", "DESC");
                                                    foreach ($applicants as $applicant):
                                                        ?>
                                                        <tr>
                                                            <th scope="row"><?= $applicant->getLastName() . " " . $applicant->getFirstName() . " " . $applicant->getThirdName() ?></th>
                                                            <td class="text-center"><a class="text-info"
                                                                                       href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=addApplicant&id=<?= $applicant->getId() ?>&contest_id=<?= $_GET['contest_id'] ?>"
                                                                                       role="button"><i
                                                                            class="fas fa-edit"></i></a>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                        class="text-danger border-0 m-0 p-0 focus-0"
                                                                        style="background: none" data-toggle="modal"
                                                                        data-target="#deleteElement"
                                                                        data-delete_id="<?= $applicant->getId() ?>">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
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
                            <?php if (!$currentUser->getStatus()->isAdmin() && $currentUser->getStatus()->isCanVote()): ?>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-bold">Претенденты</h5>
                                        <?php
                                        $counter = 1;
                                        foreach ($contest->getApplicants() as $applicant):?>
                                            <hr>
                                            <h5 class="font-weight-bold">Претендент №<?= $counter ?></h5>
                                            <p>
                                                Ф.И.О.: <?php echo $applicant->getLastName() . " " . $applicant->getFirstName() . " " . $applicant->getThirdName(); ?></p>
                                            <p>Документы: </p>
                                            <?php
                                            $counterDocuments = 1;
                                            foreach ($applicant->getDocuments() as $document):?>
                                                <p><i class="fas fa-file-pdf text-danger"></i> <a target="_blank"
                                                                                                  href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=getPdfFile&file=getDocuments&id=<?= $counterDocuments ?>&applicant_id=<?= $applicant->getId() ?>"
                                                                                                  role="button">Документ <?= $counterDocuments ?></a>
                                                </p>
                                                <?php
                                                $counterDocuments++;
                                            endforeach;
                                            $counter++;
                                        endforeach;
                                        ?>
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
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array("error" => "Не найдена группа конкурсов"));
                }
            } else {
                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                $this->contest->getPageBuilder()->build(array("error" => "Не найден конкурс"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }
    }

}