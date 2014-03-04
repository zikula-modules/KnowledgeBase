{* purpose of this template: display a category within a ticket *}
{assign var='category' value=$ticket.Categories.TicketCategoryMain}
<a href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='view' cat=$category.id}">{include file='User/Include/display_category_name.tpl'}</a>
