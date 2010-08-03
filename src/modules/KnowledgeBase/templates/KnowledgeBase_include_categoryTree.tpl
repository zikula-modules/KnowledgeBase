
{lang assign='currentLang'}
{assign var="categoryIndex" value=1}
{assign var="lastCategory" value=0}
{assign var="lastLevel" value=0}

{assign var="diffLevel" value=0}
{if $ot eq "component"}
{assign var="diffLevel" value=6}
{if $registryName eq "COMPONENTLICENSE"}{assign var="diffLevel" value=4}{/if}
{elseif $ot eq "distribution"}
{assign var="diffLevel" value=4}{*0="",1=__SYSTEM__,2=knowledge base,3=registry name*}
{/if}

<ul>
    {foreach name="catLoop" item="category" from=$categories}
    {strip}
        {splitvar var=$category.path delim="/" assign="pathArr"}
        {capture assign="currentLevel"}{$pathArr|@count}{/capture}
        {assign var="currentLevel" value=$currentLevel-$diffLevel}
        {kbProcessListLevels level=$currentLevel lastlevel=$lastLevel}


        {assign var="categoryIndex" value=$categoryIndex+1}
        {assign var="nextLevel" value=$currentLevel}
        {if $categories[$categoryIndex]}
            {assign var="nextCat" value=$categories[$categoryIndex]}
            {splitvar var=$nextCat.path delim="/" assign="pathArr"}
            {capture assign="nextLevel"}{$pathArr|@count}{/capture}
            {assign var="nextLevel" value=$nextLevel-$diffLevel}
        {/if}

        <li{if $smarty.foreach.catLoop.first || $nextLevel lt $currentLevel || !$categories[$categoryIndex]} class="last"{/if}>
            <a href="{$category.viewurlFormatted}" title="{gt text="See all topics in '%s'" tag1=$category.nameStripped}">
            {assign var="nameFound" value=false}
            {if $category.display_name}
                {foreach item="displayname" key="langcode" from=$category.display_name}
                    {if $langcode eq $currentLang}
                        {assign var="nameFound" value=true}
                        {$displayname|safetext}
                    {/if}
                {/foreach}
            {/if}
            {if !$category.display_name || $nameFound eq false}
                {$category.name|safetext}
            {/if}
            </a>&nbsp;({$category.ticketcount})

        {assign var="lastCategory" value=$category.id}
        {assign var="lastLevel" value=$currentLevel}
    {/strip}
    {/foreach}

    </li>
</ul>
