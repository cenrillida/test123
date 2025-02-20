<?php

interface DhtmlxHeaderField {
    /**
     * @return string
     */
    public function getContent();
}

class DhtmlxContent implements DhtmlxHeaderField {

    /** @var string */
    private $content;

    /**
     * DhtmlxContent constructor.
     * @param string $content
     */
    public function __construct($content) {
        $this->content=$content;
    }

    /**
     * @return string
     */
    public function getContent() {
        return "{content: \"".$this->content."\"}";
    }

}

class DhtmlxText implements DhtmlxHeaderField {

    /** @var string */
    private $content;
    /** @var string */
    private $colspan;
    /** @var string */
    private $rowspan;
    /** @var string */
    private $align;

    /**
     * DhtmlxText constructor.
     * @param string $content
     * @param string $colspan
     * @param string $rowspan
     * @param string $align
     */
    public function __construct($content, $colspan = "", $rowspan = "", $align = "")
    {
        $this->content = $content;
        $this->colspan = $colspan;
        $this->rowspan = $rowspan;
        $this->align = $align;
    }

    /**
     * @return string
     */
    public function getContent() {
        $colspan = "";
        if(!empty($this->colspan)) {
            $colspan = ", colspan: ".$this->colspan;
        }
        $rowspan = "";
        if(!empty($this->rowspan)) {
            $rowspan = ", rowspan: ".$this->rowspan;
        }
        $align = "";
        if(!empty($this->align)) {
            $align = ", align: \"".$this->align."\"";
        }
        return "{text: \"".$this->content."\"".$colspan.$rowspan.$align."}";
    }

}

class DhtmlxHeader {

    /** @var DhtmlxHeaderField[] */
    private $dhtmlxHeaderFields;

    public function __construct() {
        $this->dhtmlxHeaderFields = array();
    }

    /** @var DhtmlxHeaderField */
    public function registerField($dthmlxHeaderField) {
        $this->dhtmlxHeaderFields[] = $dthmlxHeaderField;
    }
    /**
     * @return string
     */
    public function getContent() {
        $first = true;
        $finalString = "";
        foreach ($this->dhtmlxHeaderFields as $dhtmlxHeaderField) {
            if($first) {
                $first = false;
            } else {
                $finalString.=", ";
            }
            $finalString.=$dhtmlxHeaderField->getContent();
        }
        return $finalString;
    }

}

class DhtmlxColumn {

    /** @var int */
    private $width;
    /** @var string */
    private $id;
    /** @var DhtmlxHeader */
    private $header;
    /** @var string */
    private $lineHeight;
    /** @var string */
    private $textAlign;
    /** @var string */
    private $type;
    /** @var string */
    private $icon;
    /** @var string */
    private $dateFormat;
    /** @var bool */
    private $editing;

    /**
     * DhtmlxColumn constructor.
     * @param int $width
     * @param string $id
     * @param DhtmlxHeader $header
     * @param string $lineHeight
     * @param string $textAlign
     * @param string $type
     * @param string $icon
     * @param string $dateFormat
     * @param bool $editing
     */
    public function __construct($width, $id, DhtmlxHeader $header, $lineHeight ="", $textAlign="", $type = "", $icon = "", $dateFormat = "", $editing = false)
    {
        $this->width = $width;
        $this->id = $id;
        $this->header = $header;
        $this->lineHeight = $lineHeight;
        $this->textAlign = $textAlign;
        $this->type = $type;
        $this->icon = $icon;
        $this->dateFormat = $dateFormat;
        $this->editing = $editing;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DhtmlxHeader
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @return bool
     */
    public function isEditing()
    {
        return $this->editing;
    }

    /**
     * @return string
     */
    public function getLineHeight()
    {
        return $this->lineHeight;
    }

    /**
     * @return string
     */
    public function getTextAlign()
    {
        return $this->textAlign;
    }

}

class DhtmlxBuilder {

    /** @var string */
    private $source;
    /** @var string */
    private $update;
    /** @var DhtmlxColumn[] */
    private $columns;
    /** @var string */
    private $deleteText;

    /**
     * DhtmlxBuilder constructor.
     * @param string $source
     * @param string $update
     * @param string $deleteText
     */
    public function __construct($source, $update, $deleteText = "Вы действительно хотите удалить статью?")
    {
        $this->source = $source;
        $this->update = $update;
        $this->deleteText = $deleteText;
        $this->columns = array();
    }

    private function echoStyles() {
        $counter = 1;
        foreach ($this->columns as $column) {
            if($column->getLineHeight()!=""):
            ?>
            .dhx_grid-row .dhx_grid-cell:nth-child(<?=$counter?>) {
                    line-height: <?=$column->getLineHeight()?>px !important;
                }
            <?php
            endif;
            if($column->getTextAlign()!=""):
            ?>
            .dhx_grid-row .dhx_grid-cell:nth-child(<?=$counter?>) {
                    text-align: <?=$column->getTextAlign()?> !important;
                }
            <?php
            endif;
            $counter++;
        }
    }

