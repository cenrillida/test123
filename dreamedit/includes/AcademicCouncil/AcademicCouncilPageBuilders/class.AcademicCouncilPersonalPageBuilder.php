<?php

class AcademicCouncilPersonalPageBuilder implements AcademicCouncilPageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build()
    {
        global $DB,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->academicCouncilModule->getAcademicCouncilAuthorizationService()->isAuthorized()):?>
            <?php
            if(!empty($_GET['delete_id'])) {
                $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->deleteQuestionnaireById($_GET['delete_id']);
                exit;
            }

            $exitPageId = $this->pages->getFirstPageIdByTemplate("ac_lk_login");
            ?>
            <div class="modal fade" id="deleteElement" tabindex="-1" role="dialog" aria-labelledby="deleteElementLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteElementLabel">Удаление элемента</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Вы уверены, что хотите удалить этот элемент?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-lg imemo-button text-uppercase" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-lg imemo-button text-uppercase" id="deleteElementButton" data-dismiss="modal" data-delete_id="#">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>

                $( "#deleteElementButton" ).on( "click", function(event) {
                    event.preventDefault();
                    jQuery.ajax({
                        type: 'GET',
                        data:  {delete_id:$(this).data('delete_id')},
                        complete: function () {
                            location.reload();
                        }
                    })
                });
                $('#deleteElement').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('delete_id');
                    var modal = $(this);
                    modal.find('#deleteElementButton').attr('data-delete_id',id);
                    modal.find('#deleteElementButton').data('delete_id',id);
                });

            </script>
            <div class="container-fluid">
                <div class="row justify-content-between mb-3">
                    <div>

                    </div>
                    <div class="row justify-content-end">
                        <div class="mt-3 pl-2 pr-2">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                               role="button">Выход</a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <div class="mr-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireCreate"
                       role="button">Создать опрос для текущего состава ученого совета</a>
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
                                <th scope="col">Название</th>
                                <th class="text-center" scope="col" style="width: 200px;">Дата начала</th>
                                <th class="text-center" scope="col" style="width: 200px;">Дата окончания</th>
                                <th class="text-center" scope="col" style="width: 100px;">Изменить</th>
                                <th class="text-center" scope="col" style="width: 100px;">Документ</th>
                                <th class="text-center" scope="col" style="width: 100px;">Рассылка</th>
                                <th class="text-center" scope="col" style="width: 100px;">Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $questionnaires = $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->getQuestionnairesList();
                            foreach ($questionnaires as $questionnaire):
                            ?>
                            <tr>
                                <th scope="row"><?=$questionnaire->getName()?></th>
                                <td class="text-center"><?=$questionnaire->getDtStart()?></td>
                                <td class="text-center"><?=$questionnaire->getDtEnd()?></td>
                                <td class="text-center"><a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireEdit&id=<?=$questionnaire->getId()?>"
                                                           role="button"><i class="fas fa-edit"></i></a></td>
                                <td class="text-center"><a class="text-success" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=documentCreate&id=<?=$questionnaire->getId()?>"
                                                           role="button"><i class="fas fa-download"></i></a></td>
                                <td class="text-center"><a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=questionnaireMailer&id=<?=$questionnaire->getId()?>"
                                       role="button"><i class="fas fa-share-square"></i></a></td>
                                <td class="text-center"><button type="button" class="text-danger border-0 m-0 p-0 focus-0" style="background: none" data-toggle="modal" data-target="#deleteElement" data-delete_id="<?=$questionnaire->getId()?>">
                                        <i class="fas fa-times"></i>
                                    </button></td>
                            </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}