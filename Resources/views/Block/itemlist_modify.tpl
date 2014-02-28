{* Purpose of this template: Edit block for generic item list *}
<div class="form-group">
    <label for="guiteKnowledgeBaseModuleObjectType" class="col-lg-3 control-label">{gt text='Object type'}:</label>
    <div class="col-lg-9">
        <select id="guiteKnowledgeBaseModuleObjectType" name="objecttype" size="1" class="form-control">
            <option value="ticket"{if $objectType eq 'ticket'} selected="selected"{/if}>{gt text='Tickets'}</option>
        </select>
        <span class="help-block">{gt text='If you change this please save the block once to reload the parameters below.'}</span>
    </div>
</div>

{if $catIds ne null && is_array($catIds)}
    {gt text='All' assign='lblDefault'}
    {nocache}
    {foreach key='propertyName' item='propertyId' from=$catIds}
        <div class="form-group">
            {modapifunc modname='GuiteKnowledgeBaseModule' type='category' func='hasMultipleSelection' ot=$objectType registry=$propertyName assign='hasMultiSelection'}
            {gt text='Category' assign='categoryLabel'}
            {assign var='categorySelectorId' value='catid'}
            {assign var='categorySelectorName' value='catid'}
            {assign var='categorySelectorSize' value='1'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' assign='categoryLabel'}
                {assign var='categorySelectorName' value='catids'}
                {assign var='categorySelectorId' value='catids__'}
                {assign var='categorySelectorSize' value='8'}
            {/if}
            <label for="{$categorySelectorId}{$propertyName}" class="col-lg-3 control-label">{$categoryLabel}</label>
            <div class="col-lg-9">
                {selector_category name="`$categorySelectorName``$propertyName`" field='id' selectedValue=$catIds.$propertyName categoryRegistryModule='GuiteKnowledgeBaseModule' categoryRegistryTable=$objectType categoryRegistryProperty=$propertyName defaultText=$lblDefault editLink=false multipleSize=$categorySelectorSize cssClass='form-control'}
                <span class="help-block">{gt text='This is an optional filter.'}</span>
            </div>
        </div>
    {/foreach}
    {/nocache}
{/if}

<div class="form-group">
    <label for="guiteKnowledgeBaseModuleSorting" class="col-lg-3 control-label">{gt text='Sorting'}:</label>
    <div class="col-lg-9">
        <select id="guiteKnowledgeBaseModuleSorting" name="sorting" class="form-control">
            <option value="random"{if $sorting eq 'random'} selected="selected"{/if}>{gt text='Random'}</option>
            <option value="newest"{if $sorting eq 'newest'} selected="selected"{/if}>{gt text='Newest'}</option>
            <option value="alpha"{if $sorting eq 'default' || ($sorting != 'random' && $sorting != 'newest')} selected="selected"{/if}>{gt text='Default'}</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="guiteKnowledgeBaseModuleAmount" class="col-lg-3 control-label">{gt text='Amount'}:</label>
    <div class="col-lg-9">
        <input type="text" id="guiteKnowledgeBaseModuleAmount" name="amount" maxlength="2" size="10" value="{$amount|default:"5"}" class="form-control" />
    </div>
</div>

<div class="form-group">
    <label for="guiteKnowledgeBaseModuleTemplate" class="col-lg-3 control-label">{gt text='Template'}:</label>
    <div class="col-lg-9">
        <select id="guiteKnowledgeBaseModuleTemplate" name="template" class="form-control">
            <option value="itemlist_display.tpl"{if $template eq 'itemlist_display.tpl'} selected="selected"{/if}>{gt text='Only item titles'}</option>
            <option value="itemlist_display_description.tpl"{if $template eq 'itemlist_display_description.tpl'} selected="selected"{/if}>{gt text='With description'}</option>
            <option value="custom"{if $template eq 'custom'} selected="selected"{/if}>{gt text='Custom template'}</option>
        </select>
    </div>
</div>

<div id="customTemplateArea" class="form-group hide">
    <label for="guiteKnowledgeBaseModuleCustomTemplate" class="col-lg-3 control-label">{gt text='Custom template'}:</label>
    <div class="col-lg-9">
        <input type="text" id="guiteKnowledgeBaseModuleCustomTemplate" name="customtemplate" size="40" maxlength="80" value="{$customTemplate|default:''}" class="form-control" />
        <span class="help-block">{gt text='Example'}: <em>itemlist_[objectType]_display.tpl</em></span>
    </div>
</div>

<div class="form-group">
    <label for="guiteKnowledgeBaseModuleFilter" class="col-lg-3 control-label">{gt text='Filter (expert option)'}:</label>
    <div class="col-lg-9">
        <input type="text" id="guiteKnowledgeBaseModuleFilter" name="filter" size="40" value="{$filterValue|default:''}" class="form-control" />
        <span class="help-block">
            <a class="fa fa-filter" data-toggle="modal" data-target="#filterSyntaxModal">{gt text='Show syntax examples'}</a>
        </span>
    </div>
</div>

{include file='include_filterSyntaxDialog.tpl'}

{pageaddvar name='javascript' value='prototype'}
<script type="text/javascript">
/* <![CDATA[ */
    function kbaseToggleCustomTemplate() {
        if ($F('guiteKnowledgeBaseModuleTemplate') == 'custom') {
            $('customTemplateArea').removeClassName('hide');
        } else {
            $('customTemplateArea').addClassName('hide');
        }
    }

    document.observe('dom:loaded', function() {
        kbaseToggleCustomTemplate();
        $('guiteKnowledgeBaseModuleTemplate').observe('change', function(e) {
            kbaseToggleCustomTemplate();
        });
    });
/* ]]> */
</script>
