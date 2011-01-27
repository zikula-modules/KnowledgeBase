{* Purpose of this template: Display tickets in mailings *}
{*
<ul>
{foreach item='item' from=$items}
    <li>
        <a href="{modurl modname='KnowledgeBase' type='user' func='display' ot=$objectType ticketid=$item.ticketid}">{$item.subject}</a>
    </li>
{foreachelse}
    <li>{gt text='No tickets found.'}</li>
{/foreach}
</ul>
*}

{include file='contenttype/itemlist_Ticket_display_description.tpl'}
