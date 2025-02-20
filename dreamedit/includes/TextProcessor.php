<?php

class TextProcessor
{
    public static function processAllBuilders($html) {
        $htmlSaved = $html;

        $html = AccordionBuilder::buildAllAccordions($html);
        $html = CollapsedBuilder::buildAllCollapsed($html);
        $html = ComboboxBuilder::buildAllCombobox($html);

        if($html != $htmlSaved) {
            $html = self::processAllBuilders($html);
        }

        return $html;
    }
}