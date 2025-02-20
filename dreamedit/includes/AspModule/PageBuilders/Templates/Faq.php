<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class Faq implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <div class="mb-2">
            <h5 class="font-weight-bold">Часто задаваемые вопросы</h5>
        </div>
        <div>
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#firstFaq" aria-expanded="false" aria-controls="firstFaq">
                    При формировании документов часть полей остаются пустыми. В чем проблема?
                </button>
            </p>
            <div>
                <div class="collapse" id="firstFaq">
                    <div class="card card-body">
                        При формировании документов система попытается заполнить поля с максимально возможным маленьким шрифтом. Если данные не вмещаются, то поля останутся пустыми. Вы можете заполнить их вручную, сократив текст. Модератору для проверки будет доступен введенный Вами полный текст.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq2" aria-expanded="false" aria-controls="Faq2">
                    У меня несколько дипломов. Как их загрузить?
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq2">
                    <div class="card card-body">
                        В поле "Документ об образовании и о квалификации (с приложением)" можно загрузить только 1 файл с одним дипломом. В этом поле нужно загрузить основной диплом, который заполнялся в разделе "Образование" в данных для подачи заявления. Все остальные дипломы загружаются как индивидуальные достижения.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq3" aria-expanded="false" aria-controls="Faq3">
                    У меня документы отсканированы в формате jpg/png/gif. Могу ли я загрузить в таком формате?
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq3">
                    <div class="card card-body">
                        Нет. Нужно обязательно сформировать для каждого документа PDF файл и в него вложить все отсканированные страницы документа.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq4" aria-expanded="false" aria-controls="Faq4">
                    Как правильно подать документы?
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq4">
                    <div class="card card-body">
                        Вначале необходимо нажать кнопку "Загрузить документы" и загрузить все необходимые документы. После загрузки необходимо нажать кнопку "Подать документы". После этого документы будут отправлены на проверку.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq5" aria-expanded="false" aria-controls="Faq5">
                    Другая проблема
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq5">
                    <div class="card card-body">
                        Если у вас возникли технические ошибки при работе с личным кабинетом, нажмите "продолжить", по всем остальным вопросам можно проконсультироваться по тел. <a href="tel:+74991206534">+7 (499) 120-6534</a> или <a href="tel:+79160819942">+7 (916) 081-9942</a>
                        <div class="pt-5">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                               role="button">Продолжить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}