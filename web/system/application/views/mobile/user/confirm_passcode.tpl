{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}
<h2>Almost Done!</h2>

    <p class='cta'>Please enter a passcode</p>

<form action='{$site_url}/user/new_passcode' method='post' name="login_form">
    <input class='default-value' title='Passcode' placeholder='Passcode' type='password' name='passcode' value='' />
    <br />

    <input class='default-value' title='Confirm Passcode' placeholder='Confirm Passcode' type='password' name='confirmpasscode' value='' />
    <br />
    <input type='hidden' name='email' value='{$email}' />

    <input type='submit' class='button wideButton' value='Save' />
</form>
