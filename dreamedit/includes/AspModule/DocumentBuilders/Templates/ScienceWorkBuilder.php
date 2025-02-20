<?php

namespace AspModule\DocumentBuilders\Templates;

use AspModule\AspModule;
use AspModule\DocumentBuilders\DocumentBuilder;

class ScienceWorkBuilder extends DocumentBuilder {

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        parent::__construct();
        $this->aspModule = $aspModule;
    }

    public function getDocument($downloadFileName)
    {
        if(empty($_GET['user_id'])) {
            $currentUser = $this->aspModule->getCurrentUser();
        } else {
            if ($this->aspModule->getStatusService()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $currentUser = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
            } else {
                echo "������ �������.";
                exit;
            }
        }

        require_once __DIR__.'/../../../PhpWord/Autoloader.php';
        require_once __DIR__.'/../../../Common/Text.php';
        require_once __DIR__.'/../../../dompdf/autoload.inc.php';
        require_once __DIR__.'/../../../Common/XMLWriter.php';

        \PhpOffice\PhpWord\Autoloader::register();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));

        $section = $phpWord->addSection();

        $sectionStyle = $section->getStyle();
        $footer = $section->addFooter();
        $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_PORTRAIT);

        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.5));
        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));

        $section->addText(
            mb_convert_encoding('������ ������� ������',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 12, "bold" => true),
            array('align' => 'center')
        );
        $section->addTextBreak(1,array('name' => 'Arial', 'size' => 12));
        $section->addText(
            mb_convert_encoding("{$currentUser->getLastName()} {$currentUser->getFirstName()} {$currentUser->getThirdName()}","UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 12, "bold" => true),
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
        $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(19));
        $table->addRow();
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('�� �/�',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.26),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('������������ �������� �����',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4),array("vMerge" => "restart"));

        $cell->addText(
            mb_convert_encoding('�������� ������������, �������',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('�������� �������, ������������� � ����, WoS (��, ESCI), Scopus;',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('�������� ������ �� ������ �� ����� �������',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('��� �������, � �������',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );

        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('���-�� ������� � ����� � ��� / ���. ������ (��� ����); �������� (��� ������).',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell->addText(
            mb_convert_encoding('��� ������� ��������� ������� ��������� �����',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );

        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('���������� (������� ���������)',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
            array('align' => 'center')
        );

        //////

        $table->addRow();

        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('1',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.26),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('2',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4),array("vMerge" => "restart"));

        $cell->addText(
            mb_convert_encoding('3',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );
        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('4',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );

        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('5',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );

        $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
        $cell->addText(
            mb_convert_encoding('6',"UTF-8","windows-1251"),
            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
            array('align' => 'center')
        );

        /////

        $scienceWorkCount = 0;

        foreach ($this->aspModule->getScienceWorkService()->getScienceWorkTypes() as $key => $scienceWorkType) {
            $filteredScienceWorkList = array_filter($currentUser->getScienceWorkList(), function ($val) use ($key) {
                return (int)$val['science_work_type'] === $key;
            });

            if(!empty($filteredScienceWorkList)) {
                $table->addRow();
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(19), array("gridspan" => "6"));
                $cell->addText(
                    mb_convert_encoding($scienceWorkType, "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
                    array('align' => 'center')
                );
                foreach ($filteredScienceWorkList as $scienceWorkItem) {
                    $scienceWorkCount++;
                    $table->addRow();

                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),array("vMerge" => "restart"));
                    $cell->addText(
                        mb_convert_encoding($scienceWorkCount,"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.26),array("vMerge" => "restart"));
                    $cell->addText(
                        mb_convert_encoding($scienceWorkItem['science_work_name'],"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4),array("vMerge" => "restart"));

                    $cell->addText(
                        mb_convert_encoding($scienceWorkItem['science_work_journal_name'],"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );
                    if($scienceWorkItem['science_work_journal_rinc']) {
                        $cell->addText(
                            mb_convert_encoding("������������� � ����", "UTF-8", "windows-1251"),
                            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                            array('align' => 'center')
                        );
                    }
                    if($scienceWorkItem['science_work_journal_wos']) {
                        $cell->addText(
                            mb_convert_encoding("������������� � WoS", "UTF-8", "windows-1251"),
                            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                            array('align' => 'center')
                        );
                    }
                    if($scienceWorkItem['science_work_journal_scopus']) {
                        $cell->addText(
                            mb_convert_encoding("������������� � Scopus", "UTF-8", "windows-1251"),
                            array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                            array('align' => 'center')
                        );
                    }
                    $cell->addText(
                        mb_convert_encoding($scienceWorkItem['science_work_site_link'],"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),array("vMerge" => "restart"));
                    $cell->addText(
                        mb_convert_encoding($scienceWorkItem['science_work_year'] .", ".$scienceWorkItem['science_work_number'],"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );

                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
                    $cell->addText(
                        mb_convert_encoding($scienceWorkItem['science_work_pages'],"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );

                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
                    $cell->addText(
                        mb_convert_encoding($scienceWorkItem['science_work_other_authors'],"UTF-8","windows-1251"),
                        array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
                        array('align' => 'center')
                    );
                }
            }
        }

        $footer->addText(
            mb_convert_encoding('"___"____________________20     �.	                               ����� ____________/_________________',"UTF-8","windows-1251"),
            array('name' => 'Times New Roman', 'size' => 12)
        );

        $filename = \Dreamedit::encodeText("$downloadFileName.docx");

        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");
    }

}