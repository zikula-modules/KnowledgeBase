{* purpose of this template: main template for user area *}
{include file='user/header.tpl'}

<div class="z-frontendcontainer">
<div id="kbleftside">
    {gt text='Knowledgebase categories' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <h2>{$templateTitle}</h2>

    {checkpermissionblock component='KnowledgeBase::' instance='.*' level="ACCESS_ADD"}
        {gt text='Create ticket' assign='createTitle'}
        <a href="{modurl modname='KnowledgeBase' type='user' func='edit' ot='ticket'}" title="{$createTitle}" class="z-icon-es-add">
            {$createTitle}
        </a>
    {/checkpermissionblock}

{foreach item='category' from=$categories}
    <div class="catblock">
        <h3><a href="{$category.viewurlFormatted}" title="{gt text="See all topics in '%s'" tag1=$category.nameStripped}">{include file='user/include/display_category_name.tpl'}</a> ({$category.ticketcount})</h3>
        {if $category.ticketcount gt 0}
            <ul>
            {foreach name='catTicketLoop' item='ticket' from=$category.tickets}
            {if $smarty.foreach.catTicketLoop.iteration lt 3}{* display only the first 2 *}
                <li><a href="{$ticket.detailurlFormatted}" title="{gt text="Details of '%s'" tag1=$ticket.subjectStripped}">{$ticket.subject}</a></li>
            {/if}
            {/foreach}
            </ul>
            {if $category.ticketcount gt 2}
                <p><a href="{$category.viewurlFormatted}" title="{gt text="See all topics in '%s'" tag1=$category.nameStripped}">{gt text='more topics'}</a></p>
            {/if}
        {else}
            <p>{gt text='No topics yet.'}</p>
        {/if}
    </div>
{/foreach}
    <br style="clear: left" />
    {include file='user/include/centerblocks.tpl'}
</div>
<div id="kbrightside">
    {include file='user/include/rightblocks.tpl'}
</div>
<br style="clear: left" />

    {modurl modname='KnowledgeBase' func='main' assign='returnurl'}
    {notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.display_view' assign='hooks'}
    {foreach key='hookname' item='hook' from=$hooks}
        {$hook}
    {/foreach}
</div>
{include file='user/footer.tpl'}
