<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\Applicant;
use Contest\Models\OnlineVoteResult;
use Contest\Models\User;
use Contest\PageBuilders\PageBuilder;

class ZipUsersResultLists implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ZipUsersResultLists constructor.
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

                        $zip = new \ZipArchive();

                        $file = tempnam(sys_get_temp_dir(), "zip");

                        if ($zip->open($file, \ZipArchive::OVERWRITE)!==TRUE) {
                            exit("Невозможно открыть\n");
                        }

                        foreach ($contestGroup->getParticipants() as $user) {
                            $_GET['user_id']=$user->getId();

                            ob_start();

                            $this->contest->getPageBuilderManager()->setPageBuilder("userResultList");
                            $this->contest->getPageBuilder()->build(array('not_download' => true));

                            $html = ob_get_clean();

                            $firstname = "";
                            if ($user->getFirstName() != "") {
                                $firstname = substr($user->getFirstName(), 0, 1) . ".";
                            }
                            $thirdname = "";
                            if ($user->getThirdName() != "") {
                                $thirdname = substr($user->getThirdName(), 0, 1) . ".";
                            }
                            $fullname = $user->getLastName() . " " . $firstname . $thirdname;

                            $filename = \Dreamedit::encodeText("{$fullname} - Рейтинговый лист.docx");

                            $zip->addFromString($filename,$html);
                        }

                        $zip->close();

                        $filename = \Dreamedit::encodeText("{$contest->getPosition()} - Рейтинговые листы.zip");

                        header("Content-Description: File Transfer");
                        header('Content-Disposition: attachment; filename="' . $filename . '"');
                        header('Content-Type: application/zip');
                        header('Content-Transfer-Encoding: binary');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Expires: 0');

                        @readfile($file);
                        unlink($file);

                        exit();
                    } else {
                        $this->contest->getPageBuilderManager()->setPageBuilder("error");
                        $this->contest->getPageBuilder()->build(array("error" => "Данный конкурс с открытым голосованием"));
                    }
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