{* purpose of this template: build the Form to edit an instance of ticket *}

{include file='user/header.tpl'}
{pageaddvar name='javascript' value='modules/KnowledgeBase/javascript/KnowledgeBase_editFunctions.js'}

{if $mode eq 'edit'}
    {gt text='Edit ticket' assign='templateTitle'}
{elseif $mode eq 'create'}
    {gt text='Create ticket' assign='templateTitle'}
{else}
    {gt text='Edit ticket' assign='templateTitle'}
{/if}

<div class="z-frontendcontainer">

{pagesetvar name='title' value=$templateTitle}
<h2>{$templateTitle}</h2>
<br />
{form cssClass='z-form'}

    {* add validation summary and a <div> element for styling the form *}
    {knowledgebaseFormFrame}
    {*formvalidationsummary*}
    {*formerrormessage id='error'*}

    {formsetinitialfocus inputId='subject'}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        <div class="z-formrow">
            {formlabel for='subject' __text='Subject' mandatorysym='1' class='knowledgebaseFormTooltips' title='This is the subject of this ticket, explaining the problem.'}
            {formtextinput group='ticket' id='subject' mandatory=true readOnly=false __title='Input the subject of the ticket' textMode='singleline' maxLength=255 cssClass='required'}
            {knowledgebaseValidationError id='subject' class='required'}
        </div>
        <div class="z-formrow">
            {formlabel for='content' __text='Content' mandatorysym='1' class='knowledgebaseFormTooltips' title='This content field describes the solution and/or instructions for the problem.'}
            {formtextinput group='ticket' id='content' mandatory=true __title='Input the content of the ticket' textMode='multiline' rows='6' cols='50' cssClass='required'}
            {knowledgebaseValidationError id='content' class='required'}
        </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='Category']--></legend>

        <div class="z-formrow">
            {formlabel for='category' __text='Category'}
        {foreach key='property' item='category' from=$categoryItems}
        {if isset($ticket.Categories)}
            {array_field_isset array=$ticket.Categories field=$property assign='catExists'}
            {if $catExists}
                {assign var='selectedValue' value=$ticket.Categories.$property}
            {else}
                {assign var='selectedValue' value='0'}
            {/if}
        {else}
            {assign var='selectedValue' value='0'}
        {/if}
            {formcategoryselector id=$property mandatory=true __title='Choose the category' category=$category enableDoctrine=true selectedValue=$selectedValue defaultValue='0' editLink=false}
        {/foreach}
        </div>
    </fieldset>
{if $mode ne 'create'}
    <fieldset>
        <legend>{gt text='Statistics'}</legend>

        <div class="z-formrow">
            {formlabel for='views' __text='Views'}
            {formintinput group='ticket' id='views' mandatory=false __title='Input the views of the ticket' maxLength=11 cssClass='validate-digits'}
            {knowledgebaseValidationError id='views' class='validate-digits'}
        </div>
        <div class="z-formrow">
            {formlabel for='ratesUp' __text='Rates up'}
            {formintinput group='ticket' id='ratesUp' mandatory=false __title='Input the rates up of the ticket' maxLength=4 cssClass='validate-digits'}
            {knowledgebaseValidationError id='ratesUp' class='validate-digits'}
        </div>
        <div class="z-formrow">
            {formlabel for='ratesDown' __text='Rates down'}
            {formintinput group='ticket' id='ratesDown' mandatory=false __title='Input the rates down of the ticket' maxLength=4 cssClass='validate-digits'}
            {knowledgebaseValidationError id='ratesDown' class='validate-digits'}
        </div>
    </fieldset>

        {include file='user/include_metadata_edit.tpl'}
    {/if}

    {if $mode eq 'create'}
        {notifydisplayhooks eventname='knowledgebase.hook.tickets.ui.edit' area='modulehook_area.knowledgebase.tickets' subject=null id=null caller='KnowledgeBase' assign='hooks'}
    {else}
        {notifydisplayhooks eventname='knowledgebase.hook.tickets.ui.edit' area='modulehook_area.knowledgebase.tickets' subject=$ticket id=$ticket.ticketid caller='KnowledgeBase' assign='hooks'}
    {/if}
    {if is_array($hooks) && isset($hooks[0])}
        <fieldset>
            <legend>{gt text='Hooks'}</legend>
            {foreach key='hookName' item='hook' from=$hooks}
            <div class="z-formrow">
                {$hook}
            </div>
            {/foreach}
        </fieldset>
    {/if}

    {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="z-formrow">
                {formlabel for='repeatcreation' __text='Create another item after save'}
                {formcheckbox group='ticket' id='repeatcreation' readOnly=false}
            </div>
        </fieldset>
    {/if}

    {gt text='Really delete this ticket?' assign="deleteConfirmMsg"}

    <div class="z-buttons z-formbuttons">
    {if $mode eq 'edit'}
        {formbutton id='btnUpdate' commandName='update' __text='Update ticket' class='z-bt-save'}
      {if !$inlineUsage}
        {formbutton id='btnDelete' commandName='delete' __text='Delete ticket' class='z-bt-delete' confirmMessage=$deleteConfirmMsg}
      {/if}
    {elseif $mode eq 'create'}
        {formbutton id='btnCreate' commandName='create' __text='Create ticket' class='z-bt-ok'}
    {else}
        {formbutton id='btnUpdate' commandName='update' __text='OK' class='z-bt-ok'}
    {/if}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}
    </div>
  {/knowledgebaseFormFrame}
{/form}

</div>

{img src='xedit.gif' modname='core' set='icons/extrasmall' assign='editImageArray'}
{img src='editdelete.gif' modname='core' set='icons/extrasmall' assign='removeImageArray'}

<script type="text/javascript">
/* <![CDATA[ */
    var editImage = '<img src="{{$editImageArray.src}}" width="16" height="16" alt="" />';
    var removeImage = '<img src="{{$removeImageArray.src}}" width="16" height="16" alt="" />';

    document.observe('dom:loaded', function() {

        var valid = new Validation('FormForm', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = valid.validate();
        {{/if}}

        $('{{if $mode eq 'create'}}btnCreate{{else}}btnUpdate{{/if}}').observe('click', function(event) {
            var result = valid.validate();
            if (!result) {
                Event.stop(event);
            }
            else {
                $$('div.z-formbuttons input').each(function(btn) {
                    btn.hide();
                });
            }
            return result;
        });

        Zikula.UI.Tooltips($$('.knowledgebaseFormTooltips'));
    });

/* ]]> */
</script>

{include file='user/footer.tpl'}