    private function echoColumns() {
        $first = true;
        foreach ($this->columns as $column):
        if($first) {
                $first = false;
            } else {
                echo  ", ";
            }
        $width = "";
        if($column->getWidth()!="") {
            $width = "width: ".$column->getWidth().", ";
        }
        ?>
        {<?=$width?>id: "<?=$column->getId()?>", header: [<?=$column->getHeader()->getContent()?>]
        <?php if($column->getType()!="") echo ", type: \"".$column->getType()."\""?>
        <?php if($column->getDateFormat()!="") echo ", dateFormat: \"".$column->getDateFormat()."\""?>
        <?php if($column->isEditing()) echo ", editing: true"?>
        <?php if($column->getIcon()!="") echo ", icon: \"".$column->getIcon()."\""?>
        }
        <?php
        endforeach;
    }

    /**
     * @param DhtmlxColumn $column
     */
    public function registerColumn($column) {
        $this->columns[] = $column;
    }

    public function build() {
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <script type="text/javascript" src="/js/dhtmlx7/codebase/suite.js?v=7"></script>
            <script src="/newsite/js/jquery-3.3.1.min.js"></script>
            <link rel="stylesheet" href="/js/dhtmlx7/codebase/suite.css">
            <style>
                html, body {
                    width: 100%;
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    background-color: #ebebeb;
                    overflow: hidden;
                }

                #grid_container {
                    height: 100%;
                }

                .del-button, .cell-button {
                    text-align: center;
                    margin-top: 5px;
                }

                .cell-button a {
                    color: #8d8d8d;
                    font-size: 14px;
                }

                .del-button a {
                    color: red;
                    font-size: 14px;
                }

                .dhx_grid-cell {
                    font-size: 12px;
                }

                <?php
                $this->echoStyles()
                ?>

                .popup-content {
                    display: none;
                }
            </style>
        </head>
        <body>
        <div id="grid_container"></div>
        <script>
            // creating dhtmlxGrid

            var grid = new dhx.Grid("grid_container", {
                header: [{text: "Удал."}],
                columns: [
                    <?php
                    $this->echoColumns();
                    ?>
                ],
                headerRowHeight: 50,
                autoWidth: true,
                resizable: true,
                htmlEnable: true
            });
            grid.data.load("<?=$this->source?>");

            var popup = new dhx.Popup({
                css: "dhx_widget--border-shadow",
                width: 400
            });

            function resizeFunc() {
                grid.config.width = 0;
                grid.config.height = 0;
                grid.paint();
            }

            grid.events.on("AfterEditEnd", function (value, row, column) {
                $.ajax({

                    url: "<?=$this->update?>",
                    //dataType: "json",
                    method: "POST",
                    data: {"value": value, "id": row.id, "column": column.id},
                    success: function (data) {
                    }
                });
            });

            function deleteLogin(id) {
                var answer = confirm("<?=$this->deleteText?>");

                if (answer) {
                    $.ajax({

                        url: "<?=$this->update?>",
                        //dataType: "json",
                        method: "POST",
                        data: {"delete": id},
                        success: function (data) {
                            grid.data.removeAll();
                            grid.data.load("<?=$this->source?>");
                        }
                    });
                }

            }

            function deleteLoginGet(id) {
                var answer = confirm("<?=$this->deleteText?>");

                if (answer) {
                    $.ajax({

                        url: "<?=$this->update?>&delete="+id,
                        //dataType: "json",
                        method: "POST",
                        data: {"delete": id},
                        success: function (data) {
                            grid.data.removeAll();
                            grid.data.load("<?=$this->source?>");
                        }
                    });
                }

            }

            function doFilter(data) {
                if (data == "all") {
                    grid.data.load("<?=$this->source?>");
                }
                if (data == "rez") {
                    grid.data.load("<?=$this->source?>?rez=1");
                }
                if (data == "publ") {
                    grid.data.load("<?=$this->source?>?publ=1");
                }
            }

            window.onresize = resizeFunc;



            popup.attachHTML("<div style='padding: 16px; text-align: center'>Test</div>");

            function openComment(el) {
                event.preventDefault();
                //el.parent().find('.popup-content')[0].innerHTML
                popup.hide();
                popup.attachHTML("<div style='padding: 16px; width: 400px;'>" + el.parent().find('.popup-content')[0].innerHTML + "</div>");
                popup.show(el[0]);
            }

            $(window).scroll(function () {
                popup.hide();
            });

            grid.events.on("Scroll", function({top,left}){
                popup.hide();
            });

        </script>
        </body>
        </html>
        <?php
    }
}