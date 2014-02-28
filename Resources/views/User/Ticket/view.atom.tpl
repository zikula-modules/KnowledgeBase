{* purpose of this template: tickets atom feed in user area *}
{guiteknowledgebasemoduleTemplateHeaders contentType='application/atom+xml'}<?xml version="1.0" encoding="{charset assign='charset'}{if $charset eq 'ISO-8859-15'}ISO-8859-1{else}{$charset}{/if}" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
{gt text='Latest tickets' assign='channelTitle'}
{gt text='A direct feed showing the list of tickets' assign='channelDesc'}
    <title type="text">{$channelTitle}</title>
    <subtitle type="text">{$channelDesc} - {$modvars.ZConfig.slogan}</subtitle>
    <author>
        <name>{$modvars.ZConfig.sitename}</name>
    </author>
{assign var='numItems' value=$items|@count}
{if $numItems}
{capture assign='uniqueID'}tag:{$baseurl|replace:'http://':''|replace:'/':''},{$items[0].createdDate|dateformat|default:$smarty.now|dateformat:'%Y-%m-%d'}:{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$items[0].id}{/capture}
    <id>{$uniqueID}</id>
    <updated>{$items[0].updatedDate|default:$smarty.now|dateformat:'%Y-%m-%dT%H:%M:%SZ'}</updated>
{/if}
    <link rel="alternate" type="text/html" hreflang="{lang}" href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='index' fqurl=1}" />
    <link rel="self" type="application/atom+xml" href="{php}echo substr(\System::getBaseURL(), 0, strlen(\System::getBaseURL())-1);{/php}{getcurrenturi}" />
    <rights>Copyright (c) {php}echo date('Y');{/php}, {$baseurl}</rights>

{foreach item='ticket' from=$items}
    <entry>
        <title type="html">{$ticket->getTitleFromDisplayPattern()|notifyfilters:'guiteknowledgebasemodule.filterhook.tickets'}</title>
        <link rel="alternate" type="text/html" href="{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$ticket.id fqurl='1'}" />

        {capture assign='uniqueID'}tag:{$baseurl|replace:'http://':''|replace:'/':''},{$ticket.createdDate|dateformat|default:$smarty.now|dateformat:'%Y-%m-%d'}:{modurl modname='GuiteKnowledgeBaseModule' type='user' func='display' ot='ticket' id=$ticket.id}{/capture}
        <id>{$uniqueID}</id>
        {if isset($ticket.updatedDate) && $ticket.updatedDate ne null}
            <updated>{$ticket.updatedDate|dateformat:'%Y-%m-%dT%H:%M:%SZ'}</updated>
        {/if}
        {if isset($ticket.createdDate) && $ticket.createdDate ne null}
            <published>{$ticket.createdDate|dateformat:'%Y-%m-%dT%H:%M:%SZ'}</published>
        {/if}
        {if isset($ticket.createdUserId)}
            {usergetvar name='uname' uid=$ticket.createdUserId assign='cr_uname'}
            {usergetvar name='name' uid=$ticket.createdUserId assign='cr_name'}
            <author>
               <name>{$cr_name|default:$cr_uname}</name>
               <uri>{usergetvar name='_UYOURHOMEPAGE' uid=$ticket.createdUserId assign='homepage'}{$homepage|default:'-'}</uri>
               <email>{usergetvar name='email' uid=$ticket.createdUserId}</email>
            </author>
        {/if}

        <summary type="html">
            <![CDATA[
            {$ticket.content|truncate:150:"&hellip;"|default:'-'}
            ]]>
        </summary>
        <content type="html">
            <![CDATA[
            {$ticket.subject|replace:'<br>':'<br />'}
            ]]>
        </content>
    </entry>
{/foreach}
</feed>
