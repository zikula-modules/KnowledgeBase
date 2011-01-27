{if (isset($cr_uid) && $cr_uid) || (isset($lu_uid) && $lu_uid)}
<fieldset>
    <legend>{gt text='Meta data'}</legend>
    <ul>
{if isset($cr_uid) && $cr_uid}
        {usergetvar name='uname' uid=$cr_uid assign='username'}
        <li>{gt text='Created by %s' tag1=$username}</li>
        <li>{gt text='Created on %s' tag1=$cr_date|dateformat}</li>
{/if}
{if isset($lu_uid) && $lu_uid}
        {usergetvar name='uname' uid=$lu_uid assign='username'}
        <li>{gt text='Updated by %s' tag1=$username}</li>
        <li>{gt text='Updated on %s' tag1=$lu_date|dateformat}</li>
{/if}
    </ul>
</fieldset>
{/if}
