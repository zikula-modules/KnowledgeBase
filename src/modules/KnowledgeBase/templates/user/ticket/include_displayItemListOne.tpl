{* purpose of this template: inclusion template for display of related Tickets in user area *}

<h4>
    <a href="{modurl modname='KnowledgeBase' type='user' func='display' ot='ticket' ticketid=$item.ticketid}">
        {$item.subject}
    </a>
    <a id="ticketItem{$item.ticketid}Display" href="{modurl modname='KnowledgeBase' type='user' func='display' ot='ticket' ticketid=$item.ticketid theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
        {img src='windows_list.png' modname='core' set='icons/extrasmall' __alt='Quick view'}
    </a>
</h4>
    <script type="text/javascript">
    /* <![CDATA[ */
        document.observe('dom:loaded', function() {
            kbaseInitInlineWindow($('ticketItem{{$item.ticketid}}Display'), '{{$item.subject|replace:"'":""}}');
        });
    /* ]]> */
    </script>

