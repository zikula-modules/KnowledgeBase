{* purpose of this template: show output of assign action in user area *}
{include file='User/header.tpl'}
<div class="guiteknowledgebasemodule-assign guiteknowledgebasemodule-assign">
    {gt text='Assign' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <h2>{$templateTitle}</h2>

    <p>Please override this template by moving it from <em>/modules/Resources/views/User/assign.tpl</em> to either your <em>/themes/YourTheme/templates/modules/GuiteKnowledgeBaseModule/User/assign.tpl</em> or <em>/config/templates/GuiteKnowledgeBaseModule/User/assign.tpl</em>.</p>
</div>
{include file='User/footer.tpl'}
