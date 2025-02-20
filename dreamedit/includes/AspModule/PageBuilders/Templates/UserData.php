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
                        <h4 class="font-weight-bold">Данные пользователя <?=$user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName()?></h4>
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=changeUserStatus&id=<?=$user->getId()?>"
                           role="button">Изменить статус пользователя</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=uploadDocument&user_id=<?=$user->getId()?>"
                           role="button">Изменить документы</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=addData&user_id=<?=$user->getId()?>"
                           role="button">Изменить дополнительные данные</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=documentApplication&user_id=<?=$user->getId()?>"
                           role="button">Изменить данные для подачи заявления</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=editRegData&user_id=<?=$user->getId()?>"
                           role="button">Изменить регистрационные данные</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntry&user_id=<?=$user->getId()?>"
                           role="button">Изменить условия поступления</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntryUpload&user_id=<?=$user->getId()?>"
                           role="button">Изменить заявление о согласии на зачисление</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <hr>
                        <h5 class="font-weight-bold">Поданные документы:</h5>
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <?php if($user->getPdfApplyForEntry()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getApplyForEntry&user_id=<?=$user->getId()?>"
                                                                           role="button">Скачать заявление о согласии на зачисление</a>
                        </div>
                        <div class="col-12">
                            На основные места в рамках контрольных цифр приема: <?php if($user->isWillBudgetEntry()) echo "Да"; else echo "Нет";?>
                        </div>
                        <div class="col-12 mb-2">
                            На места по договору об оказании платных образовательных услуг: <?php if($user->isWillPayEntry()) echo "Да"; else echo "Нет";?>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPhoto()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-image text-info"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserPhoto&file=getApplication&download=1&user_id=<?=$user->getId()?>"
                                                                           role="button">Скачать фотографию</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfConsentDataProcessing()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getConsentDataProcessing&user_id=<?=$user->getId()?>"
                                                                           role="button">Скачать согласие на обработку персональных данных</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfApplication()!=""):?>
                    <div class="col-12">
                        <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getApplication&user_id=<?=$user->getId()?>"
                                                                       role="button">Скачать заявление</a>
                    </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalSheet()!=""):?>
                    <div class="col-12">
                        <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getPersonalSheet&user_id=<?=$user->getId()?>"
                                                                       role="button">Скачать личный листок по учету кадров</a>
                    </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalDocument()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getPersonalDocument&user_id=<?=$user->getId()?>"
                                                                           role="button">Документ, удостоверяющий личность</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getWordEssay()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getEssay&user_id=<?=$user->getId()?>"
                                                                           role="button">Эссе по теме диссертации</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfPensionCertificate()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getPensionCertificate&user_id=<?=$user->getId()?>"
                                                                           role="button">СНИЛС</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfScienceWorkList()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getScienceWorkList&user_id=<?=$user->getId()?>"
                                                                           role="button">Список научных трудов</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalSheet()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getEducation&user_id=<?=$user->getId()?>"
                                                                           role="button">Документ об образовании и о квалификации (с приложением)</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfEducationPeriodReference()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getEducationPeriodReference&user_id=<?=$user->getId()?>"
                                                                           role="button">Справка об обучении/периоде обучения</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfPersonalSheet()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getAutobiography&user_id=<?=$user->getId()?>"
                                                                           role="button">Автобиография</a>
                        </div>
                    <?php endif;?>
                    <?php if($user->getPdfDisabledInfo()!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getDisabledInfo&user_id=<?=$user->getId()?>"
                                                                           role="button">Документ, подтверждающий инвалидность</a>
                        </div>
                    <?php endif;?>
                    <?php $counter = 1; foreach ($user->getPdfIndividualAchievements() as $achievement):?>
                    <?php if($achievement['pdf_individual_achievement']!=""):?>
                        <div class="col-12">
                            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getPdfFile&file=getIndividualAchievements&user_id=<?=$user->getId()?>&id=<?=$counter?>"
                                                                           role="button">Индивидуальное достижение №<?=$counter?></a>
                        </div>
                    <?php endif;?>
                    <?php
                    $counter++;
                    endforeach;?>
                    <div class="col-12">
                        Код или СНИЛС: <?=$user->getPensionCertificateOrCode()?>
                    </div>
                    <div class="col-12">
                        Телефон: <?=$user->getPhone()?>
                    </div>
                    <div class="col-12">
                        e-mail: <?=$user->getEmail()?>
                    </div>
                    <div class="col-12">
                        Домашний адрес и телефон: <?=$user->getHomeAddressPhone()?>
                    </div>
                    <div class="col-12">
                        Дата рождения: <?=$user->getBirthDate()?>
                    </div>
                    <div class="col-12">
                        Место рождения: <?=$user->getBirthplace()?>
                    </div>
                    <div class="col-12">
                        Пол: <?=$user->getGender()?>
                    </div>
                    <div class="col-12">
                        Документы поданы на: <?php if($user->isForDissertationAttachment()) echo "Прикрепление"; else echo "Обучение";?>
                    </div>
                    <?php if($user->isForDissertationAttachment()):?>
                        <div class="col-12">
                            Предполагаемая тема диплома: <?=\Dreamedit::LineBreakToSpace($user->getDissertationTheme())?>
                        </div>
                        <div class="col-12">
                            Научный руководитель: <?=\Dreamedit::LineBreakToSpace($user->getDissertationSupervisor())?>
                        </div>
                        <div class="col-12">
                            Научное подразделение: <?=\Dreamedit::LineBreakToSpace($department)?>
                        </div>
                    <?php endif;?>
                    <div class="col-12">
                        Группа научных специальностей: <?php $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($user->getFieldOfStudy()); if(!empty($fieldOfStudy)) echo $fieldOfStudy->getName();?>
                    </div>
                    <div class="col-12">
                        Научная специальность: <?php $profile = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileById($user->getFieldOfStudyProfile()); if(!empty($profile)) echo $profile->getName();?>
                    </div>
                    <div class="col-12">
                        Статус: <?=$this->aspModule->getStatusService()->getStatusBy($user->getStatus())->getText();?>
                    </div>
                    <div class="col-12">
                        ФИО в родительном падеже: <?=$user->getFioR()?>
                    </div>
                    <div class="col-12">
                        Гражданство: <?=$user->getCitizenship()?>
                    </div>
                    <div class="col-12">
                        Национальность: <?=$user->getNationality()?>
                    </div>
                    <div class="col-12">
                        Серия паспорта: <?=$user->getPassportSeries()?>
                    </div>
                    <div class="col-12">
                        Номер паспорта: <?=$user->getPassportNumber()?>
                    </div>
                    <div class="col-12">
                        Паспорт выдан: <?=$user->getPassportPlace()?>
                    </div>
                    <div class="col-12">
                        Дата выдачи паспорта: <?=$user->getPassportDate()?>
                    </div>
                    <?php if(!$user->isForDissertationAttachment()):?>
                    <div class="col-12">
                        СНИЛС: <?=$user->getPensionCertificate()?>
                    </div>
                    <div class="col-12">
                        Код: <?=$user->getSpecialCode()?>
                    </div>
                    <div class="col-12">
                        За счет бюджетных ассигнований федерального бюджета: <?php if($user->isWillBudget()) echo "Да"; else echo "Нет";?>
                    </div>
                    <div class="col-12">
                        По договору об оказании платных образовательных услуг: <?php if($user->isWillPay()) echo "Да"; else echo "Нет";?>
                    </div>
                    <div class="col-12">
                        Приоритет зачисления 1: <?=$user->getPrioritetFirst()?>
                    </div>
                    <div class="col-12">
                        Приоритет зачисления 2: <?=$user->getPrioritetSecond()?>
                    </div>
                    <?php endif;?>
                    <div class="col-12">
                        ВУЗ: <?=$user->getUniversity()?>
                    </div>
                    <div class="col-12">
                        ВУЗ дата окончания: <?=$user->getUniversityYearEnd()?>
                    </div>
                    <div class="col-12">
                        Диплом: <?=$user->getDiplom()?>
                    </div>
                    <div class="col-12">
                        Диплом серия: <?=$user->getDiplomSeries()?>
                    </div>
                    <div class="col-12">
                        Диплом номер: <?=$user->getDiplomNumber()?>
                    </div>
                    <div class="col-12">
                        Дата выдачи диплом: <?=$user->getDiplomDate()?>
                    </div>
                    <?php if(!$user->isForDissertationAttachment()):?>
                    <div class="col-12">
                        Выбранный экзамен: <?=$user->getExam()?>
                    </div>
                    <div class="col-12">
                        Специальные условия для экзамена: <?php if(!$user->isExamSpecCond()) echo "Нет"; else echo "Да";?>
                    </div>
                    <div class="col-12">
                        Спец. условия для дисциплины: <?=$user->getExamSpecCondDiscipline()?>
                    </div>
                    <div class="col-12">
                        Список спец. условий: <?=$user->getExamSpecCondList()?>
                    </div>
                    <div class="col-12">
                        Общежитие: <?php if(!$user->isObsh()) echo "Нет"; else echo "Да";?>
                    </div>
                    <div class="col-12">
                        Возврат документов: <?=$this->aspModule->getUserService()->getSendBackTypeText($user->getSendBackType())?>
                    </div>
                    <?php endif;?>
                    <div class="col-12">
                        Родственники: <?=\Dreamedit::LineBreakToComma($user->getRelatives())?>
                    </div>
                    <div class="col-12">
                        Воинское звание: <?=$user->getArmyRank()?>
                    </div>
                    <div class="col-12">
                        Воинская структура: <?=$user->getArmyStructure()?>
                    </div>
                    <div class="col-12">
                        Награды: <?=\Dreamedit::LineBreakToComma($user->getGovAwards())?>
                    </div>
                    <div class="col-12">
                        Ученое звание: <?=$user->getAcademicRank()?>
                    </div>
                    <div class="col-12">
                        Ученая степень: <?=$user->getAcademicDegree()?>
                    </div>
                    <div class="col-12">
                        Иностранные языки: <?=$user->getLanguages()?>
                    </div>
                    <div class="col-12">
                        Образование: <?=$user->getEducation()?>
                    </div>
                    <div class="col-12">
                        Научная работа и изобретения: <?=\Dreamedit::LineBreakToComma($user->getScienceWorkAndInvents())?>
                    </div>
                    <div class="col-12">
                        Приложено документов(заполненный текст, а не количество загруженных файлов): <?=$user->getAttachmentCount()?>
                    </div>
                    <div class="col-12">
                        Страниц на приложеных документах(заполненный текст, а не количество загруженных файлов): <?=$user->getAttachmentPages()?>
                    </div>
                    <div class="col-12">
                        Дата последней подачи документов: <?=$user->getPdfLastUploadDateTime()?>
                    </div>
                    <div class="col-12">
                        <hr>
                        <h6>Список высших учебных заведений:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getUniversityList() as $item):?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            Название учебного заведения и его местонахождения: <?=$item['university_name_place']?>
                        </div>
                        <div class="col-12">
                            Факультет или отделение: <?=$item['university_faculty']?>
                        </div>
                        <div class="col-12">
                            Форма обучения: <?=$item['university_form']?>
                        </div>
                        <div class="col-12">
                            Год поступления: <?=$item['university_year_in']?>
                        </div>
                        <div class="col-12">
                            Год окончания или ухода: <?=$item['university_year_out']?>
                        </div>
                        <div class="col-12">
                            Если не окончил, то с какого курса ушел: <?=$item['university_level_out']?>
                        </div>
                        <div class="col-12">
                            Какую специальность получил в результате окончания учебного заведения, указать № диплома или удостоверения: <?=$item['university_special_number']?>
                        </div>
                    <?php $counter++; endforeach;?>
                    <div class="col-12">
                        <hr>
                        <h6>Список работ:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getWorkList() as $item):?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            Месяц вступления: <?=$item['work_month_in']?>
                        </div>
                        <div class="col-12">
                            Год вступления: <?=$item['work_year_in']?>
                        </div>
                        <?php if($item['work_out']):?>
                            <div class="col-12">
                                Год, Месяц ухода: По настоящее время
                            </div>
                        <?php else:?>
                        <div class="col-12">
                            Месяц ухода: <?=$item['work_month_out']?>
                        </div>
                        <div class="col-12">
                            Год ухода: <?=$item['work_year_out']?>
                        </div>
                        <?php endif;?>
                        <div class="col-12">
                            Должность с указанием учреждения, организации, предприятия, а также министерства (ведомства): <?=$item['work_position']?>
                        </div>
                        <div class="col-12">
                            Местонахождение учреждения, организации, предприятия: <?=$item['work_place']?>
                        </div>
                        <?php $counter++; endforeach;?>
                    <div class="col-12">
                        <hr>
                        <h6>Список поездок за границу:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getAbroadList() as $item): ?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            Месяц начала поездки: <?=$item['abroad_month_in']?>
                        </div>
                        <div class="col-12">
                            Год начала поездки: <?=$item['abroad_year_in']?>
                        </div>
                        <div class="col-12">
                            Месяц конца поездки: <?=$item['abroad_month_out']?>
                        </div>
                        <div class="col-12">
                            Год конца поездки: <?=$item['abroad_year_out']?>
                        </div>
                        <div class="col-12">
                            В какой стране: <?=$item['abroad_country']?>
                        </div>
                        <div class="col-12">
                            Цель пребывания за границей: <?=$item['abroad_purpose']?>
                        </div>
                        <?php $counter++; endforeach;?>
                    <div class="col-12">
                        <hr>
                        <h6>Список научных трудов:</h6>
                    </div>
                    <?php $counter = 1; foreach ($user->getScienceWorkList() as $item): ?>
                        <div class="col-12">
                            <hr>
                            <h6><?=$counter?>):</h6>
                        </div>
                        <div class="col-12">
                            Тип научного труда: <?=$this->aspModule->getScienceWorkService()->getScienceWorkByTypeId($item['science_work_type'])?>
                        </div>
                        <div class="col-12">
                            Наименование научного труда: <?=$item['science_work_name']?>
                        </div>
                        <div class="col-12">
                            Название издательства, журнала: <?=$item['science_work_journal_name']?>
                        </div>
                        <div class="col-12">
                            Индексируется в РИНЦ: <?php if($item['science_work_journal_rinc']==1) echo 'Да'; else echo 'Нет';?>
                        </div>
                        <div class="col-12">
                            Индексируется в WoS (СС, ESCI): <?php if($item['science_work_journal_wos']==1) echo 'Да'; else echo 'Нет';?>
                        </div>
                        <div class="col-12">
                            Индексируется в Scopus: <?php if($item['science_work_journal_scopus']==1) echo 'Да'; else echo 'Нет';?>
                        </div>
                        <div class="col-12">
                            Ссылка на статью на сайте журнала: <?=$item['science_work_site_link']?>
                        </div>
                        <div class="col-12">
                            Год издания: <?=$item['science_work_year']?>
                        </div>
                        <div class="col-12">
                            Номер журнала: <?=$item['science_work_number']?>
                        </div>
                        <div class="col-12">
                            Количество авторских/печатных листов (для книг), страницы в журнале (для статей): <?=$item['science_work_pages']?>
                        </div>
                        <div class="col-12">
                            Примечание (соавторы): <?=$item['science_work_other_authors']?>
                        </div>
                        <div class="col-12">
                            E-mail издания для проверки: <?=$item['science_work_email']?>
                        </div>
                        <?php $counter++; endforeach;?>
                </div>
            </div>
            <?php



            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
        }
    }
}