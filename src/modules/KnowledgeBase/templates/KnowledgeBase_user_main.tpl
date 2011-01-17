{* purpose of this template: main template for user area *}

{include file="KnowledgeBase_user_header.tpl"}

<div class="z-frontendcontainer">
<div id="kbleftside">
{gt text='Knowledgebase categories' assign="templateTitle"}
{pagesetvar name="title" value=$templateTitle}
<h2>{$templateTitle}</h2>

{securityutil_checkpermission_block component="KnowledgeBase::" instance=".*" level="ACCESS_ADD"}
{gt text='Create ticket' assign="createTitle"}
<p>
    <a href="{modurl modname="KnowledgeBase" type="user" func="edit"}" title="{$createTitle}">
        {img src="insert_table_row.gif" modname="core" set="icons/extrasmall" __alt='Create'}
        {$createTitle}
    </a>
</p>
{/securityutil_checkpermission_block}

{foreach from=$categories item="category"}
    <div class="catblock">
        <h3><a href="{$category.viewurlFormatted}" title="{gt text="See all topics in '%s'" tag1=$category.nameStripped}">{include file="KnowledgeBase_include_display_category_name.tpl"}</a> ({$category.ticketcount})</h3>
        {if $category.ticketcount gt 0}
            <ul>
            {foreach name="catTicketLoop" item="ticket" from=$category.tickets}
            {if $smarty.foreach.catTicketLoop.iteration lt 3}{* display only the first 2 *}
                <li><a href="{$ticket.detailurlFormatted}" title="{gt text="Details of '%s'" tag1=$ticket.subjectStripped}">{$ticket.subject}</a></li>
            {/if}
            {/foreach}
            </ul>
            {if $category.ticketcount gt 2}
                <p><a href="{$category.viewurlFormatted}" title="{gt text="See all topics in '%s'" tag1=$category.nameStripped}">{gt text="more topics"}</a></p>
            {/if}
        {else}
            <p>{gt text='No topics yet.'}</p>
        {/if}
    </div>
{/foreach}
    <br style="clear: left" />
    {include file="KnowledgeBase_include_centerblocks.tpl"}
</div>
<div id="kbrightside">
    {include file="KnowledgeBase_include_rightblocks.tpl"}
</div>
<br style="clear: left" />

{modurl modname="KnowledgeBase" func="main" assign="returnurl"}
{* modcallhooks hookobject="category" hookaction="display" module="KnowledgeBaseticket" returnurl=$returnurl *}

</div>

{include file="KnowledgeBase_user_footer.tpl"}
