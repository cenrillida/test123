<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class UserData implements PageBuilder {
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
        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($admin->getStatus());
        if($status->isAdminAllow()) {
            $user = $this->aspModule->getUserService()->getUserById($_GET['id']);
            $this->aspModule->getUserService()->setCurrentEditableUser($user);

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

            if($this->aspModule->getAuthorizationService()->isAuthorized()):
                $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
                $this->aspModule->getPageBuilder()->build(array("main_back" => true));

                $department = "";
                $currentDepartmentId = $user->getDissertationDepartment();
                if(!empty($currentDepartmentId) && is_numeric($currentDepartmentId)) {
                    $departmentEl = $this->aspModule->getDepartmentService()->getFullPathDepartment($currentDepartmentId);
                    if(!empty($departmentEl)) {
                        $department = $departmentEl->getTitle();
                    }
                }
                ?>
            <?php endif;?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <hr>
                        <h4 class="font-weight-bold">������ ������������ <?=$user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName()?></h4>
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=changeUserStatus&id=<?=$user->getId()?>"
                           role="button">�������� ������ ������������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=uploadDocument&user_id=<?=$user->getId()?>"
                           role="button">�������� ���������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=addData&user_id=<?=$user->getId()?>"
                           role="button">�������� �������������� ������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=documentApplication&user_id=<?=$user->getId()?>"
                           role="button">�������� ������ ��� ������ ���������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=editRegData&user_id=<?=$user->getId()?>"
                           role="button">�������� ��������������� ������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntry&user_id=<?=$user->getId()?>"
                           role="button">�������� ������� �����������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntryUpload&user_id=<?=$user->getId()?>"
                           role="button">�������� ��������� � �������� �� ����������</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <hr>
                        <h5 class="font-weight-bold">�������� ���������:</h5>
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <?php if($user->getPdfApplyForEntry()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getApplyForEntry&user_id=<?=$user->getId()?>"
                                                                           role="button">������� ��������� � �������� �� ����������</a>
                        </div>
                        <div class="col-12">
                            �� �������� ����� � ������ ����������� ���� ������: <?php if($user->isWillBudgetEntry()) echo "��"; else echo "���";?>
                        </div>
                        <div class="col-12 mb-2">
                            �� ����� �� �������� �� �������� ������� ��������������� �����: <?php if($user->isWillPayEntry()) echo "��"; else echo "���";?>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPhoto()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-image text-info"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserPhoto&file=getApplication&download=1&user_id=<?=$user->getId()?>"
                                                                           role="button">������� ����������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfConsentDataProcessing()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getConsentDataProcessing&user_id=<?=$user->getId()?>"
                                                                           role="button">������� �������� �� ��������� ������������ ������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfApplication()!=""):?>
                    <div class="col-12">
                        <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getApplication&user_id=<?=$user->getId()?>"
                                                                       role="button">������� ���������</a>
                    </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalSheet()!=""):?>
                    <div class="col-12">
                        <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getPersonalSheet&user_id=<?=$user->getId()?>"
                                                                       role="button">������� ������ ������ �� ����� ������</a>
                    </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalDocument()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getPersonalDocument&user_id=<?=$user->getId()?>"
                                                                           role="button">��������, �������������� ��������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getWordEssay()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getEssay&user_id=<?=$user->getId()?>"
                                                                           role="button">���� �� ���� �����������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfPensionCertificate()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getPensionCertificate&user_id=<?=$user->getId()?>"
                                                                           role="button">�����</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfScienceWorkList()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getScienceWorkList&user_id=<?=$user->getId()?>"
                                                                           role="button">������ ������� ������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalSheet()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getEducation&user_id=<?=$user->getId()?>"
                                                                           role="button">�������� �� ����������� � � ������������ (� �����������)</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfEducationPeriodReference()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getEducationPeriodReference&user_id=<?=$user->getId()?>"
                                                                           role="button">������� �� ��������/������� ��������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalSheet()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getAutobiography&user_id=<?=$user->getId()?>"
                                                                           role="button">�������������</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfDisabledInfo()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getDisabledInfo&user_id=<?=$user->getId()?>"
                                                                           role="button">��������, �������������� ������������</a>
                        </div>
                    <?php endif;?>
                    <?php $counter = 1; foreach ($user->getPdfIndividualAchievements() as $achievement):?>
                    <?php if($achievement['pdf_individual_achievement']!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getIndividualAchievements&user_id=<?=$user->getId()?>&id=<?=$counter?>"
                                                                           role="button">�������������� ���������� �<?=$counter?></a>
                        </div>
                    <?php endif;?>
                    <?php
                    $counter++;
                    endforeach;?>
                    <div class="col-12">
                        ��� ��� �����: <?=$user->getPensionCertificateOrCode()?>
                    </div>
                    <div class="col-12">
                        �������: <?=$user->getPhone()?>
                    </div>
                    <div class="col-12">
                        e-mail: <?=$user->getEmail()?>
                    </div>
                    <div class="col-12">
                        �������� ����� � �������: <?=$user->getHomeAddressPhone()?>
                    </div>
                    <div class="col-12">
                        ���� ��������: <?=$user->getBirthDate()?>
                    </div>
                    <div class="col-12">
                        ����� ��������: <?=$user->getBirthplace()?>
                    </div>
                    <div class="col-12">
                        ���: <?=$user->getGender()?>
                    </div>
                    <div class="col-12">
                        ��������� ������ ��: <?php if($user->isForDissertationAttachment()) echo "������������"; else echo "��������";?>
                    </div>
                    <?php if($user->isForDissertationAttachment()):?>
                        <div class="col-12">
                            �������������� ���� �������: <?=\Dreamedit::LineBreakToSpace($user->getDissertationTheme())?>
                        </div>
                        <div class="col-12">
                            ������� ������������: <?=\Dreamedit::LineBreakToSpace($user->getDissertationSupervisor())?>
                        </div>
                        <div class="col-12">
                            ������� �������������: <?=\Dreamedit::LineBreakToSpace($department)?>
                        </div>
                    <?php endif;?>
                    <div class="col-12">
                        ������ ������� ��������������: <?php $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($user->getFieldOfStudy()); if(!empty($fieldOfStudy)) echo $fieldOfStudy->getName();?>
                    </div>
                    <div class="col-12">
                        ������� �������������: <?php $profile = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileById($user->getFieldOfStudyProfile()); if(!empty($profile)) echo $profile->getName();?>
                    </div>
                    <div class="col-12">
                        ������: <?=$this->aspModule->getStatusService()->getStatusBy($user->getStatus())->getText();?>
                    </div>
                    <div class="col-12">
                        ��� � ����������� ������: <?=$user->getFioR()?>
                    </div>
                    <div class="col-12">
                        �����������: <?=$user->getCitizenship()?>
                    </div>
                    <div class="col-12">
                        ��������������: <?=$user->getNationality()?>
                    </div>
                    <div class="col-12">
                        ����� ��������: <?=$user->getPassportSeries()?>
                    </div>
                    <div class="col-12">
                        ����� ��������: <?=$user->getPassportNumber()?>
                    </div>
                    <div class="col-12">
                        ������� �����: <?=$user->getPassportPlace()?>
                    </div>
                    <div class="col-12">
                        ���� ������ ��������: <?=$user->getPassportDate()?>
                    </div>
                    <?php if(!$user->isForDissertationAttachment()):?>
                    <div class="col-12">
                        �����: <?=$user->getPensionCertificate()?>
                    </div>
                    <div class="col-12">
                        ���: <?=$user->getSpecialCode()?>
                    </div>
                    <div class="col-12">
                        �� ���� ��������� ������������ ������������ �������: <?php if($user->isWillBudget()) echo "��"; else echo "���";?>
                    </div>
                    <div class="col-12">
                        �� �������� �� �������� ������� ��������������� �����: <?php if($user->isWillPay()) echo "��"; else echo "���";?>
                    </div>
                    <div class="col-12">
                        ��������� ���������� 1: <?=$user->getPrioritetFirst()?>
                    </div>
                    <div class="col-12">
                        ��������� ���������� 2: <?=$user->getPrioritetSecond()?>
                    </div>
                    <?php endif;?>
                    <div class="col-12">
                        ���: <?=$user->getUniversity()?>
                    </div>
                    <div class="col-12">
                        ��� ���� ���������: <?=$user->getUniversityYearEnd()?>
                    </div>
                    <div class="col-12">
                        ������: <?=$user->getDiplom()?>
                    </div>
                    <div class="col-12">
                        ������ �����: <?=$user->getDiplomSeries()?>
                    </div>
                    <div class="col-12">
                        ������ �����: <?=$user->getDiplomNumber()?>
                    </div>
                    <div class="col-12">
                        ���� ������ ������: <?=$user->getDiplomDate()?>
                    </div>
                    <?php if(!$user->isForDissertationAttachment()):?>
                    <div class="col-12">
                        ��������� �������: <?=$user->getExam()?>
                    </div>
                    <div class="col-12">
                        ����������� ������� ��� ��������: <?php if(!$user->isExamSpecCond()) echo "���"; else echo "��";?>
                    </div>
                    <div class="col-12">
                        ����. ������� ��� ����������: <?=$user->getExamSpecCondDiscipline()?>
                    </div>
                    <div class="col-12">
                        ������ ����. �������: <?=$user->getExamSpecCondList()?>
                    </div>
                    <div class="col-12">
                        ���������: <?php if(!$user->isObsh()) echo "���"; else echo "��";?>
                    </div>
                    <div class="col-12">
                        ������� ����������: <?=$this->aspModule->getUserService()->getSendBackTypeText($user->getSendBackType())?>
                    </div>
                    <?php endif;?>
                    <div class="col-12">
                        ������������: <?=\Dreamedit::LineBreakToComma($user->getRelatives())?>
                    </div>
                    <div class="col-12">
                        �������� ������: <?=$user->getArmyRank()?>
                    </div>
                    <div class="col-12">
                        �������� ���������: <?=$user->getArmyStructure()?>
                    </div>
                    <div class="col-12">
                        �������: <?=\Dreamedit::LineBreakToComma($user->getGovAwards())?>
                    </div>
                    <div class="col-12">
                        ������ ������: <?=$user->getAcademicRank()?>
                    </div>
                    <div class="col-12">
                        ������ �������: <?=$user->getAcademicDegree()?>
                    </div>
                    <div class="col-12">
                        ����������� �����: <?=$user->getLanguages()?>
                    </div>
                    <div class="col-12">
                        �����������: <?=$user->getEducation()?>
                    </div>
                    <div class="col-12">
                        ������� ������ � �����������: <?=\Dreamedit::LineBreakToComma($user->getScienceWorkAndInvents())?>
                    </div>
                    <div class="col-12">
                        ��������� ����������(����������� �����, � �� ���������� ����������� ������): <?=$user->getAttachmentCount()?>
                    </div>
                    <div class="col-12">
                        ������� �� ���������� ����������(����������� �����, � �� ���������� ����������� ������): <?=$user->getAttachmentPages()?>
                    </div>
                    <div class="col-12">
                        ���� ��������� ������ ����������: <?=$user->getPdfLastUploadDateTime()?>
                    </div>
                    <div class="col-12">
                        <hr>
                        <h6>������ ������ ������� ���������:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getUniversityList() as $item):?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            �������� �������� ��������� � ��� ���������������: <?=$item['university_name_place']?>
                        </div>
                        <div class="col-12">
                            ��������� ��� ���������: <?=$item['university_faculty']?>
                        </div>
                        <div class="col-12">
                            ����� ��������: <?=$item['university_form']?>
                        </div>
                        <div class="col-12">
                            ��� �����������: <?=$item['university_year_in']?>
                        </div>
                        <div class="col-12">
                            ��� ��������� ��� �����: <?=$item['university_year_out']?>
                        </div>
                        <div class="col-12">
                            ���� �� �������, �� � ������ ����� ����: <?=$item['university_level_out']?>
                        </div>
                        <div class="col-12">
                            ����� ������������� ������� � ���������� ��������� �������� ���������, ������� � ������� ��� �������������: <?=$item['university_special_number']?>
                        </div>
                    <?php $counter++; endforeach;?>
                    <div class="col-12">
                        <hr>
                        <h6>������ �����:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getWorkList() as $item):?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            ����� ����������: <?=$item['work_month_in']?>
                        </div>
                        <div class="col-12">
                            ��� ����������: <?=$item['work_year_in']?>
                        </div>
                        <?php if($item['work_out']):?>
                            <div class="col-12">
                                ���, ����� �����: �� ��������� �����
                            </div>
                        <?php else:?>
                        <div class="col-12">
                            ����� �����: <?=$item['work_month_out']?>
                        </div>
                        <div class="col-12">
                            ��� �����: <?=$item['work_year_out']?>
                        </div>
                        <?php endif;?>
                        <div class="col-12">
                            ��������� � ��������� ����������, �����������, �����������, � ����� ������������ (���������): <?=$item['work_position']?>
                        </div>
                        <div class="col-12">
                            ��������������� ����������, �����������, �����������: <?=$item['work_place']?>
                        </div>
                        <?php $counter++; endforeach;?>
                    <div class="col-12">
                        <hr>
                        <h6>������ ������� �� �������:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getAbroadList() as $item): ?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            ����� ������ �������: <?=$item['abroad_month_in']?>
                        </div>
                        <div class="col-12">
                            ��� ������ �������: <?=$item['abroad_year_in']?>
                        </div>
                        <div class="col-12">
                            ����� ����� �������: <?=$item['abroad_month_out']?>
                        </div>
                        <div class="col-12">
                            ��� ����� �������: <?=$item['abroad_year_out']?>
                        </div>
                        <div class="col-12">
                            � ����� ������: <?=$item['abroad_country']?>
                        </div>
                        <div class="col-12">
                            ���� ���������� �� ��������: <?=$item['abroad_purpose']?>
                        </div>
                        <?php $counter++; endforeach;?>
                    <div class="col-12">
                        <hr>
                        <h6>������ ������� ������:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getScienceWorkList() as $item): ?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            ��� �������� �����: <?=$this->aspModule->getScienceWorkService()->getScienceWorkByTypeId($item['science_work_type'])?>
                        </div>
                        <div class="col-12">
                            ������������ �������� �����: <?=$item['science_work_name']?>
                        </div>
                        <div class="col-12">
                            �������� ������������, �������: <?=$item['science_work_journal_name']?>
                        </div>
                        <div class="col-12">
                            ������������� � ����: <?php if($item['science_work_journal_rinc']==1) echo '��'; else echo '���';?>
                        </div>
                        <div class="col-12">
                            ������������� � WoS (��, ESCI): <?php if($item['science_work_journal_wos']==1) echo '��'; else echo '���';?>
                        </div>
                        <div class="col-12">
                            ������������� � Scopus: <?php if($item['science_work_journal_scopus']==1) echo '��'; else echo '���';?>
                        </div>
                        <div class="col-12">
                            ������ �� ������ �� ����� �������: <?=$item['science_work_site_link']?>
                        </div>
                        <div class="col-12">
                            ��� �������: <?=$item['science_work_year']?>
                        </div>
                        <div class="col-12">
                            ����� �������: <?=$item['science_work_number']?>
                        </div>
                        <div class="col-12">
                            ���������� ���������/�������� ������ (��� ����), �������� � ������� (��� ������): <?=$item['science_work_pages']?>
                        </div>
                        <div class="col-12">
                            ���������� (��������): <?=$item['science_work_other_authors']?>
                        </div>
                        <div class="col-12">
                            E-mail ������� ��� ��������: <?=$item['science_work_email']?>
                        </div>
                        <?php $counter++; endforeach;?>
                </div>
            </div>
            <?php



            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
        }
    }
}