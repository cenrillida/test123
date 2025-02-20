<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\Applicant;
use Contest\Models\OnlineVoteResult;
use Contest\Models\User;
use Contest\PageBuilders\PageBuilder;

class UserResultList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * UserResultList constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
    }

    /**
     * @param \Contest\Models\Contest $contest
     * @param User $user
     * @param \PhpOffice\PhpWord\Element\Section $section
     * @param \PhpOffice\PhpWord\Element\Footer $footer
     */
    private function buildUserList($contest, $user, &$section, &$footer) {
        $onlineVoteResult = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestIdAndUserId($contest->getId(), $user->getId());
        $date = $contest->getDate();
        $day = "____";
        $month = "_______";
        $year = date('Y');
        if (!empty($date) && $date != "0000-00-00") {
            try {
                $dt = new \DateTime($date);
                $year = $dt->format('Y');
                $day = $dt->format('d');
                $month = \Dreamedit::rus_get_month_name($dt->format('m'), 2);
            } catch (\Exception $e) {
            }
        }
        $positionR = $contest->getPositionR();
        $positionR = mb_strtolower(substr($positionR,0,1),"windows-1251").substr($positionR,1);

        $firstname = "";
        if ($user->getFirstName() != "") {
            $firstname = substr($user->getFirstName(), 0, 1) . ".";
        }
        $thirdname = "";
        if ($user->getThirdName() != "") {
            $thirdname = substr($user->getThirdName(), 0, 1) . ".";
        }
        $fullname = $user->getLastName() . " " . $firstname . $thirdname;


        $section->addText(
            mb_convert_encoding('����������� ��������������� ��������� ������� ���������� ������������� ����������������� �������� ������� ��������� �',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
            array('align' => 'center')
        );
        $section->addText(
            mb_convert_encoding('������������� ��������� ����� �.�. ��������� ���������� �������� ���� (����� ��. �.�. ��������� ���)',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
            array('align' => 'center')
        );
        $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
        $section->addText(
            mb_convert_encoding('����������� ����',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
            array('align' => 'center')
        );
        $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));

        $tableStyle = array(
            'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.25)
        );
        $table = $section->addTable($tableStyle);
        $table->addRow();
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
        $cell->addText(
            mb_convert_encoding('����� ���������� ��������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15),
            array(
                'borderBottomColor' => '000000',
                'borderBottomSize'  => 1
            )
        );
        $cell->addText(
            mb_convert_encoding($fullname,"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
            array('align' => 'left')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5));
        $cell->addText(
            mb_convert_encoding("�� �{$day}� {$month} {$year} �.","UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $tableStyle = array(
            'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19)
        );
        $table = $section->addTable($tableStyle);
        $table->addRow();
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15)
        );
        $cell->addText(
            mb_convert_encoding('(�.�.�.)',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 9),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5));

        $section->addText(
            mb_convert_encoding("��� ���������� ������ �������� �� ��������� ��������� ��������� {$positionR}","UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'left')
        );

        $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));

        $section->addText(
            mb_convert_encoding('�������� ��������� ����������:',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'left')
        );

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 1,
            'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.05),
            'unit' => 'dxa'
        );

        $table = $section->addTable($tableStyle);
        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
        $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
        $table->addRow();
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75));
        $cell->addText(
            mb_convert_encoding('�',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.2));
        $cell->addText(
            mb_convert_encoding('�.�.�',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('�����������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(13));
        $cell->addText(
            mb_convert_encoding('�������� ����������, ����� ���������� ',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������������ �� ���������� �����������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������� ����������: ����������, ������, � �.�. �',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������������� ��������; ������� � ������� ��',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������� � ���������, ���������-�������������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('���������, ������� � ���������� ������������,',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������� � ������� ������������, ������������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('���������� �������� ����������� �����������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������������, ������� � ��������������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������������ �� ����������� �����������, ������� �',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������-��������������� ������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('(0-10 ������)',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(9));
        $cell->addText(
            mb_convert_encoding('���� � ������������ �����������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('(0-10 ������)',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
        );
        $cell->addText(
            mb_convert_encoding('�������������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 10.5, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('(0-5 ������)',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 10.5),
            array('align' => 'center')
        );
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
        );
        $cell->addText(
            mb_convert_encoding('��������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('��������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('�����',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('��������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );

        $counter = 1;
        foreach ($contest->getApplicants() as $applicant) {

            $scienceResults = "0";
            $experience = "0";
            $total = "0";
            $interview = "-1";

            $voteExist = true;

            if (!empty($onlineVoteResult)) {
                $result = array_shift(array_filter(
                    $onlineVoteResult,
                    function (OnlineVoteResult $e) use (&$applicant) {
                        return $e->getApplicant()->getId() == $applicant->getId();
                    }
                ));

                if (!empty($result)) {
                    $scienceResults = $result->getScienceResults();
                    $experience = $result->getExperience();
                    $total = $result->getTotal();
                    $interview = $result->getInterview();
                } else {
                    $voteExist = false;
                }
            } else {
                $voteExist = false;
            }
            if($interview == "-1") {
                $interview = "���";
            }

            $table->addRow();
            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75));
            $cell->addText(
                mb_convert_encoding($counter,"UTF-8","windows-1251"),
                array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                array('align' => 'center')
            );
            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.2));
            $applicantFullName = $applicant->getLastName() . " " . substr($applicant->getFirstName(),0,1) . ".";
            if($applicant->getThirdName()!="") {
                $applicantFullName .= substr($applicant->getThirdName(),0,1).".";
            }
            $cell->addText(
                mb_convert_encoding($applicantFullName,"UTF-8","windows-1251"),
                array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                array('align' => 'center')
            );
            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(13));
            if($voteExist) {
                $cell->addText(
                    mb_convert_encoding($scienceResults,"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                    array('align' => 'center')
                );
            }
            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(9));
            if($voteExist) {
                $cell->addText(
                    mb_convert_encoding($experience, "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                    array('align' => 'center')
                );
            }
            $cell = $table->addCell(
                \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
            );
            $cell->addText(
                mb_convert_encoding($interview,"UTF-8","windows-1251"),
                array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                array('align' => 'center')
            );
            $cell = $table->addCell(
                \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
            );
            if($voteExist) {
                $cell->addText(
                    mb_convert_encoding($total, "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                    array('align' => 'center')
                );
            }
            $counter++;
        }


        $section->addTextBreak(2,array('name' => 'Times New Roman', 'size' => 12));

        $tableStyle = array(
            'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
            'unit' => 'dxa'
        );
        $table = $footer->addTable($tableStyle);
        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
        $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
        $table->addRow();
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(6),
            array(
                'valign' => 'bottom'
            )
        );
        $cell->addText(
            mb_convert_encoding('���� ���������� ��������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
            array(
                'borderBottomColor' => '000000',
                'borderBottomSize'  => 1,
                'valign' => 'bottom'
            )
        );
        $cell->addText(
            mb_convert_encoding('����������� ����������� ����',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'italic' => true),
            array('align' => 'center')
        );
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15),
            array(
                'borderBottomColor' => '000000',
                'borderBottomSize'  => 1,
                'valign' => 'bottom'
            )
        );

        $cell->addText(
            mb_convert_encoding($fullname,"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $tableStyle = array(
            'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
            'unit' => 'dxa'
        );
        $table = $footer->addTable($tableStyle);
        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
        $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
        $table->addRow();
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
        $cell = $table->addCell(
            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
        );
        $cell->addText(
            mb_convert_encoding('�������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(15));
        $cell->addText(
            mb_convert_encoding('����������� �������',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12),
            array('align' => 'center')
        );
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if(
            $currentUser->getStatus()->isAdmin() &&
            !empty($_GET['contest_id']) &&
            is_numeric($_GET['contest_id'])
        ) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($contest->getContestGroupId());
                if(!empty($contestGroup)) {
                    if($contest->isOnlineVote()) {

                        require_once __DIR__ . '/../../../PhpWord/Autoloader.php';
                        require_once __DIR__ . '/../../../Common/Text.php';
                        require_once __DIR__ . '/../../../dompdf/autoload.inc.php';
                        require_once __DIR__ . '/../../../Common/XMLWriter.php';

                        \PhpOffice\PhpWord\Autoloader::register();

                        $phpWord = new \PhpOffice\PhpWord\PhpWord();

                        $phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));


                        $filename = \Dreamedit::encodeText("Noname.docx");

                        if(!empty($_GET['user_id']) && is_numeric($_GET['user_id'])) {
                            $user = $this->contest->getUserService()->getUserById($_GET['user_id']);
                            if(!empty($user) && in_array($user, $contestGroup->getParticipants())) {
                                $section = $phpWord->addSection();
                                $sectionStyle = $section->getStyle();
                                $footer = $section->addFooter();
                                $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_LANDSCAPE);

                                $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.65));
                                $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                                $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                                $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                                $this->buildUserList($contest,$user,$section,$footer);

                                $firstname = "";
                                if ($user->getFirstName() != "") {
                                    $firstname = substr($user->getFirstName(), 0, 1) . ".";
                                }
                                $thirdname = "";
                                if ($user->getThirdName() != "") {
                                    $thirdname = substr($user->getThirdName(), 0, 1) . ".";
                                }
                                $fullname = $user->getLastName() . " " . $firstname . $thirdname;

                                $filename = \Dreamedit::encodeText("{$fullname} - ����������� ����.docx");
                            } else {
                                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                                $this->contest->getPageBuilder()->build(array("error" => "������������ �� ������"));
                                exit;
                            }
                        } elseif($_GET['all_users']==1) {
                            foreach ($contestGroup->getParticipants() as $user) {
                                if(!empty($user) && in_array($user, $contestGroup->getParticipants())) {
                                    $onlineVoteResult = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestIdAndUserId($contest->getId(), $user->getId());

                                    if(!empty($onlineVoteResult) || $_GET['empty_too']==1) {
                                        $section = $phpWord->addSection();
                                        $sectionStyle = $section->getStyle();
                                        $footer = $section->addFooter();
                                        $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_LANDSCAPE);

                                        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.65));
                                        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                                        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                                        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                                        $this->buildUserList($contest,$user,$section,$footer);
                                        //$section->addPageBreak();
                                    }
                                }
                            }
                            $filename = \Dreamedit::encodeText("{$contest->getPosition()} - ����������� �����.docx");
                        } else {
                            $this->contest->getPageBuilderManager()->setPageBuilder("error");
                            $this->contest->getPageBuilder()->build(array("error" => "������������ �� ������"));
                            exit;
                        }
                        if(!$params['not_download']) {
                            header("Content-Description: File Transfer");
                            header('Content-Disposition: attachment; filename="' . $filename . '"');
                            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                            header('Content-Transfer-Encoding: binary');
                            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                            header('Expires: 0');
                        }

                        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                        $objWriter->save("php://output");

                        if(!$params['not_download']) {
                            exit();
                        }
                    } else {
                        $this->contest->getPageBuilderManager()->setPageBuilder("error");
                        $this->contest->getPageBuilder()->build(array("error" => "������ ������� � �������� ������������"));
                    }
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array("error" => "�� ������� ������ ���������"));
                }
            } else {
                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                $this->contest->getPageBuilder()->build(array("error" => "�� ������ �������"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}