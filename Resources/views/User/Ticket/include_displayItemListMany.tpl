{* purpose of this template: inclusion template for display of related tickets in user area *}
{checkpermission component='GuiteKnowledgeBaseModule:Ticket:' instance='::' level='ACCESS_EDIT' assign='hasAdminPermission'}
{checkpermission component='GuiteKnowledgeBaseModule:Ticket:' instance='::' level='ACCESS_EDIT' assign='hasEditPermission'}
{if !isset($nolink)}
    {assign var='nolink' value=false}
{/if}
{if isset($items) && $items ne null && count($items) gt 0}
<ul class="guiteknowledgebasemodule-related-item-list ticket">
{foreach name='relLoop' item='item' from=$items}
{if $hasAdminPermission || $item.workflowState eq 'approved'}
    <li>
{strip}
{if !$nolink}
    <a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$item.id}" title="{$item->getTitleFromDisplayPattern()|replace:"\"":""}">
{/if}
    {$item->getTitleFromDisplayPattern()}
{if !$nolink}
    </a>
    <a id="ticketItem{$item.id}Display" href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$item.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" class="fa fa-search-plus hidden"></a>
{/if}
{/strip}
{if !$nolink}
<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        kbaseInitInlineWindow($('ticketItem{{$item.id}}Display'), '{{$item->getTitleFromDisplayPattern()|replace:"'":""}}');
    });
/* ]]> */
</script>
{/if}
    </li>
{/if}
{/foreach}
</ul>
{/if}
