<?php

class KnowledgeBase_Form_Plugin_Frame extends Form_Plugin
{
    var $useTabs;
    var $cssClass = 'tabs';

    // Plugins MUST implement this function as it is stated here.
    // The information is used to re-establish the plugins on postback.
    function getFilename()
    {
        return __FILE__;
    }

    function create(&$render, &$params)
    {
        $this->useTabs = (array_key_exists('useTabs', $params) ? $params['useTabs'] : false);
    }


    // This is called by the framework before the content of the block is rendered
    function renderBegin(&$render)
    {
        $tabClass = $this->useTabs ? ' '.$this->cssClass : '';
        return "<div class=\"knowledgebaseForm{$tabClass}\">\n";
    }

    // This is called by the framework after the content of the block is rendered
    function renderEnd(&$render)
    {
        return "</div>\n";
    }
}
