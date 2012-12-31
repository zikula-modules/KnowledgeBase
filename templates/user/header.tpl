{* purpose of this template: header for user area *}

{pageaddvar name='javascript' value='prototype'}
{pageaddvar name='javascript' value='validation'}
{pageaddvar name='javascript' value='zikula'}
{pageaddvar name='javascript' value='livepipe'}
{pageaddvar name='javascript' value='zikula.ui'}
{pageaddvar name='javascript' value='zikula.imageviewer'}
{pageaddvar name='javascript' value='modules/KnowledgeBase/javascript/KnowledgeBase.js'}

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div class="z-frontendbox">
    <h1>{gt text='Knowledge base' comment='This is the title of the header template'}</h1>
    {*modulelinks modname='KnowledgeBase' type='user'*}
    <div class="z-menu">
        [&nbsp;{kbbreadcrumb}&nbsp;]
    </div>
</div>
{/if}
{insert name='getstatusmsg'}
