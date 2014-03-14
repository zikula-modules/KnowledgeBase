{* purpose of this template: tickets view filter form in user area *}
{checkpermissionblock component='GuiteKnowledgeBaseModule:Ticket:' instance='::' level='ACCESS_EDIT'}
{assign var='objectType' value='ticket'}
<form action="{$modvars.ZConfig.entrypoint|default:'index.php'}" method="get" id="guiteKnowledgeBaseModuleTicketQuickNavForm" class="guiteknowledgebasemodule-quicknav {*form-inline*}navbar-form" role="navigation">
    <fieldset>
        <h3>{gt text='Quick navigation'}</h3>
        <input type="hidden" name="module" value="{modgetinfo modname='GuiteKnowledgeBaseModule' info='url'}" />
        <input type="hidden" name="type" value="user" />
        <input type="hidden" name="func" value="view" />
        <input type="hidden" name="ot" value="ticket" />
        <input type="hidden" name="all" value="{$all|default:0}" />
        <input type="hidden" name="own" value="{$own|default:0}" />
        {gt text='All' assign='lblDefault'}
        {if !isset($categoryFilter) || $categoryFilter eq true}
            {modapifunc modname='GuiteKnowledgeBaseModule' type='category' func='getAllProperties' ot=$objectType assign='properties'}
            {if $properties ne null && is_array($properties)}
                {gt text='All' assign='lblDefault'}
                {nocache}
                {foreach key='propertyName' item='propertyId' from=$properties}
                    {modapifunc modname='GuiteKnowledgeBaseModule' type='category' func='hasMultipleSelection' ot=$objectType registry=$propertyName assign='hasMultiSelection'}
                    {gt text='Category' assign='categoryLabel'}
                    {assign var='categorySelectorId' value='catid'}
                    {assign var='categorySelectorName' value='catid'}
                    {assign var='categorySelectorSize' value='1'}
                    {if $hasMultiSelection eq true}
                        {gt text='Categories' assign='categoryLabel'}
                        {assign var='categorySelectorName' value='catids'}
                        {assign var='categorySelectorId' value='catids__'}
                        {assign var='categorySelectorSize' value='5'}
                    {/if}
                    <div class="form-group">
                        <label for="{$categorySelectorId}{$propertyName}">{$categoryLabel}</label>
                        &nbsp;
                        {selector_category name="`$categorySelectorName``$propertyName`" field='id' selectedValue=$catIdList.$propertyName categoryRegistryModule='GuiteKnowledgeBaseModule' categoryRegistryTable=$objectType categoryRegistryProperty=$propertyName defaultText=$lblDefault editLink=false multipleSize=$categorySelectorSize cssClass='form-control input-sm'}
                    </div>
                {/foreach}
                {/nocache}
            {/if}
        {/if}
        {if !isset($workflowStateFilter) || $workflowStateFilter eq true}
            <div class="form-group">
                <label for="workflowState">{gt text='Workflow state'}</label>
                <select id="workflowState" name="workflowState" class="form-control input-sm">
                    <option value="">{$lblDefault}</option>
                {foreach item='option' from=$workflowStateItems}
                <option value="{$option.value}"{if $option.title ne ''} title="{$option.title|safetext}"{/if}{if $option.value eq $workflowState} selected="selected"{/if}>{$option.text|safetext}</option>
                {/foreach}
                </select>
            </div>
        {/if}
        {if !isset($searchFilter) || $searchFilter eq true}
            <div class="form-group">
                <label for="searchTerm">{gt text='Search'}</label>
                <input type="text" id="searchTerm" name="searchterm" value="{$searchterm}" class="form-control input-sm" />
            </div>
        {/if}
        {if !isset($sorting) || $sorting eq true}
            <div class="form-group">
                <label for="sortBy">{gt text='Sort by'}</label>
                &nbsp;
                <select id="sortBy" name="sort" class="form-control input-sm">
                    <option value="id"{if $sort eq 'id'} selected="selected"{/if}>{gt text='Id'}</option>
                    <option value="workflowState"{if $sort eq 'workflowState'} selected="selected"{/if}>{gt text='Workflow state'}</option>
                    <option value="subject"{if $sort eq 'subject'} selected="selected"{/if}>{gt text='Subject'}</option>
                    <option value="content"{if $sort eq 'content'} selected="selected"{/if}>{gt text='Content'}</option>
                    <option value="views"{if $sort eq 'views'} selected="selected"{/if}>{gt text='Views'}</option>
                    <option value="ratesUp"{if $sort eq 'ratesUp'} selected="selected"{/if}>{gt text='Rates up'}</option>
                    <option value="ratesDown"{if $sort eq 'ratesDown'} selected="selected"{/if}>{gt text='Rates down'}</option>
                    <option value="createdDate"{if $sort eq 'createdDate'} selected="selected"{/if}>{gt text='Creation date'}</option>
                    <option value="createdUserId"{if $sort eq 'createdUserId'} selected="selected"{/if}>{gt text='Creator'}</option>
                    <option value="updatedDate"{if $sort eq 'updatedDate'} selected="selected"{/if}>{gt text='Update date'}</option>
                </select>
            </div>
            <div class="form-group">
                <select id="sortDir" name="sortdir" class="form-control input-sm">
                    <option value="asc"{if $sdir eq 'asc'} selected="selected"{/if}>{gt text='ascending'}</option>
                    <option value="desc"{if $sdir eq 'desc'} selected="selected"{/if}>{gt text='descending'}</option>
                </select>
            </div>
        {else}
            <input type="hidden" name="sort" value="{$sort}" />
            <input type="hidden" name="sdir" value="{if $sdir eq 'desc'}asc{else}desc{/if}" />
        {/if}
        {if !isset($pageSizeSelector) || $pageSizeSelector eq true}
            <div class="form-group">
                <label for="num">{gt text='Page size'}</label>
                <select id="num" name="num" class="form-control input-sm" style="min-width: 70px">
                    <option value="5"{if $pageSize eq 5} selected="selected"{/if}>5</option>
                    <option value="10"{if $pageSize eq 10} selected="selected"{/if}>10</option>
                    <option value="15"{if $pageSize eq 15} selected="selected"{/if}>15</option>
                    <option value="20"{if $pageSize eq 20} selected="selected"{/if}>20</option>
                    <option value="30"{if $pageSize eq 30} selected="selected"{/if}>30</option>
                    <option value="50"{if $pageSize eq 50} selected="selected"{/if}>50</option>
                    <option value="100"{if $pageSize eq 100} selected="selected"{/if}>100</option>
                </select>
            </div>
        {/if}
        <input type="submit" name="updateview" id="quicknavSubmit" value="{gt text='OK'}" class="btn btn-default" />
    </fieldset>
</form>

<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        kbaseInitQuickNavigation('ticket', 'user');
        {{if isset($searchFilter) && $searchFilter eq false}}
            {{* we can hide the submit button if we have no quick search field *}}
            $('quicknavSubmit').addClassName('hidden');
        {{/if}}
    });
/* ]]> */
</script>
{/checkpermissionblock}
