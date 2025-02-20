<?php

class CollapsedBuilder
{
    private $id;
    private $elements;

    /**
     * @param $id
     * @param $elements
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $html = "";
        $pg = new Pages();

        $collapsedConfig = $pg->getContentByPageId($this->id);

        $collapsedElements = $pg->getChilds($this->id, null, null, null, null, 'collapsed_element');
        $collapsedElements = $pg->appendContent($collapsedElements);

        foreach ($collapsedElements as $collapsedElement) {
            $defaultOpened = '';
            if($collapsedElement['content']['OPENED_BY_DEFAULT']) {
                $defaultOpened = ' show';
            }
            $html .= "
            <div class=\"mb-2\">";

            if($collapsedConfig['A_HREF_STYLE']) {
                $html .= "
                <a data-toggle=\"collapse\" href=\"#collapse{$collapsedElement['page_id']}\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapse{$collapsedElement['page_id']}\">
                {$collapsedElement['content']['TITLE']}
                </a>
                ";
            } else {
                $html .= "
					<p><button aria-controls=\"collapse{$collapsedElement['page_id']}\" aria-expanded=\"false\" class=\"btn btn-light btn-faq collapsed\" data-target=\"#collapse{$collapsedElement['page_id']}\" data-toggle=\"collapse\" type=\"button\">
					{$collapsedElement['content']['TITLE']}
					</button></p>";
            }

            $html .= "
                <div>
                    <div class=\"collapse{$defaultOpened}\" id=\"collapse{$collapsedElement['page_id']}\">
                        <div class=\"card card-body\">
					    {$collapsedElement['content']['CONTENT']}
                        </div>
                    </div>
                </div>
            </div>
            ";
        }

        return $html;
    }

    public static function buildAllCollapsed($html)
    {
        $pg = new Pages();

        preg_match_all("/\[COLLAPSED_LIST_(\d+)\]/i",$html,$collapsed);

        foreach ($collapsed[1] as $collapsedElement) {
            $collapsedPage = $pg->getPageById($collapsedElement);
            if($collapsedPage['page_template']=='collapsed') {
                $collapsedBuilder = new self($collapsedElement);
                $html = str_replace("[COLLAPSED_LIST_{$collapsedElement}]", $collapsedBuilder->build(), $html);
            } else {
                $html = str_replace("[COLLAPSED_LIST_{$collapsedElement}]", '', $html);
            }
        }

        return $html;
    }

}