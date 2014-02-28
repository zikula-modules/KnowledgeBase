{* purpose of this template: footer for user area *}
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
    <p class="text-center">
        Powered by <a href="http://modulestudio.de" title="Get the MOST out of Zikula!">ModuleStudio 0.6.1</a>
    </p>
{elseif isset($smarty.get.func) && $smarty.get.func eq 'edit'}
    {pageaddvar name='stylesheet' value='style/core.css'}
    {pageaddvar name='stylesheet' value='modules/Resources/public/css//style.css'}
    {pageaddvar name='stylesheet' value='system/Zikula/Module/ThemeModule/Resources/public/css/form/style.css'}
    {pageaddvar name='stylesheet' value='themes/Zikula/Theme/Andreas08Theme/Resources/public/css/fluid960gs/reset.css'}
    {capture assign='pageStyles'}
    <style type="text/css">
        body {
            font-size: 70%;
        }
    </style>
    {/capture}
    {pageaddvar name='header' value=$pageStyles}
{/if}
