{* purpose of this template: tickets display view in user area *}
{include file='User/header.tpl'}
<div class="guiteknowledgebasemodule-ticket guiteknowledgebasemodule-display">
    {gt text='Ticket' assign='templateTitle'}
    {assign var='templateTitle' value=$ticket->getTitleFromDisplayPattern()|default:$templateTitle}
    {pagesetvar name='title' value=$templateTitle|@html_entity_decode}
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div id="kbleftside">
{/if}
    <h2>{$templateTitle|notifyfilters:'guiteknowledgebasemodule.filter_hooks.tickets.filter'}{icon id='itemActionsTrigger' type='options' size='extrasmall' __alt='Actions' class='cursor-pointer hide'}</h2>

    <div class="kbdetblock">
        <h3>{gt text='Solution'}</h3>
        <div>{$ticket.content|nl2br}</div>
    </div>
    <div class="kbthirdblock">
        <dl>
      {*    <dt>{gt text='Category'}</dt>
            <dd>{include file='User/Include/display_category.tpl'}</dd>*}
            <dt>{gt text='ID of this page'}</dt>
            <dd>{$ticket.id}</dd>
            <dt>{gt text='Created on'}</dt>
            <dd>{$ticket.createdDate|dateformat}</dd>
            <dt>{gt text='Views'}</dt>
            <dd>{$ticket.views}</dd>
        </dl>
    </div>
    {notifydisplayhooks eventname='guiteknowledgebasemodule.ui_hooks.tickets.display_view' id=$ticket.id urlobject=$currentUrlObject assign='hooks'}
    <div class="kbthirdblock">
        {foreach key='providerArea' item='hook' from=$hooks}
            {if $providerArea eq 'Ratings'}
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

    {*include file='User/include_categories_display.tpl' obj=$ticket}
    {include file='User/include_standardfields_display.tpl' obj=$ticket*}

    {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        {if count($ticket._actions) gt 0}
            <p id="itemActions">
            {foreach item='option' from=$ticket._actions}
                <a href="{$option.url.type|guiteknowledgebasemoduleActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="fa fa-{$option.icon}">{$option.linkText|safetext}</a>
            {/foreach}
            </p>
            <script type="text/javascript">
            /* <![CDATA[ */
                document.observe('dom:loaded', function() {
                    kbaseInitItemActions('ticket', 'display', 'itemActions');
                });
            /* ]]> */
            </script>
        {/if}
        </div>
        <div id="kbrightside">
            {include file='User/Include/rightblocks.tpl'}
        </div>
        <br style="clear: left" />

        {* include display hooks *}
        {foreach key='providerArea' item='hook' from=$hooks}
            {if $providerArea ne 'Ratings'}
                {$hook}
            {/if}
        {/foreach}
    {/if}
</div>
{include file='User/footer.tpl'}

{pageaddvar name='javascript' value='modules/Guite/KnowledgeBaseModule/Resources/public/js/GuiteKnowledgeBaseModule_frontend.js'}
<script type="text/javascript">
//<![CDATA[
    var kbTid = '{$ticket.id}';
    document.observe('dom:loaded', onKbTicketDisplay);
//]]>
</script>
