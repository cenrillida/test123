<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class GetSign implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * GetSign constructor.
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
        if($this->contest->getAuthorizationService()->isAuthorized()) {
            if(!empty($_GET['user_id'])) {
                if($this->contest->getAuthorizationService()->getCurrentUser()->getStatus()->isAdmin()) {
                    $user = $this->contest->getUserService()->getUserById($_GET['user_id']);
                    if(!empty($user)) {
                        $this->contest->getDownloadService()->getSign($user->getSign());
                    } else {
                        $this->contest->getPageBuilderManager()->setPageBuilder("error");
                        $this->contest->getPageBuilder()->build();
                    }
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build();
                }
            } else {
                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                $this->contest->getPageBuilder()->build();
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }
    }

}