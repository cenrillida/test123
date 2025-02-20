<?php

class AspDocumentService {

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @param AspModuleUser $user
     * @param string $content
     */
    private function getFileNameWithContent($user, $content) {
        return $user->getLastName()."_".substr($user->getFirstName(),0,1).".".substr($user->getThirdName(),0,1)."._".$content;
    }

    /**
     * @param AspModuleUser $user
     */
    public function getDocument($document, $id="", $user = null) {
        if(!empty($user)) {
            if(!$this->aspModule->getAspStatusManager()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                echo "������ �������";
                exit;
            }
        } else {
            $user = $this->aspModule->getCurrentUser();
        }
        switch ($document) {
            case "getApplyForEntry":
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"���������_�_��������_��_����������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfApplyForEntry(),$txt);
                break;
            case "getApplication";
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"���������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfApplication(),$txt);
                break;
            case "getPersonalDocument":
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"��������_��������������_��������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfPersonalDocument(),$txt);
                break;
            case "getEducation":
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"��������_��_�����������_�_�_������������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfEducation(),$txt);
                break;
            case "getAutobiography":
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"�������������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfAutoBiography(),$txt);
                break;
            case "getPersonalSheet":
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"������_������_��_�����_������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfPersonalSheet(),$txt);
                break;
            case "getIndividualAchievements":
                if(!empty($id)) {
                    $individualAchievements = $user->getPdfIndividualAchievements();
                    $individualAchievements = array_values($individualAchievements);
                    if(!empty($individualAchievements[$id-1]['pdf_individual_achievement'])) {
                        $txt = mb_convert_encoding($this->getFileNameWithContent($user,"��������������_����������_".$id.".pdf"), "UTF-8", "windows-1251");
                        $this->aspModule->getAspDownloadService()->getPdf($individualAchievements[$id-1]['pdf_individual_achievement'],$txt);
                    } else {
                        echo "������ �������";
                    }
                } else {
                    echo "������ �������";
                    exit;
                }
                break;
            case "getDisabledInfo":
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"��������_��������������_������������.pdf"), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getPdf($user->getPdfDisabledInfo(),$txt);
                break;
            case "getPhoto":
                $file_extension = strtolower(substr(strrchr($user->getPhoto(),"."),1));

                switch( $file_extension ) {
                    case "gif": $ctype="image/gif"; break;
                    case "png": $ctype="image/png"; break;
                    case "jpeg":
                    case "jpg": $ctype="image/jpeg"; break;
                    case "svg": $ctype="image/svg+xml"; break;
                    default:
                        $ctype = "";
                }
                $txt = mb_convert_encoding($this->getFileNameWithContent($user,"����������.".$file_extension), "UTF-8", "windows-1251");
                $this->aspModule->getAspDownloadService()->getAspPhoto($user->getPhoto(),$txt);
                break;
            default:
                echo "������ �������";
                exit;
        }

    }

}