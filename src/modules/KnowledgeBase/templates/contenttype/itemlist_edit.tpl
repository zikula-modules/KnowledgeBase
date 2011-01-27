{* Purpose of this template: edit view of generic item list content type *}

<div class="z-adminformrow">
    {formlabel for='KnowledgeBase_objecttype' __text='Object type'}
    {knowledgebaseSelectorObjectTypes assign="allObjectTypes"}
    {formdropdownlist id='KnowledgeBase_objecttype' dataField='objectType' group='data' mandatory=true items=$allObjectTypes}
</div>

<div class="z-formrow">
    {formlabel __text='Sorting'}
    {formradiobutton id='KnowledgeBase_srandom' value='random' dataField='sorting' group='data' mandatory=true}
    {formlabel for='KnowledgeBase_srandom' __text='Random'}
    {formradiobutton id='KnowledgeBase_snewest' value='newest' dataField='sorting' group='data' mandatory=true}
    {formlabel for='KnowledgeBase_snewest' __text='Newest'}
    {formradiobutton id='KnowledgeBase_sdefault' value='default' dataField='sorting' group='data' mandatory=true}
    {formlabel for='KnowledgeBase_sdefault' __text='Default'}
</div>

<div class="z-formrow">
    {formlabel for='KnowledgeBase_amount' __text='Amount'}
    {formtextinput id='KnowledgeBase_amount' dataField='amount' group='data' mandatory=true maxLength=2}
</div>

<div class="z-formrow">
    {formlabel for='KnowledgeBase_template' __text='Template File'}
    {knowledgebaseSelectorTemplates assign="allTemplates"}
    {formdropdownlist id='KnowledgeBase_template' dataField='template' group='data' mandatory=true items=$allTemplates}
</div>

<div class="z-formrow">
    {formlabel for='KnowledgeBase_filter' __text='Filter (expert option)'}
    {formtextinput id='KnowledgeBase_filter' dataField='filter' group='data' mandatory=false maxLength=255}
    <div class="z-formnote">({gt text='Syntax examples'}: <kbd>name:like:foobar</kbd> {gt text='or'} <kbd>status:ne:3</kbd>)</div>
</div>
