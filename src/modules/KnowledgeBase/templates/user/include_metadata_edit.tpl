{if (isset($obj.cr_uid) && $obj.cr_uid) || (isset($obj.lu_uid) && $obj.lu_uid)}
<fieldset>
    <legend>{gt text='Meta data'}</legend>
    <ul>
{if isset($obj.cr_uid) && $obj.cr_uid}
        {usergetvar name='uname' uid=$obj.cr_uid assign='username'}
        <li>{gt text='Created by %s' tag1=$username}</li>
        <li>{gt text='Created on %s' tag1=$obj.cr_date|dateformat}</li>
{/if}
{if isset($obj.lu_uid) && $obj.lu_uid}
        {usergetvar name='uname' uid=$obj.lu_uid assign='username'}
        <li>{gt text='Updated by %s' tag1=$username}</li>
        <li>{gt text='Updated on %s' tag1=$obj.lu_date|dateformat}</li>
{/if}
    </ul>
</fieldset>
{/if}
