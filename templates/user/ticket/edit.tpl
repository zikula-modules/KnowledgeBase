{* purpose of this template: build the Form to edit an instance of ticket *}
{include file='user/header.tpl'}
{pageaddvar name='javascript' value='modules/KnowledgeBase/javascript/KnowledgeBase_editFunctions.js'}
{pageaddvar name='javascript' value='modules/KnowledgeBase/javascript/KnowledgeBase_validation.js'}

{if $mode eq 'edit'}
    {gt text='Edit ticket' assign='templateTitle'}
{elseif $mode eq 'create'}
    {gt text='Create ticket' assign='templateTitle'}
{else}
    {gt text='Edit ticket' assign='templateTitle'}
{/if}
<div class="knowledgebase-ticket knowledgebase-edit">
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>
{form cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {knowledgebaseFormFrame}
    {formsetinitialfocus inputId='subject'}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        <div class="z-formrow">
            {gt text='This is the subject of this ticket, explaining the problem.' assign='toolTip'}
            {formlabel for='subject' __text='Subject' mandatorysym='1' class='knowledgebaseFormTooltips' title=$toolTip}
            {formtextinput group='ticket' id='subject' mandatory=true readOnly=false __title='Enter the subject of the ticket' textMode='singleline' maxLength=255 cssClass='required'}
            {knowledgebaseValidationError id='subject' class='required'}
        </div>
        <div class="z-formrow">
            {gt text='This content field describes the solution and/or instructions for the problem.' assign='toolTip'}
            {formlabel for='content' __text='Content' mandatorysym='1' class='knowledgebaseFormTooltips' title=$toolTip}
            {formtextinput group='ticket' id='content' mandatory=true __title='Enter the content of the ticket' textMode='multiline' rows='6' cols='50' cssClass='required'}
            {knowledgebaseValidationError id='content' class='required'}
        </div>
    </fieldset>
{if $mode ne 'create'}
    <fieldset>
        <legend>{gt text='Statistics'}</legend>

        <div class="z-formrow">
            {formlabel for='views' __text='Views'}
            {formintinput group='ticket' id='views' mandatory=false __title='Enter the views of the ticket' maxLength=11 cssClass='validate-digits'}
            {knowledgebaseValidationError id='views' class='validate-digits'}
        </div>
        <div class="z-formrow">
            {formlabel for='ratesUp' __text='Rates up'}
            {formintinput group='ticket' id='ratesUp' mandatory=false __title='Enter the rates up of the ticket' maxLength=4 cssClass='validate-digits'}
            {knowledgebaseValidationError id='ratesUp' class='validate-digits'}
        </div>
        <div class="z-formrow">
            {formlabel for='ratesDown' __text='Rates down'}
            {formintinput group='ticket' id='ratesDown' mandatory=false __title='Enter the rates down of the ticket' maxLength=4 cssClass='validate-digits'}
            {knowledgebaseValidationError id='ratesDown' class='validate-digits'}
        </div>
    </fieldset>

    {/if}

    {include file='user/include_categories_edit.tpl' obj=$ticket groupName='ticketObj'}
    {if $mode ne 'create'}
        {include file='user/include_standardfields_edit.tpl' obj=$ticket}
    {/if}

    {* include display hooks *}
    {if $mode eq 'create'}
        {notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.form_edit' id=null assign='hooks'}
    {else}
        {notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.form_edit' id=$ticket.id assign='hooks'}
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

    {* include return control *}
    {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="z-formrow">
                {formlabel for='repeatcreation' __text='Create another item after save'}
                {formcheckbox group='ticket' id='repeatcreation' readOnly=false}
            </div>
        </fieldset>
    {/if}

    {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
    {if $mode eq 'edit'}
        {formbutton id='btnUpdate' commandName='update' __text='Update ticket' class='z-bt-save'}
      {if !$inlineUsage}
        {gt text='Really delete this ticket?' assign='deleteConfirmMsg'}
        {formbutton id='btnDelete' commandName='delete' __text='Delete ticket' class='z-bt-delete z-btred' confirmMessage=$deleteConfirmMsg}
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
</div>
{include file='user/footer.tpl'}

{icon type='edit' size='extrasmall' assign='editImageArray'}
{icon type='delete' size='extrasmall' assign='deleteImageArray'}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    var editImage = '<img src="{{$editImageArray.src}}" width="16" height="16" alt="" />';
    var removeImage = '<img src="{{$deleteImageArray.src}}" width="16" height="16" alt="" />';

    document.observe('dom:loaded', function() {

        kbaseAddCommonValidationRules('ticket', '{{if $mode eq 'create'}}{{else}}{{$ticket.id}}{{/if}}');

        // observe button events instead of form submit
        var valid = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
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
