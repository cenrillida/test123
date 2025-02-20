<?php

class ComboboxBuilder
{
    private $id;

    /**
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $html = "<div class=\"ui-widget auto-combobox{$this->id}\">
    <select class=\"form-control\" id=\"combobox{$this->id}\" style=\"display: none\"><option value=\"\"></option>";
        $pg = new Pages();

        $comboboxConfig = $pg->getContentByPageId($this->id);

        $comboboxElements = $pg->getChilds($this->id, null, null, null, null, 'combobox_element');
        $comboboxElements = $pg->appendContent($comboboxElements);

        foreach ($comboboxElements as $comboboxElement) {
            $html .= "<option value=\"{$comboboxElement['content']['URL']}\">{$comboboxElement['content']['TITLE']}</option>";
        }
        $html .= '</select></div>';
        $html .= "
        <script>
        jQuery( document ).ready(function() {
            $( \"#combobox{$this->id}\" ).combobox();
            $(\".auto-combobox{$this->id}\").find( \".custom-combobox-input\" ).on( \"autocompleteselect\", function( event, ui ) {
                document.location.href = ui.item.option.value;
            } );
            $('.auto-combobox{$this->id}').find('input').attr('placeholder', '{$comboboxConfig['PLACEHOLDER']}');
            });
        </script>
        <style type=\"text/css\">";
        if($comboboxConfig['PLACEHOLDER_ITALIC']) {
            $html .= "
                .auto-combobox{$this->id} input::placeholder {
                    font-style: italic;
                }";
        }
        $html .= "
            .ui-widget, .ui-widget input, .ui-menu-item {
                font-family: 'PT Sans', sans-serif;
                font-size: 1em;
            }
        </style>
    ";

        return $html;
    }

    public static function buildAllCombobox($html)
    {
        $pg = new Pages();

        preg_match_all("/\[COMBOBOX_LIST_(\d+)\]/i",$html,$combobox);

        foreach ($combobox[1] as $comboboxElement) {
            $comboboxPage = $pg->getPageById($comboboxElement);
            if($comboboxPage['page_template']=='combobox') {
                $comboboxBuilder = new self($comboboxElement);
                $html = str_replace("[COMBOBOX_LIST_{$comboboxElement}]", $comboboxBuilder->build(), $html);
            } else {
                $html = str_replace("[COMBOBOX_LIST_{$comboboxElement}]", '', $html);
            }
        }

        return $html;
    }

}