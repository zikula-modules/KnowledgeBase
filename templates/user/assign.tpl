{* purpose of this template: show output of assign action in user area *}
{include file='user/header.tpl'}
<div class="knowledgebase-assign knowledgebase-assign">
{gt text='Assign' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>

    <p>Please override this template by moving it from <em>/modules/KnowledgeBase/templates/user/assign.tpl</em> to either your <em>/themes/YourTheme/templates/modules/KnowledgeBase/user/assign.tpl</em> or <em>/config/templates/KnowledgeBase/user/assign.tpl</em>.</p>

</div>
</div>
{include file='user/footer.tpl'}
