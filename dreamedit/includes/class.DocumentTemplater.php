<?php
class DocumentTextField {

    /** @var string */
    private $text;
    /** @var int */
    private $numberOfLines;
    /** @var float */
    private $width;
    /** @var float */
    private $height;
    /** @var float */
    private $coordinateX;
    /** @var float */
    private $coordinateY;
    /** @var string */
    private $filePrefix;
    /** @var string */
    private $alignment;
    /** @var int */
    private $size;
    /** @var array */
    private $lineHeightArray;
    /** @var string */
    private $prefixSpaceText;
    /** @var string */
    private $fontFile;
    /** @var string */
    private $fileName;
    /** @var array */
    private $linesParam;

    /**
     * DocumentTextField constructor.
     * @param string $text
     * @param int $numberOfLines
     * @param float $width
     * @param float $height
     * @param float $coordinateX
     * @param float $coordinateY
     * @param string $alignment
     * @param int $size
     * @param string $fontFile
     */
    public function __construct($text, $numberOfLines, $width, $height, $coordinateX, $coordinateY, $filePrefix = "", $alignment = "L", $size = "13", $lineHeightArray = array(), $prefixSpaceText="", $fontFile = "TimesNewRoman.ttf")
    {
        $this->text = $text;
        $this->numberOfLines = $numberOfLines;
        $this->width = $width;
        $this->height = $height;
        $this->coordinateX = $coordinateX;
        $this->coordinateY = $coordinateY;
        $this->filePrefix = $filePrefix;
        $this->alignment = $alignment;
        $this->size = $size;
        $this->fontFile = $fontFile;
        $this->lineHeightArray = $lineHeightArray;
        $this->prefixSpaceText = $prefixSpaceText;
        $this->linesParam = array();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getNumberOfLines()
    {
        return $this->numberOfLines;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getCoordinateX()
    {
        return $this->coordinateX;
    }

    /**
     * @return float
     */
    public function getCoordinateY()
    {
        return $this->coordinateY;
    }

    /**
     * @return string
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getFontFile()
    {
        return $this->fontFile;
    }

    /**
     * @return string
     */
    public function getFilePrefix()
    {
        return $this->filePrefix;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param string $filePrefix
     */
    public function setFilePrefix($filePrefix)
    {
        $this->filePrefix = $filePrefix;
    }

    /**
     * @return array
     */
    public function getLineHeightArray()
    {
        return $this->lineHeightArray;
    }

    /**
     * @return string
     */
    public function getPrefixSpaceText()
    {
        return $this->prefixSpaceText;
    }

    /**
     * @param int $numberOfLines
     */
    public function setNumberOfLines($numberOfLines)
    {
        $this->numberOfLines = $numberOfLines;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return array
     */
    public function getLinesParam()
    {
        return $this->linesParam;
    }

    /**
     * @param array $linesParam
     */
    public function setLinesParam($linesParam)
    {
        $this->linesParam = $linesParam;
    }

}

class DocumentPhotoField {
    /** @var string */
    private $fileName;
    /** @var float */
    private $width;
    /** @var float */
    private $height;
    /** @var float */
    private $coordinateX;
    /** @var float */
    private $coordinateY;

    /**
     * DocumentPhotoField constructor.
     * @param string $fileName
     * @param float $width
     * @param float $height
     * @param float $coordinateX
     * @param float $coordinateY
     */
    public function __construct($fileName, $width, $height, $coordinateX, $coordinateY)
    {
        $this->fileName = $fileName;
        $this->width = $width;
        $this->height = $height;
        $this->coordinateX = $coordinateX;
        $this->coordinateY = $coordinateY;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getCoordinateX()
    {
        return $this->coordinateX;
    }

    /**
     * @return float
     */
    public function getCoordinateY()
    {
        return $this->coordinateY;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

}

class DocumentPage {

    /** @var DocumentTextField[] */
    private $documentTextFields;
    /** @var DocumentPhotoField[] */
    private $documentPhotoFields;

    /**
     * DocumentPage constructor.
     * @param DocumentTextField[] $documentTextFields
     * @param DocumentPhotoField[] $documentPhotoFields
     */
    public function __construct(array $documentTextFields, array $documentPhotoFields = array())
    {
        $this->documentTextFields = $documentTextFields;
        $this->documentPhotoFields = $documentPhotoFields;
    }

    /**
     * @return DocumentTextField[]
     */
    public function getDocumentTextFields()
    {
        return $this->documentTextFields;
    }

    /**
     * @return DocumentPhotoField[]
     */
    public function getDocumentPhotoFields()
    {
        return $this->documentPhotoFields;
    }

}

class DocumentTemplater {

    public function __construct()
    {
        require_once 'tfpdf/tfpdf.php';
        require_once 'FPDF/fpdf.php';
        require_once 'FPDI/fpdi.php';
    }

    /**
     * @param string $templateFile
     * @param DocumentPage[] $documentPages
     * @param string $downloadFileName
     * @param string $orientation
     */
    public function fillFileWithTemplate($templateFile,$documentPages,$downloadFileName="",$orientation = "P") {



        $pageCounter = 1;
        $pdf = new FPDI($orientation);
        foreach ($documentPages as $documentPage) {

            $pdf->AddPage("P");
            $pdf->AddFont('DejaVu', '', 'TimesNewRoman.ttf', true);


            $pdf->setSourceFile($templateFile);
            $tplIdx = $pdf->importPage($pageCounter);
            $size = $pdf->getTemplateSize($tplIdx);
            $pdf->useTemplate($tplIdx, 0, 0, $size['w'], $size['h']);

            foreach ($documentPage->getDocumentTextFields() as $documentTextField) {
                $txt = mb_convert_encoding($documentTextField->getPrefixSpaceText().$documentTextField->getText(), "UTF-8", "windows-1251");
                $pdf->SetFont('DejaVu', '', $documentTextField->getSize());

                $spaceTextWidth = $pdf->GetStringWidth(mb_convert_encoding($documentTextField->getPrefixSpaceText(), "UTF-8", "windows-1251"));

//                $total_string_width = $pdf->GetStringWidth($txt);
//                $number_of_lines = $total_string_width / ($documentTextField->getWidth() - 1);
//
//                $number_of_lines = ceil($number_of_lines);  // Round it up.

                $number_of_lines_fixed = $pdf->getCurrentWidthFixed($documentTextField->getWidth(), $documentTextField->getHeight(), $txt, 0, $documentTextField->getAlignment(),false,$documentTextField->getLineHeightArray());

                $linesParam = $documentTextField->getLinesParam();
                if(!empty($linesParam)) {
                    if(!empty($linesParam[$number_of_lines_fixed])) {
                        $documentTextField->setHeight($linesParam[$number_of_lines_fixed]);
                        $documentTextField->setNumberOfLines($number_of_lines_fixed);
                    }
                }

                if ($number_of_lines_fixed > $documentTextField->getNumberOfLines()) {
                    if($documentTextField->getSize()>5) {
                        for($i=$documentTextField->getSize()-1;$i>=5;$i--) {
                            $pdf->SetFont('DejaVu', '', $i);
                            $currentSpaceText = $documentTextField->getPrefixSpaceText();

                            $additionalSpaces = "";
                            if($currentSpaceText!="") {
                                while (true) {
                                    $currentSpaceTextWidth = $pdf->GetStringWidth($currentSpaceText);
                                    if ($spaceTextWidth > $currentSpaceTextWidth) {
                                        $currentSpaceText .= " ";
                                        $additionalSpaces .= " ";
                                    } else {
                                        break;
                                    }
                                }
                            }
                            $number_of_lines_fixed = $pdf->getCurrentWidthFixed($documentTextField->getWidth(), $documentTextField->getHeight(), $additionalSpaces.$txt, 0, $documentTextField->getAlignment(),false,$documentTextField->getLineHeightArray());

                            if ($number_of_lines_fixed <= $documentTextField->getNumberOfLines()) {
                                $pdf->SetXY($documentTextField->getCoordinateX(), $documentTextField->getCoordinateY());
                                $pdf->MultiCell($documentTextField->getWidth(), $documentTextField->getHeight(), $additionalSpaces.$txt, 0, $documentTextField->getAlignment(),false,$documentTextField->getLineHeightArray());
                                break;
                            }
                        }
                    }
                } else {
                    $pdf->SetXY($documentTextField->getCoordinateX(), $documentTextField->getCoordinateY());
                    $pdf->MultiCell($documentTextField->getWidth(), $documentTextField->getHeight(), $txt, 0, $documentTextField->getAlignment(),false,$documentTextField->getLineHeightArray());
                }
            }
            foreach ($documentPage->getDocumentPhotoFields() as $documentPhotoField) {
                if($documentPhotoField->getFileName()!="") {
                    $pdf->Image($documentPhotoField->getFileName(), $documentPhotoField->getCoordinateX(), $documentPhotoField->getCoordinateY(), $documentPhotoField->getWidth(), $documentPhotoField->getHeight());
                }
            }

            $pageCounter++;
        }
        if(!empty($downloadFileName)) {
            $downloadFileName = mb_convert_encoding($downloadFileName, "UTF-8", "windows-1251");
            //$downloadFileName = array_pop(explode(DIRECTORY_SEPARATOR, $downloadFileName));
            $pdf->Output("D",$downloadFileName,true);
        } else {
            $pdf->Output();
        }

    }

    public function getWidthWithText($text) {
        $pdf = new tFPDF();
        $txt = mb_convert_encoding($text, "UTF-8", "windows-1251");

        return $pdf->GetStringWidth($txt);
    }


}