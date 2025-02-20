<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\Applicant;
use Contest\Models\OnlineVoteResult;
use Contest\Models\User;
use Contest\PageBuilders\PageBuilder;

class ResultList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;
    /** @var OnlineVoteResult[] */
    private $results = array();
    /** @var int[] */
    private $resultsUsers = array();

    /**
     * ResultList constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
    }


    /**
     * @param \PhpOffice\PhpWord\Element\Table $table
     * @param int $number
     * @param User $user
     * @param string[] $position
     * @param Applicant[] $applicants
     */
    private function addUserResult(&$table, $number, &$user, $positions, $applicants) {
        $firstname = "";
        if($user->getFirstName()!="") {
            $firstname = substr($user->getFirstName(),0,1).".";
        }
        $thirdname = "";
        if($user->getThirdName()!="") {
            $thirdname = substr($user->getThirdName(),0,1).".";
        }

        $table->addRow();
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75));
        $cell->addText(
            mb_convert_encoding($number,"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.2));
        $cell->addText(
            mb_convert_encoding($user->getLastName() . " " . $firstname . $thirdname,"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
            array('align' => 'center')
        );
        foreach ($positions as $position) {
            $cell->addText(
                mb_convert_encoding($position,"UTF-8","windows-1251"),
                array('name' => 'Times New Roman', 'size' => 10, 'bold' => true),
                array('align' => 'center')
            );
        }
        if(in_array($user->getId(),$this->resultsUsers)) {
            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
            $cell->addText(
                mb_convert_encoding('äà',"UTF-8","windows-1251"),
                array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                array('align' => 'center')
            );
            foreach ($applicants as $applicant) {
                $total = "";
                if(!empty($this->results)) {
                    $result = array_shift(array_filter(
                        $this->results,
                        function (OnlineVoteResult $e) use (&$applicant,&$user) {
                            return ($e->getApplicant()->getId() == $applicant->getId() && $e->getUser()->getId() == $user->getId());
                        }
                    ));

                    if(!empty($result)) {
                        $total = $result->getTotal();
                    }
                }

                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                $cell->addText(
                    mb_convert_encoding($total,"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                    array('align' => 'center')
                );
            }
        } else {
            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
            $cell->addText(
                mb_convert_encoding('íåò',"UTF-8","windows-1251"),
                array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                array('align' => 'center')
            );
            foreach ($applicants as $applicant) {
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                $cell->addText(
                    mb_convert_encoding('',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                    array('align' => 'center')
                );
            }
        }
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

                        $this->results = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestId($_GET['contest_id']);

                        $this->resultsUsers = array_map(function (OnlineVoteResult $el) {
                            return $el->getUser()->getId();
                        }, $this->results);

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
                        $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_LANDSCAPE);

                        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.65));
                        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
                        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));

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
                        $positionR = mb_strtoupper($contest->getPositionR(), "windows-1251");

                        $section->addText(
                            mb_convert_encoding("ÑÂÎÄÍÛÉ ĞÅÉÒÈÍÃÎÂÛÉ ËÈÑÒ ×ËÅÍÎÂ ÊÎÍÊÓĞÑÍÎÉ ÊÎÌÈÑÑÈÈ ÏÎ ĞÅÇÓËÜÒÀÒÀÌ ÏĞÎÂÅÄÅÍÈß ÊÎÍÊÓĞÑÀ ÍÀ {$positionR}", "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                            array('align' => 'center')
                        );
                        $section->addTextBreak(1, array('name' => 'Times New Roman', 'size' => 12));

                        $tableStyle = array(
                            'borderColor' => '000000',
                            'borderSize' => 1,
                            'cellMarginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.05),
                            'unit' => 'dxa'
                        );

                        $table = $section->addTable($tableStyle);
                        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
                        $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                        $table->addRow();
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75), array("vMerge" => "restart"));
                        $cell->addText(
                            mb_convert_encoding('¹', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.2), array("vMerge" => "restart"));
                        $cell->addText(
                            mb_convert_encoding('Ô.È.Î ÷ëåíà Êîíêóğñíîé êîìèññèè', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), array("vMerge" => "restart"));
                        $cell->addText(
                            mb_convert_encoding('Îòìåòêà îá ó÷àñòèè', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(9), array("gridspan" => count($contest->getApplicants())));
                        $cell->addText(
                            mb_convert_encoding('ÈÒÎÃÎÂÀß ÎÖÅÍÊÀ ×ËÅÍÀ ÊÎÍÊÓĞÑÍÎÉ ÊÎÌÈÑÑÈÈ', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                            array('align' => 'center')
                        );

                        $table->addRow();
                        $cell = $table->addCell(null, array("vMerge" => "continue"));
                        $cell = $table->addCell(null, array("vMerge" => "continue"));
                        $cell = $table->addCell(null, array("vMerge" => "continue"));
                        foreach ($contest->getApplicants() as $applicant) {
                            $firstname = "";
                            if ($applicant->getFirstName() != "") {
                                $firstname = substr($applicant->getFirstName(), 0, 1) . ".";
                            }
                            $thirdname = "";
                            if ($applicant->getThirdName() != "") {
                                $thirdname = substr($applicant->getThirdName(), 0, 1) . ".";
                            }
                            $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                            $cell->addText(
                                mb_convert_encoding($applicant->getLastName() . " " . $firstname . $thirdname, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
                                array('align' => 'center')
                            );
                        }

                        $counterUsers = 1;

                        $chairman = $contest->getChairman();
                        $viceChairman = $contest->getViceChairman();
                        $secretary = $contest->getSecretary();
                        $chairmanId = 0;
                        $viceChairmanId = 0;
                        $secretaryId = 0;

                        if (!empty($chairman)) {
                            $chairmanId = $chairman->getId();
                        }

                        if (!empty($viceChairman)) {
                            $viceChairmanId = $viceChairman->getId();
                        }

                        if (!empty($secretary)) {
                            $secretaryId = $secretary->getId();
                        }

                        if (!empty($chairman)) {
                            $positions = array("ÏĞÅÄÑÅÄÀÒÅËÜ");
                            if ($chairmanId == $viceChairmanId) {
                                $positions[] = "ÇÀÌ. ÏĞÅÄÑÅÄÀÒÅËß";
                            }
                            if ($chairmanId == $secretaryId) {
                                $positions[] = "ÑÅÊĞÅÒÀĞÜ ÊÎÌÈÑÑÈÈ";
                            }
                            $this->addUserResult($table, $counterUsers, $chairman, $positions, $contest->getApplicants());
                            $counterUsers++;
                        }

                        if (!empty($viceChairman)) {
                            $positions = array("ÇÀÌ. ÏĞÅÄÑÅÄÀÒÅËß");
                            if ($viceChairmanId == $secretaryId) {
                                $positions[] = "ÑÅÊĞÅÒÀĞÜ ÊÎÌÈÑÑÈÈ";
                            }
                            if ($viceChairmanId != $chairmanId) {
                                $this->addUserResult($table, $counterUsers, $viceChairman, $positions, $contest->getApplicants());
                                $counterUsers++;
                            }
                        }

                        if (!empty($secretary)) {
                            $positions = array("ÑÅÊĞÅÒÀĞÜ ÊÎÌÈÑÑÈÈ");
                            if ($secretaryId != $chairmanId && $secretaryId != $viceChairmanId) {
                                $this->addUserResult($table, $counterUsers, $secretary, $positions, $contest->getApplicants());
                                $counterUsers++;
                            }
                        }

                        foreach ($contestGroup->getParticipants() as $user) {
                            if ($user->getId() != $chairmanId && $user->getId() != $viceChairmanId && $user->getId() != $secretaryId) {
                                $this->addUserResult($table, $counterUsers, $user, array(), $contest->getApplicants());
                                $counterUsers++;
                            }
                        }

                        $section->addTextBreak(1, array('name' => 'Times New Roman', 'size' => 12));

                        $tableStyle = array(
                            'cellMarginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
                            'unit' => 'dxa'
                        );
                        $table = $section->addTable($tableStyle);
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
                            mb_convert_encoding('Ïğåäñåäàòåëü êîíêóğñíîé êîìèññèè', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(
                            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                            array(
                                'borderBottomColor' => '000000',
                                'borderBottomSize' => 1,
                                'valign' => 'bottom'
                            )
                        );
//                        if(!empty($chairman)) {
//                            if($chairman->getSign()!="") {
//                                $cell->addImage(
//                                    $this->contest->getDownloadService()->getSignsUploadPath().$chairman->getSign(),
//                                    array('align' => 'center', 'width' => '150')
//                                );
//                            }
//                        }

                        $cell = $table->addCell(
                            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15),
                            array(
                                'borderBottomColor' => '000000',
                                'borderBottomSize' => 1,
                                'valign' => 'bottom'
                            )
                        );

                        if (!empty($chairman)) {
                            $firstname = "";
                            if ($chairman->getFirstName() != "") {
                                $firstname = substr($chairman->getFirstName(), 0, 1) . ".";
                            }
                            $thirdname = "";
                            if ($chairman->getThirdName() != "") {
                                $thirdname = substr($chairman->getThirdName(), 0, 1) . ".";
                            }

                            $cell->addText(
                                mb_convert_encoding($chairman->getLastName() . " " . $firstname . $thirdname, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12),
                                array('align' => 'center')
                            );
                        } else {
                            $cell->addText(
                                mb_convert_encoding('', "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12),
                                array('align' => 'center')
                            );
                        }
                        $tableStyle = array(
                            'cellMarginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'unit' => 'dxa'
                        );


                        $table = $section->addTable($tableStyle);
                        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
                        $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                        $table->addRow();
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
                        $cell = $table->addCell(
                            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
                        );
                        $cell->addText(
                            mb_convert_encoding('ïîäïèñü', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(15));
                        $cell->addText(
                            mb_convert_encoding('ğàñøèôğîâêà ïîäïèñè', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'center')
                        );

                        $tableStyle = array(
                            'cellMarginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
                            'unit' => 'dxa'
                        );

                        $table = $section->addTable($tableStyle);
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
                            mb_convert_encoding('Ñåêğåòàğü êîíêóğñíîé êîìèññèè', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(
                            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                            array(
                                'borderBottomColor' => '000000',
                                'borderBottomSize' => 1,
                                'valign' => 'bottom'
                            )
                        );
//                        if(!empty($secretary)) {
//                            if($secretary->getSign()!="") {
//                                $cell->addImage(
//                                    $this->contest->getDownloadService()->getSignsUploadPath().$secretary->getSign(),
//                                    array('align' => 'center', 'width' => '150')
//                                );
//                            }
//                        }
                        $cell = $table->addCell(
                            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15),
                            array(
                                'borderBottomColor' => '000000',
                                'borderBottomSize' => 1,
                                'valign' => 'bottom'
                            )
                        );

                        if (!empty($secretary)) {
                            $firstname = "";
                            if ($secretary->getFirstName() != "") {
                                $firstname = substr($secretary->getFirstName(), 0, 1) . ".";
                            }
                            $thirdname = "";
                            if ($secretary->getThirdName() != "") {
                                $thirdname = substr($secretary->getThirdName(), 0, 1) . ".";
                            }

                            $cell->addText(
                                mb_convert_encoding($secretary->getLastName() . " " . $firstname . $thirdname, "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12),
                                array('align' => 'center')
                            );
                        } else {
                            $cell->addText(
                                mb_convert_encoding('', "UTF-8", "windows-1251"),
                                array('name' => 'Times New Roman', 'size' => 12),
                                array('align' => 'center')
                            );
                        }
                        $tableStyle = array(
                            'cellMarginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'cellMarginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                            'unit' => 'dxa'
                        );
                        $table = $section->addTable($tableStyle);
                        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
                        $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                        $table->addRow();
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
                        $cell = $table->addCell(
                            \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
                        );
                        $cell->addText(
                            mb_convert_encoding('ïîäïèñü', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'center')
                        );
                        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(15));
                        $cell->addText(
                            mb_convert_encoding('ğàñøèôğîâêà ïîäïèñè', "UTF-8", "windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'center')
                        );


                        $filename = \Dreamedit::encodeText("Ïğèëîæåíèå ê ïğîòîêîëó ¹ {$contest->getProtocol()} - Ñâîäíûé ëèñò.docx");

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
                        $this->contest->getPageBuilder()->build(array("error" => "Äàííûé êîíêóğñ ñ îòêğûòûì ãîëîñîâàíèåì"));
                    }
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array("error" => "Íå íàéäåíà ãğóïïà êîíêóğñîâ"));
                }
            } else {
                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                $this->contest->getPageBuilder()->build(array("error" => "Íå íàéäåí êîíêóğñ"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}