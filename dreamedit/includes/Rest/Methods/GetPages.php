<?php

namespace Rest\Methods;

use Rest\Models\Page;

class GetPages implements \RestMethod {

    private $pages;
    private $pagesModule;

    function __construct() {
        $this->pages = array();
        $this->pagesModule = new \Pages();
    }

    function execute($params) {
        if(isset($params['id'])) {
            $page = $this->pagesModule->getPageById($params['id'],1);
            $this->packPage($page);
        }
        if(isset($params['parent_id'])) {
            $this->pages = $this->packChildsPage($params);
        }
        if(isset($params['url'])) {
            $page = $this->pagesModule->getPageByUrl($params['url'],1);
            $this->packPage($page);
        }
        if(isset($params['all']) && isset($params['token']) && $params['token']=='f14FU!(fg71f*') {
            $pages = $this->pagesModule->getPages();
            foreach ($pages as $page) {
                $this->packPage($page);
            }
        }
        return $this->pages;
    }

    private function packPage($page, $child = null) {
        if(!empty($page)) {
            $pageContent = $this->pagesModule->getContentByPageId($page['page_id']);
            $pageEl = new Page(
                iconv("cp1251","UTF-8",$page['page_id']),
                iconv("cp1251","UTF-8",$page['page_parent']),
                iconv("cp1251","UTF-8",$page['page_name']),
                iconv("cp1251","UTF-8",$page['page_urlname']),
                iconv("cp1251","UTF-8",$page['page_template']),
                iconv("cp1251","UTF-8",$pageContent['TITLE']),
                iconv("cp1251","UTF-8",$pageContent['CONTENT']),
                iconv("cp1251","UTF-8",$pageContent['CONTENT_EN']),
                iconv("cp1251","UTF-8",$page['addmenu']),
                iconv("cp1251","UTF-8",$page['page_status']),
                iconv("cp1251","UTF-8",$page['page_status_en']),
                iconv("cp1251","UTF-8",$page['page_position']),
                iconv("cp1251","UTF-8",$page['notshowchilds']),
                iconv("cp1251","UTF-8",$page['addmenucollumn']),
                iconv("cp1251","UTF-8",$page['notshowmenu']),
                iconv("cp1251","UTF-8",$page['page_name_en']),
                $child,
                iconv("cp1251","UTF-8",$page['page_link']),
                iconv("cp1251","UTF-8",$page['page_link_en'])
            );
            $this->pages[] = $pageEl;
        }
    }

    private function packChildsPage($params) {
        $pageChilds = $this->pagesModule->getChilds($params['parent_id'],1);
        $pages = array();
        if(!empty($pageChilds)) {
            $pageChilds = $this->pagesModule->appendContent($pageChilds);
            foreach ($pageChilds as $pageChild) {
                if($params['no_addmenu_elements']==1) {
                    if($pageChild['addmenu']==1) {
                        continue;
                    }
                }

                $childs = array();

                if($params['include_child']==1) {
                    $childs = $this->packChildsPage(array('parent_id' => $pageChild['page_id']));
                    if(empty($childs)) {
                        $childs = null;
                    }
                }

                $this->packPage($pageChild, $childs);
            }
        }
        return $pages;
    }

}