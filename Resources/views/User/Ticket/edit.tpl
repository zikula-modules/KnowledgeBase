{* purpose of this template: build the Form to edit an instance of ticket *}
{include file='User/header.tpl'}
{pageaddvar name='javascript' value='modules/GuiteKnowledgeBaseModule/Resources/public/js/GuiteKnowledgeBaseModule_editFunctions.js'}
{pageaddvar name='javascript' value='modules/GuiteKnowledgeBaseModule/Resources/public/js/GuiteKnowledgeBaseModule_validation.js'}

{if $mode eq 'edit'}
    {gt text='Edit ticket' assign='templateTitle'}
{elseif $mode eq 'create'}
    {gt text='Create ticket' assign='templateTitle'}
{else}
    {gt text='Edit ticket' assign='templateTitle'}
{/if}
<div class="guiteknowledgebasemodule-ticket guiteknowledgebasemodule-edit">
    {pagesetvar name='title' value=$templateTitle}
    <h2>{$templateTitle}</h2>
{form cssClass='form-horizontal' role='form'}
    {* add validation summary and a <div> element for styling the form *}
    {guiteknowledgebasemoduleFormFrame}
    {formsetinitialfocus inputId='subject'}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        
        <div class="form-group">
            {gt text='This is the subject of this ticket, explaining the problem.' assign='toolTip'}
            {formlabel for='subject' __text='Subject' mandatorysym='1' cssClass='guiteknowledgebasemodule-form-tooltips col-lg-3 control-label' title=$toolTip}
            <div class="col-lg-9">
            {formtextinput group='ticket' id='subject' mandatory=true readOnly=false __title='Enter the subject of the ticket' textMode='singleline' maxLength=255 cssClass='form-control required' }
            </div>
            {guiteknowledgebasemoduleValidationError id='subject' class='required'}
        </div>
        
        <div class="form-group">
            {gt text='This content field describes the solution and/or instructions for the problem.' assign='toolTip'}
            {formlabel for='content' __text='Content' mandatorysym='1' cssClass='guiteknowledgebasemodule-form-tooltips col-lg-3 control-label' title=$toolTip}
            <div class="col-lg-9">
            {formtextinput group='ticket' id='content' mandatory=true __title='Enter the content of the ticket' textMode='multiline' rows='6' cssClass='form-control required' }
            </div>
            {guiteknowledgebasemoduleValidationError id='content' class='required'}
        </div>
    </fieldset>
{if $mode ne 'create'}
    <fieldset>
        <legend>{gt text='Statistics'}</legend>

        <div class="form-group">
            {formlabel for='views' __text='Views' cssClass=' col-lg-3 control-label'}
            <div class="col-lg-9">
            {formintinput group='ticket' id='views' mandatory=false __title='Enter the views of the ticket' maxLength=11 cssClass='form-control  validate-digits' }
            </div>
            {guiteknowledgebasemoduleValidationError id='views' class='validate-digits'}
        </div>
        
        <div class="form-group">
            {formlabel for='ratesUp' __text='Rates up' cssClass=' col-lg-3 control-label'}
            <div class="col-lg-9">
            {formintinput group='ticket' id='ratesUp' mandatory=false __title='Enter the rates up of the ticket' maxLength=4 cssClass='form-control  validate-digits' }
            </div>
            {guiteknowledgebasemoduleValidationError id='ratesUp' class='validate-digits'}
        </div>
        
        <div class="form-group">
            {formlabel for='ratesDown' __text='Rates down' cssClass=' col-lg-3 control-label'}
            <div class="col-lg-9">
            {formintinput group='ticket' id='ratesDown' mandatory=false __title='Enter the rates down of the ticket' maxLength=4 cssClass='form-control  validate-digits' }
            </div>
            {guiteknowledgebasemoduleValidationError id='ratesDown' class='validate-digits'}
        </div>
    </fieldset>
{/if}
    
    {include file='User/include_categories_edit.tpl' obj=$ticket groupName='ticketObj'}
    {if $mode ne 'create'}
        {include file='User/include_standardfields_edit.tpl' obj=$ticket}
    {/if}
    
    {* include display hooks *}
    {if $mode ne 'create'}
        {assign var='hookId' value=$ticket.id}
        {notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.form_edit' id=$hookId assign='hooks'}
    {else}
        {notifydisplayhooks eventname='knowledgebase.ui_hooks.tickets.form_edit' id=null assign='hooks'}
    {/if}
    {if is_array($hooks) && count($hooks)}
        {foreach key='providerArea' item='hook' from=$hooks}
            <fieldset>
                {$hook}
            </fieldset>
        {/foreach}
    {/if}
    
    {* include return control *}
    {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="form-group">
                {formlabel for='repeatCreation' __text='Create another item after save' cssClass='col-lg-3 control-label'}
            <div class="col-lg-9">
                    {formcheckbox group='ticket' id='repeatCreation' readOnly=false}
            </div>
            </div>
        </fieldset>
    {/if}
    
    {* include possible submit actions *}
    <div class="form-group form-buttons">
    <div class="col-lg-offset-3 col-lg-9">
    {foreach item='action' from=$actions}
        {assign var='actionIdCapital' value=$action.id|@ucwords}
        {gt text=$action.title assign='actionTitle'}
        {*gt text=$action.description assign='actionDescription'*}{* TODO: formbutton could support title attributes *}
        {if $action.id eq 'delete'}
            {gt text='Really delete this ticket?' assign='deleteConfirmMsg'}
            {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class=$action.buttonClass confirmMessage=$deleteConfirmMsg}
        {else}
            {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class=$action.buttonClass}
        {/if}
    {/foreach}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='btn btn-default'}
    </div>
    </div>
    {/guiteknowledgebasemoduleFormFrame}
{/form}
</div>
{include file='User/footer.tpl'}

{assign var='editImage' value='<span class="fa fa-pencil-square-o"></span>'}
{assign var='deleteImage' value='<span class="fa fa-trash-o"></span>'}


<script type="text/javascript">
/* <![CDATA[ */

    var formButtons, formValidator;

    function handleFormButton (event) {
        var result = formValidator.validate();
        if (!result) {
            // validation error, abort form submit
            Event.stop(event);
        } else {
            // hide form buttons to prevent double submits by accident
            formButtons.each(function (btn) {
                btn.addClassName('hide');
            });
        }

        return result;
    }

    document.observe('dom:loaded', function() {

        kbaseAddCommonValidationRules('ticket', '{{if $mode ne 'create'}}{{$ticket.id}}{{/if}}');
        {{* observe validation on button events instead of form submit to exclude the cancel command *}}
        formValidator = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = formValidator.validate();
        {{/if}}

        formButtons = $('{{$__formid}}').select('div.form-buttons input');

        formButtons.each(function (elem) {
            if (elem.id != 'btnCancel') {
                elem.observe('click', handleFormButton);
            }
        });

        Zikula.UI.Tooltips($$('.guiteknowledgebasemodule-form-tooltips'));
    });

/* ]]> */
</script>
