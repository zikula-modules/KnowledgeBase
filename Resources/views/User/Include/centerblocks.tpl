{* purpose of this template: knowledge base center blocks *}
<div class="kbcblock">
    <h3>{gt text='Popular Knowledge Base Entries'}</h3>
    {modapifunc modname='GuiteKnowledgeBaseModule' type='user' func='getTickets' amount=5 sort='views' sortdir='desc' assign='tickets'}
    <dl>
    {foreach item='ticket' from=$tickets[0]}
        <dt><a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$ticket.id}" title="{gt text="Details of '%s'" tag1=$ticket.subject|replace:"\"":""}">{$ticket.subject|notifyfilters:'knowledgebase.filter_hooks.tickets.filter'}</a></dt>
        <dd>{$ticket.views} views</dd>
    {/foreach}
    </dl>
</div>
<div class="kbcblock">
    <h3>{gt text='Latest Knowledge Base Entries'}</h3>
    {modapifunc modname='GuiteKnowledgeBaseModule' type='user' func='getTickets' amount=5 sort='createdDate' sortdir='desc' assign='tickets'}
    <dl>
    {foreach item='ticket' from=$tickets[0]}
        <dt><a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$ticket.id}" title="{gt text="Details of '%s'" tag1=$ticket.subject|replace:"\"":""}">{$ticket.subject|notifyfilters:'knowledgebase.filter_hooks.tickets.filter'}</a></dt>
        <dd>added on {$ticket.createdDate|dateformat}</dd>
    {/foreach}
    </dl>
</div>
<br style="clear: left" />
