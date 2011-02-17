{if (isset($obj.cr_uid) && $obj.cr_uid) || (isset($obj.lu_uid) && $obj.lu_uid)}
    <dt>{gt text='Meta data'}</dt>
{if isset($obj.cr_uid) && $obj.cr_uid}
    {usergetvar name='uname' uid=$obj.cr_uid assign='cr_uname'}
    {if $modvars.ZConfig.profilemodule ne ''}
        {modurl modname=$modvars.ZConfig.profilemodule func='view' uname=$cr_uname assign='profileLink'}
        {assign var='profileLink' value=$profileLink|safetext}
        {assign var='profileLink' value="<a href=\"`$profileLink`\">`$cr_uname`</a>"}
    {else}
        {assign var='profileLink' value=$cr_uname}
    {/if}
    <dd>{gt text='Created by %1$s on %2$s' tag1=$profileLink tag2=$obj.cr_date|dateformat html=true}</dd>
{/if}
{if isset($obj.lu_uid) && $obj.lu_uid}
    {usergetvar name='uname' uid=$obj.lu_uid assign='lu_uname'}
    {if $modvars.ZConfig.profilemodule ne ''}
        {modurl modname=$modvars.ZConfig.profilemodule func='view' uname=$lu_uname assign='profileLink'}
        {assign var='profileLink' value=$profileLink|safetext}
        {assign var='profileLink' value="<a href=\"`$profileLink`\">`$lu_uname`</a>"}
    {else}
        {assign var='profileLink' value=$lu_uname}
    {/if}
    <dd>{gt text='Updated by %1$s on %2$s' tag1=$profileLink tag2=$obj.lu_date|dateformat html=true}</dd>
{/if}
{/if}
