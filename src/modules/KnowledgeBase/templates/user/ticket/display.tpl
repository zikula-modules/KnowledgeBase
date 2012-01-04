{* purpose of this template: tickets display view in user area *}
{include file='user/header.tpl'}
<div class="knowledgebase-ticket knowledgebase-display">
{gt text='Ticket' assign='templateTitle'}
{assign var='templateTitle' value=$ticket.subject|default:$templateTitle}
{pagesetvar name='title' value=$templateTitle|@html_entity_decode}
<div class="z-frontendcontainer">
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div id="kbleftside">
{/if}
    <h2>{$templateTitle|notifyfilters:'knowledgebase.filter_hooks.tickets.filter'}</h2>
    <div class="kbdetblock">
        <h3>{gt text='Solution'}</h3>
        <div>{$ticket.content|nl2br}</div>
    </div>
    <div class="kbthirdblock">
        <dl>
      {*    <dt>{gt text='Category'}</dt>
            <dd>{include file='user/include/display_category.tpl'}</dd>*}
            <dt>{gt text='ID of this page'}</dt>
            <dd>{$ticket.id}</dd>
            <dt>{gt text='Created on'}</dt>
            <dd>{$ticket.createdDate|dateformat}</dd>
            <dt>{gt text='Views'}</dt>
            <dd>{$ticket.views}</dd>
        </dl>
    </div>
{notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.display_view' id=$ticket.id urlobject=$currentUrlObject assign='hooks'}
    <div class="kbthirdblock">
        {foreach key='hookname' item='hook' from=$hooks}
        {if $hookname eq 'Ratings'}
            {$hook}
        {/if}
        {/foreach}
    </div>
    <div class="kbthirdblock" id="kbhotornot" style="display: none">
        <h3>{gt text='Hot or not'}</h3>
        <p><span id="amountlikes">{$ticket.ratesUp|default:'0'}</span> {gt text='likes'}, <span id="amountdislikes">{$ticket.ratesDown|default:'0'}</span> {gt text='dislikes'}</p>
        <p><a href="" id="linklikeit">{img modname='core' set='icons/extrasmall' src='1uparrow.png' __alt='Like it'} {gt text='This answer was helpful'}</a><br /><a href="" id="linkdislikeit">{img modname='core' set='icons/extrasmall' src='1downarrow.png' __alt='Dislike it'} {gt text='This answer was not helpful'}</a></p>
    </div>
    <br style="clear: left" />

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
{if count($ticket._actions) gt 0}
    <p>{strip}
    {foreach item='option' from=$ticket._actions}
        <a href="{$option.url.type|knowledgebaseActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
            {$option.linkText|safetext}
        </a>
    {/foreach}
    {/strip}</p>
{/if}
</div>
<div id="kbrightside">
    {include file='user/include/rightblocks.tpl'}
</div>
<br style="clear: left" />

{foreach key='hookname' item='hook' from=$hooks}
{if $hookname eq 'EZComments'}
    {$hook}
{/if}
{/foreach}

{/if}

</div>
</div>

{include file='user/footer.tpl'}

{pageaddvar name='javascript' value='modules/KnowledgeBase/javascript/KnowledgeBase.js'}
<script type="text/javascript">
//<![CDATA[
    var kbTid = '{$ticket.id}';
    document.observe('dom:loaded', onKbTicketDisplay);
//]]>
</script>
