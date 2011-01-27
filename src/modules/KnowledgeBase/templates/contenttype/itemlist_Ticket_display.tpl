{* Purpose of this template: Display tickets within an external context *}

{foreach item='item' from=$items}
    <h3>{$item.subject}</h3>
    <p><a href="{modurl modname="KnowledgeBase" type="user" func="display" ot=$objectType ticketid=$item.ticketid}">{gt text='Read more'}</a></p>
{/foreach}
