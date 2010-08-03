{* purpose of this template: display a category within a ticket *}

{assign var="category" value=$ticket.__CATEGORIES__.TicketCategoryMain}
<a href="{modurl modname="KnowledgeBase" type="user" func="view" cat=$category.id}">{include file="KnowledgeBase_include_display_category_name.tpl"}</a>
