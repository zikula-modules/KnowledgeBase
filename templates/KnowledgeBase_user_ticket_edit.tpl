{* purpose of this template: build the pnForm to edit an instance of user *}

{include file="KnowledgeBase_user_header.tpl"}

{if $mode == "edit"}
    {gt text='Edit ticket' assign="templateTitle"}
{elseif $mode == "create"}
    {gt text='Create ticket' assign="templateTitle"}
{else}
    {gt text='Edit ticket' assign="templateTitle"}
{/if}

<div class="z-frontendcontainer">

{pagesetvar name="title" value=$templateTitle}
<h2>{$templateTitle}</h2>
<br />
{form cssClass="z-form"}

    {* add validation summary and a <div> element for styling the form *}
    {knowledgebaseFormFrame}
    {*pnformvalidationsummary*}

    {formsetinitialfocus inputId="subject"}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        <div class="z-formrow">
            {formlabel for="subject" __text='Subject'}
            {formtextinput id="subject" mandatory=true __title='Input the subject of the ticket' textMode="singleline" maxLength=255}
        </div>
        <div class="z-formrow">
            {formlabel for="content" __text='Content'}
            {formtextinput id="content" mandatory=true __title='Input the content of the ticket' textMode="multiline" rows="8" cols="50"}
        </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='Category'}</legend>

        <div class="z-formrow">
            {formlabel for="category" __text='Category'}
        {foreach from=$categories key=property item=category}
            {array_field_isset array=$__CATEGORIES__ field=$property assign="catExists"}
            {if $catExists}
                {array_field_isset array=$__CATEGORIES__.$property field="id" returnValue=1 assign="selectedValue"}
            {else}
                {assign var='selectedValue' value='0'}
            {/if}
            {formcategoryselector id=$property mandatory=true __title='Choose the category' category=$category enableDBUtil=1 selectedValue=$selectedValue defaultValue='0' editLink=false}
        {/foreach}
        </div>
    </fieldset>
{if $mode ne "create"}
    <fieldset>
        <legend>{gt text='Statistics'}</legend>

        <div class="z-formrow">
            {formlabel for="views" __text='Views'}
            {formintinput id="views" mandatory=false __title='Input the views of the ticket' maxLength=11 readOnly=true style="width: 80px; text-align: right"}
        </div>
        <div class="z-formrow">
            {formlabel for="ratesup" __text='Rates up'}
            {formintinput id="ratesup" mandatory=false __title='Input the rates up of the ticket' maxLength=4 readOnly=true style="width: 80px; text-align: right"}
        </div>
        <div class="z-formrow">
            {formlabel for="ratesdown" __text='Rates down'}
            {formintinput id="ratesdown" mandatory=false __title='Input the rates down of the ticket' maxLength=4 readOnly=true style="width: 80px; text-align: right"}
        </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='Meta data'}</legend>
        <ul>
            {usergetvar name="uname" uid=$cr_uid assign="username"}
            <li>{gt text='Created by %s' tag1=$username}</li>
            <li>{gt text='Created on %s' tag1=$cr_date|dateformat}</li>
            {usergetvar name="uname" uid=$lu_uid assign="username"}
            <li>{gt text='Updated by %s' tag1=$username}</li>
            <li>{gt text='Updated on %s' tag1=$lu_date|dateformat}</li>
        </ul>
    </fieldset>
{/if}
{*
    <fieldset>
        <legend>{gt text='Hooks'}</legend>
        {if $mode == "edit"}
            {modcallhooks hookobject="item" hookaction="modify" module="KnowledgeBase" hookid="ticket`$ticketid`"}
        {elseif $mode == "create"}
            {modcallhooks hookobject="item" hookaction="new" module="KnowledgeBase"}
        {else}
            {modcallhooks hookobject="item" hookaction="modify" module="KnowledgeBase" hookid="ticket`$ticketid`"}
        {/if}
    </fieldset>
*}
    {gt text='Really delete this ticket?' assign="deleteConfirmMsg"}

    <div class="z-formbuttons">
    {if $mode == "edit"}
        {formbutton commandName="update" __text='Update ticket'}
        {formbutton commandName="delete" __text='Delete ticket' confirmMessage=$deleteConfirmMsg}
    {elseif $mode == "create"}
        {formbutton commandName="create" __text='Create ticket'}
    {else}
        {formbutton commandName="update" __text='OK'}
    {/if}
        {formbutton commandName="cancel" __text='Cancel'}
    </div>
  {/knowledgebaseFormFrame}
{/form}

</div>

{include file="KnowledgeBase_user_footer.tpl"}
