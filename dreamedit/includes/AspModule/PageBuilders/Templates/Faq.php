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
            <h5 class="font-weight-bold">����� ���������� �������</h5>
        </div>
        <div>
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#firstFaq" aria-expanded="false" aria-controls="firstFaq">
                    ��� ������������ ���������� ����� ����� �������� �������. � ��� ��������?
                </button>
            </p>
            <div>
                <div class="collapse" id="firstFaq">
                    <div class="card card-body">
                        ��� ������������ ���������� ������� ���������� ��������� ���� � ����������� ��������� ��������� �������. ���� ������ �� ���������, �� ���� ��������� �������. �� ������ ��������� �� �������, �������� �����. ���������� ��� �������� ����� �������� ��������� ���� ������ �����.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq2" aria-expanded="false" aria-controls="Faq2">
                    � ���� ��������� ��������. ��� �� ���������?
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq2">
                    <div class="card card-body">
                        � ���� "�������� �� ����������� � � ������������ (� �����������)" ����� ��������� ������ 1 ���� � ����� ��������. � ���� ���� ����� ��������� �������� ������, ������� ���������� � ������� "�����������" � ������ ��� ������ ���������. ��� ��������� ������� ����������� ��� �������������� ����������.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq3" aria-expanded="false" aria-controls="Faq3">
                    � ���� ��������� ������������� � ������� jpg/png/gif. ���� �� � ��������� � ����� �������?
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq3">
                    <div class="card card-body">
                        ���. ����� ����������� ������������ ��� ������� ��������� PDF ���� � � ���� ������� ��� ��������������� �������� ���������.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq4" aria-expanded="false" aria-controls="Faq4">
                    ��� ��������� ������ ���������?
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq4">
                    <div class="card card-body">
                        ������� ���������� ������ ������ "��������� ���������" � ��������� ��� ����������� ���������. ����� �������� ���������� ������ ������ "������ ���������". ����� ����� ��������� ����� ���������� �� ��������.
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <p>
                <button class="btn btn-light btn-faq collapsed" type="button" data-toggle="collapse" data-target="#Faq5" aria-expanded="false" aria-controls="Faq5">
                    ������ ��������
                </button>
            </p>
            <div>
                <div class="collapse" id="Faq5">
                    <div class="card card-body">
                        ���� � ��� �������� ����������� ������ ��� ������ � ������ ���������, ������� "����������", �� ���� ��������� �������� ����� �������������������� �� ���. <a href="tel:+74991206534">+7 (499) 120-6534</a> ��� <a href="tel:+79160819942">+7 (916) 081-9942</a>
                        <div class="pt-5">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                               role="button">����������</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}