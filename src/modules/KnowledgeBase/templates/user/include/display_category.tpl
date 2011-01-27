{* purpose of this template: display a category within a ticket *}

{assign var='category' value=$ticket.Categories.TicketCategoryMain}
<a href="{modurl modname='KnowledgeBase' type='user' func='view' cat=$category.id}">{include file='user/include/display_category_name.tpl'}</a>
