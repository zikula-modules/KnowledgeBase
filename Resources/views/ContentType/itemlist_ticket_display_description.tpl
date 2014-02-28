{* Purpose of this template: Display tickets within an external context *}
<dl>
    {foreach item='ticket' from=$items}
        <dt>{$ticket->getTitleFromDisplayPattern()}</dt>
        {if $ticket.content}
            <dd>{$ticket.content|strip_tags|truncate:200:'&hellip;'}</dd>
        {/if}
        <dd><a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot=$objectType id=$ticket.id}">{gt text='Read more'}</a>
        </dd>
    {foreachelse}
        <dt>{gt text='No entries found.'}</dt>
    {/foreach}
</dl>
