{* Purpose of this template: Edit block for generic item list *}

<div class="z-formrow">
    <label for="KnowledgeBase_objecttype">{gt text='Object type'}:</label>
    <select id="KnowledgeBase_objecttype" name="objecttype" size="1">
        <option value="ticket"{if $objectType eq 'ticket'} selected="selected"{/if}>{gt text='Tickets'}</option>
    </select>
</div>

<div class="z-formrow">
    <label for="KnowledgeBase_sorting">{gt text='Sorting'}:</label>
    <select id="KnowledgeBase_sorting" name="sorting">
        <option value="random"{if $sorting eq 'random'} selected="selected"{/if}>{gt text='Random'}</option>
        <option value="newest"{if $sorting eq 'newest'} selected="selected"{/if}>{gt text='Newest'}</option>
        <option value="alpha"{if $sorting eq 'default' || ($sorting != 'random' && $sorting != 'newest')} selected="selected"{/if}>{gt text='Default'}</option>
    </select>
</div>

<div class="z-formrow">
    <label for="KnowledgeBase_amount">{gt text='Amount'}:</label>
    <input type="text" id="KnowledgeBase_amount" name="amount" size="10" value="{$amount|default:"5"}" />
</div>

<div class="z-formrow">
    <label for="KnowledgeBase_template">{gt text='Template File'}:</label>
    <select id="KnowledgeBase_template" name="template">
        <option value="itemlist_display.tpl"{if $template eq 'itemlist_display.tpl'} selected="selected"{/if}>{gt text='Only item titles'}</option>
        <option value="itemlist_display_description.tpl"{if $template eq 'itemlist_display_description.tpl'} selected="selected"{/if}>{gt text='With description'}</option>
    </select>
</div>

<div class="z-formrow">
    <label for="KnowledgeBase_filter">{gt text='Filter (expert option)'}:</label>
    <input type="text" id="KnowledgeBase_filter" name="filter" size="40" value="{$filterValue|default:""}" />
    <div class="z-formnote">({gt text='Syntax examples'}: <kbd>name:like:foobar</kbd> {gt text='or'} <kbd>status:ne:3</kbd>)</div>
</div>
