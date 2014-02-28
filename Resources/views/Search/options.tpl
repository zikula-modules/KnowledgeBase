{* Purpose of this template: Display search options *}
<input type="hidden" id="guiteKnowledgeBaseModuleActive" name="active[GuiteKnowledgeBaseModule]" value="1" checked="checked" />
<div>
    <input type="checkbox" id="active_guiteKnowledgeBaseModuleTickets" name="guiteKnowledgeBaseModuleSearchTypes[]" value="ticket"{if $active_ticket} checked="checked"{/if} />
    <label for="active_guiteKnowledgeBaseModuleTickets">{gt text='Tickets' domain='module_guiteknowledgebasemodule'}</label>
</div>
