{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

{if !$is_logged_in}
<h2>Login</h2>
    <form action='{$site_url}/user/login' method='post' name="login_form">
        <input class='default-value' placeholder='Email' title='Email' type='email' name='email' value='' />
        <br />

        <input class='default-value' placeholder='Passcode' title='Passcode' type='password' name='passcode' value='' />
        <br />

        <input type='submit' class='button wideButton' value='Login' />
    </form>
    <br/>
    Not registered yet?
    <a href="{$site_url}/user/register">Sign up!</a>
{else}
    <h3>&nbsp;</h3>
    You are already logged in.
    <br/>
    <a href="{$site_url}/user/">View your profile</a>
{/if}
