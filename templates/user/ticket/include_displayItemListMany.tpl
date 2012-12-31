{* purpose of this template: inclusion template for display of related Tickets in user area *}

{if isset($items) && $items ne null}
<ul class="relatedItemList Ticket">
{foreach name='relLoop' item='item' from=$items}
    <li>
    <a href="{modurl modname='KnowledgeBase' type='user' func='display' ot='ticket' id=$item.id}">
        {$item.subject}
    </a>
    <a id="ticketItem{$item.id}Display" href="{modurl modname='KnowledgeBase' type='user' func='display' ot='ticket' id=$item.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
        {icon type='view' size='extrasmall' __alt='Quick view'}
    </a>
    <script type="text/javascript" charset="utf-8">
    /* <![CDATA[ */
        document.observe('dom:loaded', function() {
            kbaseInitInlineWindow($('ticketItem{{$item.id}}Display'), '{{$item.subject|replace:"'":""}}');
        });
    /* ]]> */
    </script>

    </li>
{/foreach}
</ul>
{/if}

