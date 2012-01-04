{* purpose of this template: tickets view view in user area *}
<div class="knowledgebase-ticket knowledgebase-view">
{include file='user/header.tpl'}
{gt text='Ticket list' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
<div id="kbleftside">
    <h2>{$templateTitle}</h2>


    {checkpermissionblock component='KnowledgeBase::' instance='.*' level="ACCESS_ADD"}
        {gt text='Create ticket' assign='createTitle'}
    {if isset($smarty.get.cat)}
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit' cat=$smarty.get.cat}" title="{$createTitle}" class="z-icon-es-add">
    {else}
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit'}" title="{$createTitle}" class="z-icon-es-add">
    {/if}
            {$createTitle}
        </a>
    {/checkpermissionblock}
{*
    {assign var='all' value=0}
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='KnowledgeBase' type='user' func='view' ot='ticket'}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='KnowledgeBase' type='user' func='view' ot='ticket' all=1}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
    {/if}
*}
<dl>
    {foreach item='ticket' from=$items}
    <dt>
    {checkpermissionblock component='KnowledgeBase::' instance='.*' level='ACCESS_EDIT'}
        {if count($ticket._actions) gt 0}
        {strip}
            {foreach item='option' from=$ticket._actions}
                <a href="{$option.url.type|knowledgebaseActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>
                    {icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}
                </a>
            {/foreach}
        {/strip}
        {/if}
    {/checkpermissionblock}
        <a href="{modurl modname='KnowledgeBase' type='user' func='display' ot='ticket' id=$ticket.id}" title="{gt text="Details of '%s'" tag1=$ticket.subject|replace:"\"":""}">
            {$ticket.subject|notifyfilters:'knowledgebase.filterhook.tickets'}
        </a>
    </dt>
    <dd>{$ticket.content}</dd>
{*    <dd>{gt text='Category'}: {include file='user/include/display_category.tpl'}</dd>*}

    {notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.display_view' urlobject=$currentUrlObject assign='hooks'}
    {*foreach key='hookname' item='hook' from=$hooks}
    {if $hookname eq 'Ratings'}
        {$hook}
    {/if}
    {/foreach*}

    {foreachelse}
    <dt class="z-dataempty">{gt text='No tickets found.'}</dt>
    {/foreach}
</dl>

    {if !isset($showAllEntries) || $showAllEntries ne 1}
        {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}
    {/if}

    <p>
        <a href="{modurl modname='KnowledgeBase' type='user' func='main'}" title="{gt text='Back to category list'}" class="z-icon-es-back">
            {gt text='Back to category list'}
        </a>
    </p>
</div>
<div id="kbrightside">
    {include file='user/include/rightblocks.tpl'}
</div>
<br style="clear: left" />

</div>
</div>
{include file='user/footer.tpl'}

