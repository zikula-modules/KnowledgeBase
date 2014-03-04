{* purpose of this template: tickets view view in user area *}
{include file='User/header.tpl'}
<div class="guiteknowledgebasemodule-ticket guiteknowledgebasemodule-view">
    {gt text='Ticket list' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
<div id="kbleftside">
    <h2>{$templateTitle}</h2>

    {if $canBeCreated}
        {checkpermissionblock component='GuiteKnowledgeBaseModule:Ticket:' instance='::' level='ACCESS_EDIT'}
            {gt text='Create ticket' assign='createTitle'}
        {if isset($smarty.get.cat)}
            <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='edit' ot='ticket' cat=$smarty.get.cat}" title="{$createTitle}" class="fa fa-plus">{$createTitle}</a>
        {else}
            <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='edit' ot='ticket'}" title="{$createTitle}" class="fa fa-plus">{$createTitle}</a>
        {/if}
        {/checkpermissionblock}
    {/if}
    {assign var='own' value=0}
    {if isset($showOwnEntries) && $showOwnEntries eq 1}
        {assign var='own' value=1}
    {/if}
    {assign var='all' value=0}
{*
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket'}" title="{$linkTitle}" class="fa fa-table">
            {$linkTitle}
        </a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket' all=1}" title="{$linkTitle}" class="fa fa-table">{$linkTitle}</a>
    {/if}
*}
    {include file='User/Ticket/view_quickNav.tpl' all=$all own=$own workflowStateFilter=false}{* see template file for available options *}

    <table class="table table-striped table-bordered table-hover{* table-responsive*}">
        <colgroup>
            <col id="cSubject" />
            <col id="cContent" />
            <col id="cViews" />
            <col id="cRatesUp" />
            <col id="cRatesDown" />
            <col id="cItemActions" />
        </colgroup>
        <thead>
        <tr>
            {assign var='catIdListMainString' value=','|implode:$catIdList.Main}
            <th id="hSubject" scope="col" class="text-left">
                {sortlink __linktext='Subject' currentsort=$sort modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket' sort='subject' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize}
            </th>
            <th id="hContent" scope="col" class="text-left">
                {sortlink __linktext='Content' currentsort=$sort modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket' sort='content' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize}
            </th>
            <th id="hViews" scope="col" class="text-right">
                {sortlink __linktext='Views' currentsort=$sort modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket' sort='views' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize}
            </th>
            <th id="hRatesUp" scope="col" class="text-right">
                {sortlink __linktext='Rates up' currentsort=$sort modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket' sort='ratesUp' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize}
            </th>
            <th id="hRatesDown" scope="col" class="text-right">
                {sortlink __linktext='Rates down' currentsort=$sort modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket' sort='ratesDown' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize}
            </th>
            <th id="hItemActions" scope="col" class="z-order-unsorted">{gt text='Actions'}</th>
        </tr>
        </thead>
        <tbody>
    
    {foreach item='ticket' from=$items}
        <tr>
            <td headers="hSubject" class="z-left">
                {$ticket.subject}
            </td>
            <td headers="hContent" class="z-left">
                {$ticket.content}
            </td>
            <td headers="hViews" class="z-right">
                {$ticket.views}
            </td>
            <td headers="hRatesUp" class="z-right">
                {$ticket.ratesUp}
            </td>
            <td headers="hRatesDown" class="z-right">
                {$ticket.ratesDown}
            </td>
            <td id="itemActions{$ticket.id}" headers="hItemActions" class="actions nowrap z-w02">
                {if count($ticket._actions) gt 0}
                    {foreach item='option' from=$ticket._actions}
                        <a href="{$option.url.type|guiteknowledgebasemoduleActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'zoom-in'} target="_blank"{/if} class="fa fa-{$option.icon}" data-linktext="{$option.linkText|safetext}"></a>
                    {/foreach}
                    {icon id="itemActions`$ticket.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='cursor-pointer hide'}
                    <script type="text/javascript">
                    /* <![CDATA[ */
                        document.observe('dom:loaded', function() {
                            kbaseInitItemActions('ticket', 'view', 'itemActions{{$ticket.id}}');
                        });
                    /* ]]> */
                    </script>
                {/if}
            </td>
        </tr>
    {foreachelse}
        <tr class="z-datatableempty">
          <td class="text-left" colspan="6">
        {gt text='No tickets found.'}
          </td>
        </tr>
    {/foreach}
    
        </tbody>
    </table>

<dl>
    {foreach item='ticket' from=$items}
    <dt>
    {checkpermissionblock component='GuiteKnowledgeBaseModule::' instance='.*' level='ACCESS_EDIT'}
        {if count($ticket._actions) gt 0}
        {strip}
            {foreach item='option' from=$ticket._actions}
                <a href="{$option.url.type|guiteknowledgebasemoduleActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'zoom-in'} target="_blank"{/if} class="fa fa-{$option.icon}" data-linktext="{$option.linkText|safetext}"></a>
            {/foreach}
        {/strip}
        {/if}
    {/checkpermissionblock}
        <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$ticket.id}" title="{gt text="Details of '%s'" tag1=$ticket.subject|replace:"\"":""}">
            {$ticket.subject|notifyfilters:'guiteknowledgebasemodule.filter_hooks.tickets.filter'}
        </a>
    </dt>
    <dd>{$ticket.content}</dd>
{*    <dd>{gt text='Category'}: {include file='User/Include/display_category.tpl'}</dd>*}

    {foreachelse}
        <dt class="z-dataempty">{gt text='No tickets found.'}</dt>
    {/foreach}
</dl>

    {if !isset($showAllEntries) || $showAllEntries ne 1}
        {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page' modname='GuiteKnowledgeBaseModule' type='user' func='view' ot='ticket'}
    {/if}

    <p>
        <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='index'}" title="{gt text='Back to category list'}" class="fa fa-reply">
            {gt text='Back to category list'}
        </a>
    </p>

    {notifydisplayhooks eventname='guiteknowledgebasemodule.ui_hooks.tickets.display_view' urlobject=$currentUrlObject assign='hooks'}
    {foreach key='providerArea' item='hook' from=$hooks}
        {$hook}
    {/foreach}

</div>
<div id="kbrightside">
    {include file='User/Include/rightblocks.tpl'}
</div>
<br style="clear: left" />

</div>
{include file='User/footer.tpl'}
