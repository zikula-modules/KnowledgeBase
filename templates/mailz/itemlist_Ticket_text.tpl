{* Purpose of this template: Display tickets in text mailings *}
{foreach item='item' from=$items}
        {$item.subject}
        {modurl modname='KnowledgeBase' type='user' func='display' ot=$objectType id=$item.id fqurl=true}
-----
{foreachelse}
    {gt text='No tickets found.'}
{/foreach}
