{* purpose of this template: tickets display view in user area *}

{include file='user/header.tpl'}

{modurl modname='KnowledgeBase' type='user' func='display' ot='ticket' ticketid=$ticket.ticketid assign='returnurl'}
{notifydisplayhooks eventname='knowledgebase.hook.tickets.ui.view' id=$ticket.ticketid assign='hooks'}

<div class="z-frontendcontainer">

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div id="kbleftside">
{/if}
{pagesetvar name='title' value=$ticket.subject}
<h2>{$ticket.subject|notifyfilters:'knowledgebase.filterhook.tickets'}
    {checkpermissionblock component='KnowledgeBase::' instance='.*' level='ACCESS_EDIT'}
        <a href="{$ticket.editurlFormatted}" title="{gt text='Edit'}">
            {icon type='edit' size='extrasmall' __alt='Edit'}
            {gt text='Edit'}
        </a>
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit' ot='ticket' astemplate=$ticket.ticketid}" title="{gt text='Reuse for new item'}">
            {icon type='saveas' size='extrasmall' __alt='Reuse'}
            {gt text='Reuse'}
        </a>
    {/checkpermissionblock}
</h2>

<div class="kbdetblock">
    <h3>{gt text='Solution'}</h3>
    <div>{$ticket.content|nl2br}</div>
</div>

<div class="kbthirdblock">
<dl>
{*    <dt>{gt text='Category'}</dt>
    <dd>{include file='user/include/display_category.tpl'}</dd>*}
    <dt>{gt text='ID of this page'}</dt>
    <dd>{$ticket.ticketid}</dd>
    <dt>{gt text='Created on'}</dt>
    <dd>{$ticket.cr_date|dateformat}</dd>
    <dt>{gt text='Views'}</dt>
    <dd>{$ticket.views}</dd>
</dl>
</div>
<div class="kbthirdblock">
{foreach from=$hooks key='hookname' item='hook'}
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
<p>
    <a href="{modurl modname='KnowledgeBase' type='user' func='view'}" title="{gt text='Back to overview'}">
        {icon type='back' size='extrasmall' __alt='Back'}
        {gt text='Back to overview'}
    </a>
</p>

</div>
<div id="kbrightside">
    {include file='user/include/rightblocks.tpl'}
</div>
<br style="clear: left" />


{foreach from=$hooks key='hookname' item='hook'}
{if $hookname eq 'EZComments'}
    {$hook}
{/if}
{/foreach}

{/if}

</div>

{include file='user/footer.tpl'}

{pageaddvar name='javascript' value='modules/KnowledgeBase/javascript/KnowledgeBase.js'}
<script type="text/javascript">
//<![CDATA[
    var kbTid = '{$ticket.ticketid}';
    document.observe('dom:loaded', onKbTicketDisplay);
//]]>
</script>
