<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class NumberCheckUpload implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * NumberCheckUpload constructor.
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

        $pageBack = 'journal';
        if($_GET['ap']!=1) {
            $module = 'journal';
        } else {
            $module = 'afjournal';
        }

        if($params['module']=='publ') {
            $module = 'publ';
            $pageBack = 'publ';
        }

        $sentBefore = $this->crossref->getNumberCheckService()->getSentDataByElementIdAndModule($_GET['id'],$module);


        $rows = array();

        $doiBatchDiagnostic =
            $this->
            crossref->
            getNumberCheckService()->
            getSentDataStatusByBatchId($sentBefore[0]['data']['doi_batch_id']);

        $currentStatus = "Success";
        if($doiBatchDiagnostic->isCompleted()) {
            $rows['completed'] = 1;
            if(count($doiBatchDiagnostic->getRecordDiagnostics())>0) {
                foreach ($doiBatchDiagnostic->getRecordDiagnostics() as $recordDiagnostic) {
                    if($recordDiagnostic->getStatus()=="Warning" && $currentStatus=="Success") {
                        $currentStatus = "Warning";
                    }
                    if($recordDiagnostic->getStatus()=="Failure") {
                        $currentStatus = "Failure";
                    }
                }
            }
        } else {
            $rows['completed'] = 0;
        }
        if($doiBatchDiagnostic->getStatusText()=="unknown_submission") {
            $rows['completed'] = -1;
        }
        $rows['status'] = $currentStatus;

        if($rows['completed'] == -1 || $rows['status']=="Warning" || $currentStatus == "Failure") {
            $this->crossref->getNumberCheckService()->updateCheckedById($sentBefore[0]['id'],-1);
        }
        if($rows['completed'] == 1 && $rows['status']=="Success") {
            $this->crossref->getNumberCheckService()->updateCheckedById($sentBefore[0]['id'],1);
        }
        if($rows['completed'] == 1 && $rows['status']=="Warning") {
            $this->crossref->getNumberCheckService()->updateCheckedById($sentBefore[0]['id'],2);
        }

        if($this->crossref->getAuthorizationService()->isAuthorized() && $_GET['json']==1) {
            header("Content-type: application/json");
            echo json_encode($rows);
            exit;
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->crossref->getAuthorizationService()->isAuthorized()):

            $this->crossref->getPageBuilderManager()->setPageBuilder("top");
            $this->crossref->getPageBuilder()->build(array("main_back" => true));


            ?>

            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=<?=$pageBack?>sList"
                           role="button">Вернуться к списку</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php

        if(!empty($sentBefore[0]['data']['doi_batch_id'])) {
            ?>
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        <h4>Журнал: <?=$sentBefore[0]['data']['full_title']?></h4>
                        <div><b>Номер:</b> <?=$sentBefore[0]['data']['issue']?></div>
                        <?php if(!empty($sentBefore[0]['data']['volume'])) echo "<div><b>Том:</b> ".$sentBefore[0]['data']['volume']."</div>"?>
                        <div><b>Год:</b> <?=$sentBefore[0]['data']['year']?></div>
                        <div class="mb-3"><b>Дата отправки:</b> <?=$sentBefore[0]['date_sent']?></div>
                        <h4>Список по статьям:</h4>
                    </div>
                </div>
                <hr>
            </div>
            <?php

//            $doiBatchDiagnostic =
//                $this->
//                crossref->
//                getNumberCheckService()->
//                getSentDataStatusByBatchId($sentBefore[0]['data']['doi_batch_id']);

            if($doiBatchDiagnostic->isCompleted()) {
                if(count($doiBatchDiagnostic->getRecordDiagnostics())>0) {
                    ?>
                    <div class="container-fluid">
                        <?php foreach ($doiBatchDiagnostic->getRecordDiagnostics() as $recordDiagnostic):?>
                        <div class="row mb-3">
                            <div class="col">
                                <h5>DOI: <?=$recordDiagnostic->getDoi()?></h5>
                                <div><b>Статус:</b> <span class="<?php if($recordDiagnostic->isSuccess()) echo "text-success"; else echo "text-danger";?>"><?php if($recordDiagnostic->isSuccess()) echo "ОК"; else echo "Ошибка";?></span></div>
                                <div><b>Текст <?php if($recordDiagnostic->isSuccess()) echo "ответа"; else echo "ошибки";?>:</b> <?=$recordDiagnostic->getMsg()?></div>
                                <?php if($recordDiagnostic->isSuccess()):?>
                                <div><a href="https://doi.org/<?=$recordDiagnostic->getDoi()?>" target="_blank">Открыть привязанную к DOI страницу</a></div>
                                <div><a href="http://api.crossref.org/works/<?=$recordDiagnostic->getDoi()?>" target="_blank">Открыть информацию о DOI в XML</a></div>
                                <?php endif;?>
                            </div>
                        </div>
                        <hr>
                        <?php endforeach;?>
                    </div>
                    <?php
                } else {
                    $error = "Не найдена информация по зарегистрированным DOI";
                }
            } else {
                $error = $doiBatchDiagnostic->getStatusText();
            }

        } else {
            $error = "Данные о загрузке не найдены";
        }
        if (!empty($error)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
            <?php
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}