{* purpose of this template: sidebar blocks *}
<div id="kbasesidebar">
    <h3>{gt text='All categories'}</h3>
    {modapifunc modname='KnowledgeBase' type='user' func='getCategories' full=true assign='categories'}
    {include file='user/include/categoryTree.tpl'}

    <h3>{gt text='Search'}</h3>
    <form action="index.php" method="get">
        <div>
            <input type="hidden" name="module" value="KnowledgeBase" />
            <input type="hidden" name="type" value="user" />
            <input type="hidden" name="func" value="view" />
            <label for="term">{gt text='Your search term'}</label>
            <input type="text" id="term" name="term" value="{$smarty.get.term|safetext}" />
            <input type="submit" name="kbs" value="{gt text='Search'}" />
        </div>
    </form>
</div>