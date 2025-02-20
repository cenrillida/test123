<?php

namespace Rest\Models;

class Page {

    public $id;
    public $parentId;
    public $name;
    public $url;
    public $template;
    public $title;
    public $content;
    public $content_en;
    public $addMenu;
    public $status;
    public $status_en;
    public $position;
    public $notShowChilds;
    public $addmenucollumn;
    public $notshowmenu;
    public $name_en;
    public $child;
    public $page_link;
    public $page_link_en;
    public $expand = false;

    /**
     * @param $id
     * @param $parentId
     * @param $name
     * @param $url
     * @param $template
     * @param $title
     * @param $content
     * @param $content_en
     * @param $addMenu
     * @param $status
     * @param $status_en
     * @param $position
     * @param $notShowChilds
     * @param $addmenucollumn
     * @param $notshowmenu
     * @param $name_en
     * @param $child
     * @param $page_link
     * @param $page_link_en
     */
    public function __construct($id, $parentId, $name, $url, $template, $title, $content, $content_en, $addMenu, $status, $status_en, $position, $notShowChilds, $addmenucollumn, $notshowmenu, $name_en, $child, $page_link, $page_link_en)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->url = $url;
        $this->template = $template;
        $this->title = $title;
        $this->content = $content;
        $this->content_en = $content_en;
        $this->addMenu = $addMenu;
        $this->status = $status;
        $this->status_en = $status_en;
        $this->position = $position;
        $this->notShowChilds = $notShowChilds;
        $this->addmenucollumn = $addmenucollumn;
        $this->notshowmenu = $notshowmenu;
        $this->name_en = $name_en;
        $this->child = $child;
        $this->page_link = $page_link;
        $this->page_link_en = $page_link_en;
    }


}