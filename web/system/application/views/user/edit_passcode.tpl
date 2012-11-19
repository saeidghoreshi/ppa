<link rel="stylesheet"
      href="{$config.base_url}css/profile-edit-passcode.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_profile">

{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

<div id="trans_wrap">
	<div id="header-left">
		<h1>Change Passcode</h1>
	</div>
    {* SUB NAVIGATION SECTION *}
    <div class="custom_report clearfix">
        <span class="custom_button">
            <span>
                <a href="{$site_url}/user/edit">
                    Edit
                </a>
            </span>
        </span>
    </div>
    <p>Please <a href="{$site_url}/info/contact">contact us</a> to change your password.</p>

    {* CHANGE PASSCODE SECTION *}
    <div class="passcode_info">
        {if true}
        <!--<h2>Please change Passcode from your phone</h2>-->
        {else}
        <h3>Change <small>your</small><br />Passcode</h3>

        <form action="{$site_url}/user/update_passcode"
              method="post" name="change_passcode_form">
            <div id="passcode-info">
                <table class="passcode_info">
                    <tr>
                        <td class="right">
                            <label for="passcode-1">Old Passcode:</label>
                        </td>
                        <td>
                            <input title="Old Passcode"
                                   type="password"
                                   name="{$smarty.const.FORM_OLD_PASSCODE}"
                                   value="" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="passcode-2">New Passcode:</label>
                        </td>
                        <td>
                            <input title="New Passcode"
                                   type="password"
                                   name="{$smarty.const.FORM_PASSCODE}"
                                   value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="passcode-3">Confirm New Passcode:</label>
                        </td>
                        <td>
                            <input title="Confirm New Passcode"
                                   type="password"
                                   name="{$smarty.const.FORM_CONFIRM_PASSCODE}"
                                   value="" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <a title="Cancel"
                               href="{$site_url}/user/">
                                Cancel
                            </a>
                            &nbsp;|&nbsp;
                            <input title="Save" type="submit"
                                   name="save" value="Save" />
                        </span>
                    </span>
                </div>
            </div>
        </form>
    {/if}
    </div>
</div>
