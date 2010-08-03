{* purpose of this template: display template for user area *}

{include file="KnowledgeBase_user_header.tpl"}

{modurl modname="KnowledgeBase" type="user" func="display" id=$ticket.ticketid assign="returnurl"}
{modcallhooks hookobject="item" hookaction="display" module="KnowledgeBase" hookid="ticket`$ticket.ticketid`" returnurl=$returnurl implode=false}

<div class="z-frontendcontainer">

<div id="kbleftside">
{pagesetvar name="title" value=$ticket.subject}
<h2>{$ticket.subject|modcallhooks}
{securityutil_checkpermission_block component="KnowledgeBase::" instance=".*" level="ACCESS_EDIT"}
    <a href="{$ticket.editurlFormatted}" title="{gt text='Edit'}">
        {img src="xedit.gif" modname="core" set="icons/extrasmall" __alt='Edit' __title='Edit'}
    </a>
{/securityutil_checkpermission_block}
</h2>

<div class="kbdetblock">
    <h3>{gt text='Solution'}</h3>
    <div>{$ticket.content|nl2br}</div>
</div>

<div class="kbthirdblock">
<dl>
{*    <dt>{gt text='Category'}</dt>
    <dd>{include file="KnowledgeBase_include_display_category.tpl"}</dd>*}
    <dt>{gt text='ID of this page'}</dt>
    <dd>{$ticket.ticketid}</dd>
    <dt>{gt text='Created on'}</dt>
    <dd>{$ticket.cr_date|dateformat}</dd>
    <dt>{gt text='Views'}</dt>
    <dd>{$ticket.views}</dd>
</dl>
</div>
<div class="kbthirdblock">
    {$hooks.Ratings}
</div>
<div class="kbthirdblock" id="kbhotornot" style="display: none">
    <h3>{gt text='Hot or not'}</h3>
    <p><span id="amountlikes">{$ticket.ratesup}</span> {gt text='likes'}, <span id="amountdislikes">{$ticket.ratesdown}</span> {gt text='dislikes'}</p>
    <p><a href="" id="linklikeit">{img modname="core" set="icons/extrasmall" src="1uparrow.gif" __alt='Like it'} {gt text="This answer was helpful"}</a><br /><a href="" id="linkdislikeit">{img modname="core" set="icons/extrasmall" src="1downarrow.gif" __alt='Dislike it'} {gt text="This answer was not helpful"}</a></p>
</div>
<br style="clear: left" />

<p>
    <a href="{modurl modname="KnowledgeBase" type="user" func="view"}" title="{gt text='Back to overview'}">
        {img src="agt_back.gif" modname="core" set="icons/extrasmall" __alt='Back' __title='Back to overview'}
        {gt text='Back to overview'}
    </a>
</p>
</div>
<div id="kbrightside">
    {include file="KnowledgeBase_include_rightblocks.tpl"}
</div>
<br style="clear: left" />

{$hooks.EZComments}
</div>

{include file="KnowledgeBase_user_footer.tpl"}

{ajaxheader modname="KnowledgeBase" filename="KnowledgeBase.js"}
<script type="text/javascript">
//<![CDATA[
    var kbTid = '{{$ticket.ticketid}}';
    document.observe('dom:loaded', onKbTicketDisplay);

//]]>
</script>