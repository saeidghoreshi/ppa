{if $errors}
    <div class="error">
        {$errors}
    </div>
{else}
    {if empty($show_token_form) || !$show_token_form}
        <h2>Almost Done</h2>
        <p class='cta'>Please enter a passcode</p>

        <form action='{$config.base_url}index.php/user/new_passcode' method='post' name="login_form">
            <input class='default-value' title='Passcode' placeholder='Passcode' type='password' name='passcode' value='' pattern="[0-9]+"/>
            <br />

            <input class='default-value' title='Confirm Passcode' placeholder='Confirm Passcode' type='password' name='confirmpasscode' value='' pattern="[0-9]+"/>
            <br />
            <input type='hidden' name='email' value='{$email}' type="email"/>

            <input type='submit' class='button wideButton' value='Save' />
        </form>
    {/if}
{/if}

{if !empty($show_token_form)}
    <h2>Confirmation</h2>
    <p class='cta'>Please enter your confirmation token</p>

    <form action='{$config.base_url}index.php/user/confirm' method='post' name="token_form">
        <input class='default-value' placeholder='Confirmation Token' title='Token' type='text' name='token' value='' pattern="[0-9]+"/>
        <br />
        <input type='submit' class='button wideButton' value='Confirm' />
    </form>
{/if}
