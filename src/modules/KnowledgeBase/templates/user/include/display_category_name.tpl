{* purpose of this template: display the name of a category *}
{lang assign='currentLang'}
{assign var='nameFound' value=false}
{if $category.display_name}
{foreach item='displayname' key='langcode' from=$category.display_name}
{if $langcode eq $currentLang}{assign var='nameFound' value=true}{$displayname|safetext}{/if}
{/foreach}
{/if}
{if !$category.display_name || $nameFound eq false}{$category.name|safetext}{/if}
