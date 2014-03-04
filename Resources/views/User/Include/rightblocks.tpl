{* purpose of this template: sidebar blocks *}
<div id="kbasesidebar">
    <h3>{gt text='All categories'}</h3>
    {modapifunc modname='GuiteKnowledgeBaseModule' type='user' func='getCategories' full=true assign='categories'}
    {include file='User/Include/categoryTree.tpl'}

    <h3>{gt text='Search'}</h3>
    <form action="index.php" method="get">
        <div>
            <input type="hidden" name="module" value="GuiteKnowledgeBaseModule" />
            <input type="hidden" name="type" value="user" />
            <input type="hidden" name="func" value="view" />
            <label for="searchterm">{gt text='Your search term'}</label>
            <input type="text" id="searchterm" name="searchterm" value="{if isset($smarty.get.term)}{$smarty.get.term|safetext}{/if}" />
            <input type="submit" name="kbs" value="{gt text='Search'}" />
        </div>
    </form>
</div>