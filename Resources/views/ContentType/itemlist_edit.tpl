{* Purpose of this template: edit view of generic item list content type *}
<div class="form-group">
    {gt text='Object type' domain='module_guiteknowledgebasemodule' assign='objectTypeSelectorLabel'}
    {formlabel for='guiteKnowledgeBaseModuleObjectType' text=$objectTypeSelectorLabel cssClass='col-lg-3 control-label'}
    <div class="col-lg-9">
        {guiteknowledgebasemoduleObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='guiteKnowledgeBaseModuleOjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
        <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.' domain='module_guiteknowledgebasemodule'}</span>
    </div>
</div>

{formvolatile}
{if $properties ne null && is_array($properties)}
    {nocache}
    {foreach key='registryId' item='registryCid' from=$registries}
        {assign var='propName' value=''}
        {foreach key='propertyName' item='propertyId' from=$properties}
            {if $propertyId eq $registryId}
                {assign var='propName' value=$propertyName}
            {/if}
        {/foreach}
        <div class="form-group">
            {modapifunc modname='GuiteKnowledgeBaseModule' type='category' func='hasMultipleSelection' ot=$objectType registry=$propertyName assign='hasMultiSelection'}
            {gt text='Category' domain='module_guiteknowledgebasemodule' assign='categorySelectorLabel'}
            {assign var='selectionMode' value='single'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' domain='module_guiteknowledgebasemodule' assign='categorySelectorLabel'}
                {assign var='selectionMode' value='multiple'}
            {/if}
            {formlabel for="guiteKnowledgeBaseModuleCatIds`$propertyName`" text=$categorySelectorLabel cssClass='col-lg-3 control-label'}
            <div class="col-lg-9">
                {formdropdownlist id="guiteKnowledgeBaseModuleCatIds`$propName`" items=$categories.$propName dataField="catids`$propName`" group='data' selectionMode=$selectionMode cssClass='form-control'}
                <span class="help-block">{gt text='This is an optional filter.' domain='module_guiteknowledgebasemodule'}</span>
            </div>
        </div>
    {/foreach}
    {/nocache}
{/if}
{/formvolatile}

<div class="form-group">
    {gt text='Sorting' domain='module_guiteknowledgebasemodule' assign='sortingLabel'}
    {formlabel text=$sortingLabel cssClass='col-lg-3 control-label'}
    <div class="col-lg-9">
        {formradiobutton id='guiteKnowledgeBaseModuleSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='module_guiteknowledgebasemodule' assign='sortingRandomLabel'}
        {formlabel for='guiteKnowledgeBaseModuleSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='guiteKnowledgeBaseModuleSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='module_guiteknowledgebasemodule' assign='sortingNewestLabel'}
        {formlabel for='guiteKnowledgeBaseModuleSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='guiteKnowledgeBaseModuleSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='module_guiteknowledgebasemodule' assign='sortingDefaultLabel'}
        {formlabel for='guiteKnowledgeBaseModuleSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="form-group">
    {gt text='Amount' domain='module_guiteknowledgebasemodule' assign='amountLabel'}
    {formlabel for='guiteKnowledgeBaseModuleAmount' text=$amountLabel cssClass='col-lg-3 control-label'}
    <div class="col-lg-9">
        {formintinput id='guiteKnowledgeBaseModuleAmount' dataField='amount' group='data' mandatory=true maxLength=2}
    </div>
</div>

<div class="form-group">
    {gt text='Template' domain='module_guiteknowledgebasemodule' assign='templateLabel'}
    {formlabel for='guiteKnowledgeBaseModuleTemplate' text=$templateLabel cssClass='col-lg-3 control-label'}
    <div class="col-lg-9">
        {guiteknowledgebasemoduleTemplateSelector assign='allTemplates'}
        {formdropdownlist id='guiteKnowledgeBaseModuleTemplate' dataField='template' group='data' mandatory=true items=$allTemplates cssClass='form-control'}
    </div>
</div>

<div id="customTemplateArea" class="form-group hide">
    {gt text='Custom template' domain='module_guiteknowledgebasemodule' assign='customTemplateLabel'}
    {formlabel for='guiteKnowledgeBaseModuleCustomTemplate' text=$customTemplateLabel cssClass='col-lg-3 control-label'}
    <div class="col-lg-9">
        {formtextinput id='guiteKnowledgeBaseModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='module_guiteknowledgebasemodule'}: <em>itemlist_[objectType]_display.tpl</em></span>
    </div>
</div>

<div class="form-group">
    {gt text='Filter (expert option)' domain='module_guiteknowledgebasemodule' assign='filterLabel'}
    {formlabel for='guiteKnowledgeBaseModuleFilter' text=$filterLabel cssClass='col-lg-3 control-label'}
    <div class="col-lg-9">
        {formtextinput id='guiteKnowledgeBaseModuleFilter' dataField='filter' group='data' mandatory=false maxLength=255 cssClass='form-control'}
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
