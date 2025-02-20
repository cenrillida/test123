<?php
class xml_output{
	public $xw=null;

    public function __construct(){
		$this->xw = new XMLWriter();
		$this->xw->openURI('php://output');
		$this->xw->setIndent(true);
	}

    function startXML(){
        $this->xw->startDocument('1.0', 'utf-8');
    }

    function endXML(){
        $this->xw->endDocument();
        $this->xw->flush();
    }

    function element($tag, $attrs=null, $content=null){
        $this->elementStart($tag, $attrs);
        if (!is_null($content)){
            $this->xw->text($content);
        }
        $this->elementEnd($tag);
    }

    function elementStart($tag, $attrs=null){
        $this->xw->startElement($tag);
        if (is_array($attrs)){
            foreach ($attrs as $name=>$value){
                $this->xw->writeAttribute($name, $value);
            }
        } elseif(is_string($attrs)){
            $this->xw->writeAttribute('class', $attrs);
        }
    }

    function elementEnd($tag){
        static $empty_tag = array('base', 'meta', 'link', 'hr', 'br', 'param', 'img', 'area', 'input', 'col');
        if (in_array($tag, $empty_tag)) {
            $this->xw->endElement();
        } else {
            $this->xw->fullEndElement();
        }
    }

    function text($txt){
        $this->xw->text($txt);
    }

    function raw($xml){
        $this->xw->writeRaw($xml);
    }

    function comment($txt){
        $this->xw->writeComment($txt);
    }

}
?>