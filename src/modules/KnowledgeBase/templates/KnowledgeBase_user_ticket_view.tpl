{* purpose of this template: view template for user area *}

{include file="KnowledgeBase_user_header.tpl"}

<div class="z-frontendcontainer">

<div id="kbleftside">
{gt text='Ticket list' assign="templateTitle"}
{pagesetvar name="title" value=$templateTitle}
<h2>{$templateTitle}</h2>

{securityutil_checkpermission_block component="KnowledgeBase::" instance=".*" level="ACCESS_ADD"}
{gt text='Create ticket' assign="createTitle"}
<p>
{if isset($smarty.get.cat)}
    <a href="{modurl modname="KnowledgeBase" type="user" func="edit" cat=$smarty.get.cat}" title="{$createTitle}">
{else}
    <a href="{modurl modname="KnowledgeBase" type="user" func="edit"}" title="{$createTitle}">
{/if}
        {img src="insert_table_row.gif" modname="core" set="icons/extrasmall" __alt='Create'}
        {$createTitle}
    </a>
</p>
{/securityutil_checkpermission_block}

<dl>
{foreach from=$objectArray item="ticket"}
    <dt>
    {securityutil_checkpermission_block component="KnowledgeBase::" instance=".*" level="ACCESS_EDIT"}
        <a href="{$ticket.editurlFormatted}">
            {img src="xedit.gif" modname="core" set="icons/extrasmall" __alt='Edit' __title='Edit'}
        </a>
    {/securityutil_checkpermission_block}
        <a href="{$ticket.detailurlFormatted}" title="{gt text="Details of '%s'" tag1=$ticket.subjectStripped}">
            {$ticket.subject|modcallhooks}
        </a>
    </dt>
    <dd>{$ticket.content}</dd>
{*    <dd>{gt text='Category'}: {include file="KnowledgeBase_include_display_category.tpl"}</dd>*}

{*    {modurl modname="KnowledgeBase" type="user" func="display" id=$ticket.ticketid assign="returnurl"}
{modcallhooks hookobject="item" hookaction="display" module="KnowledgeBase" hookid="ticket`$ticket.ticketid`" returnurl=$returnurl implode=false}
    <dd>{$hooks.Ratings}</dd>*}

{foreachelse}
    <dt>{gt text='No tickets found.'}</dt>
{/foreach}
</dl>

{pager rowcount=$pager.numitems limit=$pager.itemsperpage}

<p>
    <a href="{modurl modname="KnowledgeBase" type="user" func="main"}" title="{gt text='Back to category list'}">
        {img src="agt_back.gif" modname="core" set="icons/extrasmall" __alt='Back' __title='Back to category list'}
        {gt text='Back to category list'}
    </a>
</p>

{modurl modname="KnowledgeBase" func="view" startnum=$startnum assign="returnurl"}
{* modcallhooks hookobject="category" hookaction="display" module="KnowledgeBaseticket" returnurl=$returnurl *}
</div>
<div id="kbrightside">
    {include file="KnowledgeBase_include_rightblocks.tpl"}
</div>
<br style="clear: left" />

</div>

{include file="KnowledgeBase_user_footer.tpl"}
