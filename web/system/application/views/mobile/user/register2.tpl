{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

<h2>Join PayPhoneAPP Today!</h2>
<form action='{$site_url}/user/create' method='post' name="login_form">
    <font face="Helvetica" size="2" color="#959595"><b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font>
    <input class='default-value' title='Email' type='text' name='email' value='' />
    <br />

    {* Phone field not implemented yet
    <font face="Helvetica" size="2" color="#959595"><b>Phone&nbsp;&nbsp;&nbsp;&nbsp;</b>&nbsp;</font>
    <input class='default-value' title='Phone Number' type='text' name='phone' value='' />
    <br />
    *}

    {* Passcode is not created at this point in the flow
    <font face="Helvetica" size="2" color="#959595"><b>Passcode</b></font>
    <input class='default-value' title='Passcode' type='password' name='passcode' value='' />
    <br />
    *}

    <input type='submit' class='button' value='Join Now' />
</form>
