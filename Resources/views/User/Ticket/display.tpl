{* purpose of this template: tickets display view in user area *}
{include file='User/header.tpl'}
<div class="guiteknowledgebasemodule-ticket guiteknowledgebasemodule-display">
    {gt text='Ticket' assign='templateTitle'}
    {assign var='templateTitle' value=$ticket->getTitleFromDisplayPattern()|default:$templateTitle}
    {pagesetvar name='title' value=$templateTitle|@html_entity_decode}
    <h2>{$templateTitle|notifyfilters:'guiteknowledgebasemodule.filter_hooks.tickets.filter'}{icon id='itemActionsTrigger' type='options' size='extrasmall' __alt='Actions' class='cursor-pointer hide'}</h2>

    <dl>
        <dt>{gt text='Subject'}</dt>
        <dd>{$ticket.subject}</dd>
        <dt>{gt text='Content'}</dt>
        <dd>{$ticket.content}</dd>
        <dt>{gt text='Views'}</dt>
        <dd>{$ticket.views}</dd>
        <dt>{gt text='Rates up'}</dt>
        <dd>{$ticket.ratesUp}</dd>
        <dt>{gt text='Rates down'}</dt>
        <dd>{$ticket.ratesDown}</dd>
        
    </dl>
    {include file='User/include_categories_display.tpl' obj=$ticket}
    {include file='User/include_standardfields_display.tpl' obj=$ticket}

    {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        {* include display hooks *}
        {notifydisplayhooks eventname='guiteknowledgebasemodule.ui_hooks.tickets.display_view' id=$ticket.id urlobject=$currentUrlObject assign='hooks'}
        {foreach key='providerArea' item='hook' from=$hooks}
            {$hook}
        {/foreach}
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
    {/if}
</div>
{include file='User/footer.tpl'}
