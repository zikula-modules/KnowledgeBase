{* purpose of this template: tickets view view in user area *}

{include file='user/header.tpl'}

<div class="z-frontendcontainer">
<div id="kbleftside">
{gt text='Ticket list' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <h2>{$templateTitle}</h2>

    {checkpermissionblock component='KnowledgeBase::' instance='.*' level="ACCESS_ADD"}
        {gt text='Create ticket' assign='createTitle'}
    {if isset($smarty.get.cat)}
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit' cat=$smarty.get.cat}" title="{$createTitle}">
    {else}
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit'}" title="{$createTitle}">
    {/if}
            {$createTitle}
        </a>
    {/checkpermissionblock}

<dl>
    {foreach item='ticket' from=$items}
    <dt>
    {checkpermissionblock component='KnowledgeBase::' instance='.*' level='ACCESS_EDIT'}
        <a href="{$ticket.editurlFormatted}" title="{gt text='Edit'}">
            {icon type='edit' size='extrasmall' __alt='Edit'}
        </a>
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit' ot='ticket' astemplate=$ticket.ticketid}" title="{gt text='Reuse for new item'}">
            {icon type='saveas' size='extrasmall' __alt='Reuse'}
        </a>
    {/checkpermissionblock}
        <a href="{$ticket.detailurlFormatted}" title="{gt text="Details of '%s'" tag1=$ticket.subjectStripped}">
            {$ticket.subject|notifyfilters:'knowledgebase.filterhook.tickets'}
        </a>
    </dt>
    <dd>{$ticket.content}</dd>
{*    <dd>{gt text='Category'}: {include file='user/include/display_category.tpl'}</dd>*}

    {modurl modname='KnowledgeBase' func='view' ot='ticket' pos=$currentPage assign='returnurl'}
    {*modcallhooks hookobject='category' hookaction='display' module='KnowledgeBaseticket' returnurl=$returnurl*}
    {*notifydisplayhooks eventname='knowledgebase.hook.tickets.ui.view' assign='hooks'}
    {foreach from=$hooks key='hookname' item='hook'}
    {if $hookname eq 'Ratings'}
        {$hook}
    {/if}
    {/foreach*}

    {foreachelse}
    <dt class="z-dataempty">{gt text='No tickets found.'}</dt>
    {/foreach}
</dl>

    {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}

    <p>
        <a href="{modurl modname='KnowledgeBase' type='user' func='main'}" title="{gt text='Back to category list'}">
            {img src='agt_back.png' modname='core' set='icons/extrasmall' __alt='Back' __title='Back to category list'}
            {gt text='Back to category list'}
        </a>
    </p>
</div>
<div id="kbrightside">
    {include file='user/include/rightblocks.tpl'}
</div>
<br style="clear: left" />

</div>

{include file='user/footer.tpl'}
