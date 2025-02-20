<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\Applicant;
use Contest\Models\OnlineVoteResult;
use Contest\Models\OpenVoteResult;
use Contest\Models\User;
use Contest\PageBuilders\PageBuilder;

class ProtocolWord implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ProtocolWord constructor.
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

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($contest->getContestGroupId());
                if(!empty($contestGroup)) {

                    if($contest->isOnlineVote()) {
                        $onlineVoteResults = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestId($_GET['contest_id']);
                        $participatedUsersIds = array_map(function (User $el) {
                            return $el->getId();
                        }, $contestGroup->getParticipants());
                        $onlineVoteResults = array_filter(
                            $onlineVoteResults,
                            function (OnlineVoteResult $e) use (&$participatedUsersIds) {
                            if(in_array($e->getUser()->getId(),$participatedUsersIds)) {
                                return true;
                            }
                            return false;
                        });
                    } else {
                        $openVoteResults = $this->contest->getOpenVoteService()->getAllOpenVoteResultsByContestId($_GET['contest_id']);
                    }
                    $positionR = $contest->getPositionR();
                    $positionR = mb_strtolower(substr($positionR,0,1),"windows-1251").substr($positionR,1);

                    require_once __DIR__ . '/../../../PhpWord/Autoloader.php';
                    require_once __DIR__ . '/../../../Common/Text.php';
                    require_once __DIR__ . '/../../../dompdf/autoload.inc.php';
                    require_once __DIR__ . '/../../../Common/XMLWriter.php';

                    \PhpOffice\PhpWord\Autoloader::register();

                    $phpWord = new \PhpOffice\PhpWord\PhpWord();

                    $phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));

                    $section = $phpWord->addSection();
                    $sectionStyle = $section->getStyle();
                    $footer = $section->addFooter();
                    $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_PORTRAIT);

                    $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
                    $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                    $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                    $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1));

                    $date = $contest->getDate();
                    $day = "____";
                    $month = "_______";
                    $monthNumber = $month;
                    $year = date('Y');
                    if (!empty($date) && $date != "0000-00-00") {
                        try {
                            $dt = new \DateTime($date);
                            $year = $dt->format('Y');
                            $day = $dt->format('d');
                            $month = \Dreamedit::rus_get_month_name($dt->format('m'), 2);
                            $monthNumber = $dt->format('m');
                        } catch (\Exception $e) {
                        }
                    }
                    $firstHalfYear = substr($year,0,2);
                    $secondHalfYear = substr($year, 2,2);

                    $section->addText(
                        mb_convert_encoding('Федеральное государственное бюджетное научное учреждение',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $section->addText(
                        mb_convert_encoding('«Национальный исследовательский институт мировой экономики и международных отношений имени Е.М. Примакова Российской академии наук»',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $section->addText(
                        mb_convert_encoding('(ИМЭМО им. Е.М. Примакова РАН)',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    $section->addText(
                        mb_convert_encoding("ПРОТОКОЛ № {$contest->getProtocol()}","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $section->addText(
                        mb_convert_encoding('заседания Конкурсной комиссии',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $section->addText(
                        mb_convert_encoding('для проведения Конкурса на замещение должностей научных работников',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $section->addText(
                        mb_convert_encoding('ИМЭМО им. Е.М. Примакова РАН',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                        array('align' => 'center')
                    );
                    $textRun = $section->addTextRun(array('align' => 'center'));
                    $textRun->addText(
                        mb_convert_encoding('от «',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                    $textRun->addText(
                        mb_convert_encoding($day,"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                    );
                    $textRun->addText(
                        mb_convert_encoding('»  ',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                    $textRun->addText(
                        mb_convert_encoding($month,"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                    );
                    $textRun->addText(
                        mb_convert_encoding(" {$firstHalfYear}","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                    $textRun->addText(
                        mb_convert_encoding($secondHalfYear,"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                    );
                    $textRun->addText(
                        mb_convert_encoding('г.',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    $section->addText(
                        mb_convert_encoding('Списочный состав Конкурсной комиссии утверждён Приказом директора ИМЭМО им. Е.М. Примакова РАН от 22.12.2017 г.№ 30 о/д» (с изменениями, утвержденными Приказом по Институту от 20.12.2022 г. № 53 о/д) в составе 18 человек, в том числе одного секретаря без права голоса.',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify')
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    $textRun = $section->addTextRun(array('align' => 'justify'));
                    if($contest->isOnlineVote()) {
                        $numberOfPeoplePresented = $contest->getNumberOfPeoplePresented();
                        if(empty($numberOfPeoplePresented)) {
                            $participatedUsers = array();
                            foreach ($onlineVoteResults as $onlineVoteResult) {
                                if(!in_array($onlineVoteResult->getUser()->getId(),$participatedUsers)) {
                                    $participatedUsers[] = $onlineVoteResult->getUser()->getId();
                                }
                            }
                            $numberOfPeoplePresented = count($participatedUsers);
                        }
                        $textRun->addText(
                            mb_convert_encoding('В голосовании приняли участие ', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                        $textRun->addText(
                            mb_convert_encoding($numberOfPeoplePresented, "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                        );
                        $participatedText = \Dreamedit::RusEnding((int)$numberOfPeoplePresented,"член","члена", "членов");
                        $textRun->addText(
                            mb_convert_encoding(" {$participatedText} Конкурсной комиссии согласно рейтинговым листам (см. прил.) Кворум имеется.", "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                    } else {
                        $numberOfPeoplePresented = $contest->getNumberOfPeoplePresented();
                        $textRun->addText(
                            mb_convert_encoding('На заседании присутствовали: ', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                        $textRun->addText(
                            mb_convert_encoding($numberOfPeoplePresented, "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                        );
                        $participatedText = \Dreamedit::RusEnding((int)$numberOfPeoplePresented,"человек","человека", "человек");
                        $textRun->addText(
                            mb_convert_encoding(" {$participatedText} (см. явочный лист). Кворум имеется.", "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                    }
                    $chairmanFio = "";
                    $chairmanPosition = "";
                    $chairmanSign = "";
                    if($contest->getChairman() != null) {
                        if($contest->getChairman()->getPosition()!="") {
                            $chairmanPosition = $contest->getChairman()->getPosition()." ";
                        }
                        $chairmanSign = $contest->getChairman()->getSign();
                        $chairmanFio = $contest->getChairman()->getLastName();
                        if($contest->getChairman()->getFirstName()!="") {
                            $chairmanFio .= " ".substr($contest->getChairman()->getFirstName(),0,1).".";
                        }
                        if($contest->getChairman()->getThirdName()!="") {
                            $chairmanFio .= substr($contest->getChairman()->getThirdName(),0,1).".";
                        }
                    }
                    $section->addText(
                        mb_convert_encoding('Председательствует на заседании: '.$chairmanPosition.$chairmanFio,"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify')
                    );
                    $secretaryFio = "";
                    $secretarySign = "";
                    if($contest->getSecretary() != null) {
                        $secretarySign = $contest->getSecretary()->getSign();
                        $secretaryFio = $contest->getSecretary()->getLastName();
                        if($contest->getSecretary()->getFirstName()!="") {
                            $secretaryFio .= " ".substr($contest->getSecretary()->getFirstName(),0,1).".";
                        }
                        if($contest->getSecretary()->getThirdName()!="") {
                            $secretaryFio .= substr($contest->getSecretary()->getThirdName(),0,1).".";
                        }
                    }

                    $section->addText(
                        mb_convert_encoding("Секретарь Конкурсной комиссии: {$secretaryFio}","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify')
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    $section->addText(
                        mb_convert_encoding('Повестка дня:',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'center')
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    $section->addText(
                        mb_convert_encoding("О замещении должности {$positionR} Федерального государственного бюджетного научного учреждения «Национальный исследовательский институт мировой экономики и международных отношений имени Е.М. Примакова Российской академии наук» (ИМЭМО им. Е.М. Примакова РАН).","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify')
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    if(!$contest->isOnlineVote()) {
                        $applicantsCount = count($contest->getApplicants());
                        $applicantsText = \Dreamedit::RusEnding((int)$applicantsCount,"кандидата","кандидатов", "кандидатов");
                        $applicantFios = "";
                        foreach ($contest->getApplicants() as $applicant) {
                            if(!empty($applicantFios)) {
                                $applicantFios .= " и ";
                            }
                            if($applicant->getLastNameR()!="") {
                                $applicantFios.=$applicant->getLastNameR();
                            } else {
                                $applicantFios.= $applicant->getLastName();
                            }

                            if($applicant->getFirstName()!="") {
                                $applicantFios.=" ".substr($applicant->getFirstName(),0,1).".";
                            }
                            if($applicant->getThirdName()!="") {
                                $applicantFios.=substr($applicant->getThirdName(),0,1).".";
                            }
                        }
                        $section->addText(
                            mb_convert_encoding("В конкурсную комиссию поступили заявления от {$applicantsCount} {$applicantsText}: {$applicantFios}","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify')
                        );
                    }
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                    $section->addText(
                        mb_convert_encoding("По результатам проведения конкурса на замещение должности {$positionR} получены следующие результаты:","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify')
                    );
                    if($contest->isOnlineVote()) {
                        $counterApplicants = 1;
                        $beforeTotal = -1;
                        $secondPlaceBeforeTotal = -1;
                        $firstPlace = null;
                        $secondPlace = null;
                        foreach ($contest->getApplicants() as $applicant) {
                            $section->addTextBreak(1, array('name' => 'Times New Roman', 'size' => 12));
                            $textRun = $section->addTextRun(array('align' => 'justify'));
                            $textRun->addText(
                                mb_convert_encoding("Кандидат № {$counterApplicants}:  ", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
                            );
                            $applicantFio = $applicant->getLastName();
                            if ($applicant->getFirstName() != "") {
                                $applicantFio .= " " . substr($applicant->getFirstName(), 0, 1) . ".";
                            }
                            if ($applicant->getThirdName() != "") {
                                $applicantFio .= substr($applicant->getThirdName(), 0, 1) . ".";
                            }
                            $textRun->addText(
                                mb_convert_encoding($applicantFio, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, "bold" => true, "underline" => "single")
                            );
                            $section->addTextBreak(1, array('name' => 'Times New Roman', 'size' => 12));
                            $total = 0;
                            $manualTotal = $applicant->getOnlineVoteManualTotal();
                            if(!empty($manualTotal)) {
                                $total = $manualTotal;
                            } else {
                                if (!empty($onlineVoteResults)) {
                                    $applicantResults = array_filter(
                                        $onlineVoteResults,
                                        function (OnlineVoteResult $e) use (&$applicant) {
                                            return ($e->getApplicant()->getId() == $applicant->getId());
                                        }
                                    );
                                    foreach ($applicantResults as $applicantResult) {
                                        $total += $applicantResult->getTotal();
                                    }
                                }
                            }
                            if($total > $beforeTotal) {
                                $secondPlaceBeforeTotal = $beforeTotal;
                                $beforeTotal = $total;
                                $secondPlace = $firstPlace;
                                $firstPlace = $applicant;
                            } else {
                                if($total > $secondPlaceBeforeTotal) {
                                    $secondPlaceBeforeTotal = $total;
                                    $secondPlace = $applicant;
                                }
                            }

                            $section->addText(
                                mb_convert_encoding("СУММА БАЛЛЬНОЙ ОЦЕНКИ членов Конкурсной комиссии, принявших участие в заседании, согласно рейтинговым листам : {$total}", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12),
                                array('align' => 'justify')
                            );
                            $counterApplicants++;
                        }
                        $section->addTextBreak(2, array('name' => 'Times New Roman', 'size' => 12));
                        $section->addText(
                            mb_convert_encoding('РЕШЕНИЕ Конкурсной комиссии :', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify')
                        );
                        $section->addTextBreak(1, array('name' => 'Times New Roman', 'size' => 12));
                        $textRun = $section->addTextRun(array('align' => 'justify'));
                        $textRun->addText(
                            mb_convert_encoding("По результатам конкурса на замещение должности {$positionR} победителем является ", "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                        if($contest->getFirstPlace() != null) {
                            $firstPlace = $contest->getFirstPlace();
                        }
                        if($contest->getSecondPlace() != null) {
                            $secondPlace = $contest->getSecondPlace();
                        }
                        $applicantFio = "";
                        if(!empty($firstPlace)) {
                            $applicantFio = $firstPlace->getLastName();
                            if ($firstPlace->getFirstName() != "") {
                                $applicantFio .= " " . substr($firstPlace->getFirstName(), 0, 1) . ".";
                            }
                            if ($firstPlace->getThirdName() != "") {
                                $applicantFio .= substr($firstPlace->getThirdName(), 0, 1) . ".";
                            }
                        }
                        $textRun->addText(
                            mb_convert_encoding($applicantFio, "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
                        );
                        $textRun->addText(
                            mb_convert_encoding(' Второе место - ', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                        $applicantFio = "отсутствует.";
                        if(!empty($secondPlace)) {
                            $applicantFio = $secondPlace->getLastName();
                            if ($secondPlace->getFirstName() != "") {
                                $applicantFio .= " " . substr($secondPlace->getFirstName(), 0, 1) . ".";
                            }
                            if ($secondPlace->getThirdName() != "") {
                                $applicantFio .= substr($secondPlace->getThirdName(), 0, 1) . ".";
                            }
                        }
                        $textRun->addText(
                            mb_convert_encoding($applicantFio, "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
                        );
                    } else {
                        $counterApplicants = 1;
                        $beforeTotal = -1;
                        $firstPlace = null;
                        $secondPlace = null;
                        if($contest->getFirstPlace() != null) {
                            $firstPlace = $contest->getFirstPlace();
                        }
                        if($contest->getSecondPlace() != null) {
                            $secondPlace = $contest->getSecondPlace();
                        }

                        $section->addTextBreak(1, array('name' => 'Times New Roman', 'size' => 12));
                        foreach ($contest->getApplicants() as $applicant) {
                            $applicantFio = "";
                            if($applicant->getLastNameR()!="") {
                                $applicantFio = $applicant->getLastNameR();
                            } else {
                                $applicantFio = $applicant->getLastName();
                            }

                            if($applicant->getFirstName()!="") {
                                $applicantFio.=" ".substr($applicant->getFirstName(),0,1).".";
                            }
                            if($applicant->getThirdName()!="") {
                                $applicantFio.=substr($applicant->getThirdName(),0,1).".";
                            }
                            $textRun = $section->addTextRun(array('align' => 'justify'));
                            $textRun->addText(
                                mb_convert_encoding("За кандидата № {$counterApplicants} :  {$applicantFio}", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
                            );
                            $textRun->addText(
                                mb_convert_encoding(" отдано:", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );

                            $for = "0";
                            $against = "0";
                            $abstained = "0";

                            if (!empty($openVoteResults)) {
                                $result = array_shift(array_filter(
                                    $openVoteResults,
                                    function (OpenVoteResult $e) use (&$applicant) {
                                        return $e->getApplicant()->getId() == $applicant->getId();
                                    }
                                ));

                                if (!empty($result)) {
                                    $for = $result->getFor();
                                    $against = $result->getAgainst();
                                    $abstained = $result->getAbstained();
                                }
                            }

                            $textRun = $section->addTextRun(array('align' => 'left'));
                            $textRun->addText(
                                mb_convert_encoding("«За» ", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );
                            $textRun->addText(
                                mb_convert_encoding($for, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                            );
                            $textRun->addText(
                                mb_convert_encoding(" голосов", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );
                            $textRun->addText(
                                mb_convert_encoding(", «Против» ", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );
                            $textRun->addText(
                                mb_convert_encoding($against, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                            );
                            $textRun->addText(
                                mb_convert_encoding(" голосов", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );
                            $textRun->addText(
                                mb_convert_encoding(", «Воздержался» ", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );
                            $textRun->addText(
                                mb_convert_encoding($abstained, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
                            );
                            $textRun->addText(
                                mb_convert_encoding(" голосов", "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12)
                            );

                            $counterApplicants++;
                        }

                        $section->addTextBreak(2, array('name' => 'Times New Roman', 'size' => 12));
                        $section->addText(
                            mb_convert_encoding('РЕШЕНИЕ Конкурсной комиссии :', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify')
                        );
                        $textRun = $section->addTextRun(array('align' => 'justify'));
                        $textRun->addText(
                            mb_convert_encoding("По результатам конкурса на замещение должности {$positionR} победителем является ", "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12)
                        );
                        $applicantFio = "";
                        if(!empty($firstPlace)) {
                            $applicantFio = $firstPlace->getLastName();
                            if ($firstPlace->getFirstName() != "") {
                                $applicantFio .= " " . substr($firstPlace->getFirstName(), 0, 1) . ".";
                            }
                            if ($firstPlace->getThirdName() != "") {
                                $applicantFio .= substr($firstPlace->getThirdName(), 0, 1) . ".";
                            }
                        }
                        $textRun->addText(
                            mb_convert_encoding($applicantFio, "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
                        );
                    }

                    $section->addPageBreak();

                    $section->addText(
                        mb_convert_encoding('Признать конкурс на замещение вышеуказанной должности научного работника ИМЭМО им. Е.М. Примакова РАН состоявшимся.',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                    );
                    $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));

                    switch($contest->getContractTerm()) {
                        case "срочный трудовой договор до 1 года":
                            $contractTerm = " на срок до 1 года";
                            break;
                        case "срочный трудовой договор до 3 лет":
                            $contractTerm = " на срок до 3 лет";
                            break;
                        case "срочный трудовой договор до 5 лет":
                            $contractTerm = " на срок до 5 лет";
                            break;
                        case "трудовой договор на неопределенный срок":
                            $contractTerm = " на неопределенный срок";
                            break;
                        case "срочный трудовой договор до истечения срока полномочий директора":
                            $contractTerm = " до истечения срока полномочий директора";
                            break;
                        default:
                            $contractTerm = "";
                    }
                    $section->addText(
                        mb_convert_encoding('Результаты конкурса считать основанием для заключения трудового договора с победителем'.$contractTerm.".","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                    );

                    $section->addTextBreak(2,array('name' => 'Times New Roman', 'size' => 12));

                    $tableStyle = array(
                        'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
                        'unit' => 'dxa'
                    );
                    $table = $section->addTable($tableStyle);
                    $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(17));
                    $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0));
                    $table->addRow();
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                        array(
                            'valign' => 'bottom'
                        )
                    );
                    $cell->addText(
                        mb_convert_encoding('Председатель Конкурсной комиссии',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'left')
                    );
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                        array(
                            'borderBottomColor' => '000000',
                            'borderBottomSize'  => 1,
                            'valign' => 'bottom'
                        )
                    );
//                    if(!empty($chairmanSign)) {
//                        $cell->addImage(
//                            $this->contest->getDownloadService()->getSignsUploadPath().$chairmanSign,
//                            array('align' => 'center', 'width' => '150')
//                        );
//                    }

                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                        array(
                            'valign' => 'bottom'
                        )
                    );

                    $cell->addText(
                        mb_convert_encoding($chairmanFio,"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'center')
                    );
                    $tableStyle = array(
                        'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'unit' => 'dxa'
                    );


                    $table = $section->addTable($tableStyle);
                    $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
                    $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                    $table->addRow();
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
                    );
                    $cell->addText(
                        mb_convert_encoding('',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'center')
                    );
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));

                    $tableStyle = array(
                        'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
                        'unit' => 'dxa'
                    );

                    $table = $section->addTable($tableStyle);
                    $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
                    $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                    $table->addRow();
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                        array(
                            'valign' => 'bottom'
                        )
                    );
                    $cell->addText(
                        mb_convert_encoding('Секретарь Конкурсной комиссии',"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'left')
                    );
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                        array(
                            'borderBottomColor' => '000000',
                            'borderBottomSize'  => 1,
                            'valign' => 'bottom'
                        )
                    );
//                    if(!empty($secretarySign)) {
//                        $cell->addImage(
//                            $this->contest->getDownloadService()->getSignsUploadPath().$secretarySign,
//                            array('align' => 'center', 'width' => '150')
//                        );
//                    }
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                        array(
                            'valign' => 'bottom'
                        )
                    );

                    $cell->addText(
                        mb_convert_encoding($secretaryFio,"UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'center')
                    );
                    $tableStyle = array(
                        'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                        'unit' => 'dxa'
                    );
                    $table = $section->addTable($tableStyle);
                    $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
                    $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                    $table->addRow();
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
                    $cell = $table->addCell(
                        \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
                    );
//                    $tableInside = $cell->addTable($tableStyle);
//                    $tableInside->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
//                    $tableInside->addRow();
//                    $cellInside = $tableInside->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
//                    $cellInside->addText(
//                        mb_convert_encoding('Подпись верна',"UTF-8","windows-1251"),
//                        array('name' => 'Times New Roman', 'size' => 12, 'color' => '00b04f', 'bold' => true),
//                        array('align' => 'left')
//                    );
//                    $cellInside = $tableInside->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
//
//                    try {
//                        $dt = new \DateTime();
//                        $cellInside->addText(
//                            mb_convert_encoding($dt->format('d.m.Y'),"UTF-8","windows-1251"),
//                            array('name' => 'Times New Roman', 'size' => 12),
//                            array('align' => 'right')
//                        );
//                        $cellInside->addText(
//                            mb_convert_encoding($dt->format('H:i:s'),"UTF-8","windows-1251"),
//                            array('name' => 'Times New Roman', 'size' => 12),
//                            array('align' => 'right')
//                        );
//                    } catch (\Exception $e) {
//                    }


                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));





                    $filename = \Dreamedit::encodeText("Протокол № {$contest->getProtocol()}.docx");

                    header("Content-Description: File Transfer");
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                    header('Content-Transfer-Encoding: binary');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Expires: 0');

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save("php://output");

                    exit();
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