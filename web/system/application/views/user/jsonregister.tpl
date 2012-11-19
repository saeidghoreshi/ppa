<link rel="stylesheet"
      href="{$config.base_url}css/register.css" type="text/css" />

{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

<div id="trans_wrap">
    {* SUB NAVIGATION SECTION *}
    <div class="custom_report clearfix">
        <div class="linline">&nbsp;</div>
        <div class="rinline">&nbsp;</div>
    </div>

    <div class="register">
        <h3>Register <small>for</small><br />PayPhoneApp</h3>

        <form action="{$site_url}/user/create"
              method="post"
              name="register_form">
            <div id="profile-info">
                <table class="register">
                    <tr>
                        <td class="right">
                            <label for="register-1">Phone:</label>
                        </td>
                        <td>
                            <input title="Phone"
                                   type="text"
                                   name="{$smarty.const.FORM_PHONE}"
                                   value="" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="json"
                                   type="hidden"
                                   name="{$smarty.const.AJAX_JSON}"
                                   value="1" />
                            <input title="Sign Out"
                                   type="submit"
                                   value="Sign Out" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <h3>Test <small>for</small><br />PhoneGap Confirmation</h3>

        <form action="{$site_url}/user/confirm"
              method="post"
              name="confirm_form">
            <div id="profile-info">
                <table class="register">
                    <tr>
                        <td class="right">
                            <label for="register-1">Code:</label>
                        </td>
                        <td>
                            <input title="Token"
                                   type="text"
                                   name="{$smarty.const.FORM_TOKEN}"
                                   value="" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="json"
                                   type="hidden"
                                   name="{$smarty.const.AJAX_JSON}"
                                   value="1" />
                            <input title="Confirm"
                                   type="submit"
                                   value="Confirm" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <h3>Test <small>for</small><br />PhoneGap New Passcode</h3>

        <form action="{$site_url}/user/new_passcode"
              method="post"
              name="new_passcode_form">
            <div id="profile-info">
                <table class="register">
                    <tr>
                        <td class="right">
                            <label for="register-1">Passcode:</label>
                        </td>
                        <td>
                            <input title="Passcode"
                                   type="password"
                                   name="{$smarty.const.FORM_PASSCODE}"
                                   value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="register-2">Confirm Passcode:</label>
                        </td>
                        <td>
                            <input title="Confirm Passcode"
                                   type="password"
                                   name="{$smarty.const.FORM_CONFIRM_PASSCODE}"
                                   value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="register-3">Phone:</label>
                        </td>
                        <td>
                            <input title="Phone"
                                   type="text"
                                   name="{$smarty.const.FORM_PHONE}"
                                   value="" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="json"
                                   type="hidden"
                                   name="{$smarty.const.AJAX_JSON}"
                                   value="1" />
                            <input title="Save"
                                   type="submit"
                                   value="Save" />
                        </span>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
