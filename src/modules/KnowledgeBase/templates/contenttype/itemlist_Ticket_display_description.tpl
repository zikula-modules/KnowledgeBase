{* Purpose of this template: Display tickets within an external context *}

<dl>
{foreach item='item' from=$items}
    <dt>{$item.subject}</dt>
{if $item.content}
    <dd>{$item.content|truncate:200:"..."}</dd>
{/if}
    <dd><a href="{modurl modname='KnowledgeBase' type='user' func='display' ot=$objectType id=$item.id}">{gt text='Read more'}</a></dd>
{foreachelse}
    <dt>{gt text='No entries found.'}</dt>
{/foreach}
</dl>
