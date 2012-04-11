<link rel="stylesheet"
      href="{$config.base_url}css/profile-edit.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_profile">

{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

<div id="trans_wrap">
	<div id="header-left">
        <h1>Edit Profile</h1>
	</div>
	<div id="header-right">
    <div class="custom_report clearfix">
            <span class="custom_button">
                <span>
                    <a href="{$site_url}/user/edit_passcode">
                        Change Passcode
                    </a>
                </span>
            </span>
        </div>
    </div>


    {* INFO SECTION *}
    <div class="profile_info">
        <form action="{$site_url}/user/update"
              method="post" name="update_profile_form">
            <div id="profile-info">
                <table class="profile_info">
                    <tr>
                        <td class="right">
                            <label for="profile-1">First Name*:</label>
                        </td>
                        <td>
                            <input title="First Name"
                                   type="text"
                                   name="{$smarty.const.FORM_FIRSTNAME}"
                                   value="{$user.firstname}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-2">Last Name*:</label>
                        </td>
                        <td>
                            <input title="Last Name"
                                   type="text"
                                   name="{$smarty.const.FORM_LASTNAME}"
                                   value="{$user.lastname}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-3">Prefix:</label>
                        </td>
                        <td class="select">
                            <select title="Prefix"
                                    name="{$smarty.const.FORM_PREFIX}">
                                <option value="Mr." {if $user.prefix == 'Mr.'}selected{/if}>Mr.</option>
                                <option value="Ms." {if $user.prefix == 'Ms.'}selected{/if}>Ms.</option>
                                <option value="Mrs." {if $user.prefix == 'Mrs.'}selected{/if}>Mrs.</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-4">Date of Birth:</label>
                        </td>
                        <td>
                            <input title="Date of Birth"
                                   type="text"
                                   name="{$smarty.const.FORM_DOB}"
                                   value="{$user.dob}" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-5">Street Address*:</label>
                        </td>
                        <td>
                            <input title="Street Address"
                                   type="text"
                                   name="{$smarty.const.FORM_ADDRESS_STREET}"
                                   value="{$user.street}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-6">City*:</label>
                        </td>
                        <td>
                            <input title="City"
                                   type="text"
                                   name="{$smarty.const.FORM_ADDRESS_CITY}"
                                   value="{$user.city}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-7">State/Province*:</label>
                        </td>
                        <td>
                            <input title="State or Province"
                                   type="text"
                                   name="{$smarty.const.FORM_ADDRESS_STATE}"
                                   value="{$user.state}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Zip/Postal Code*:</label>
                        </td>
                        <td>
                            <input title="Zip or Postal Code"
                                   type="text"
                                   name="{$smarty.const.FORM_ADDRESS_ZIP}"
                                   value="{$user.zip}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-9">Country*:</label>
                        </td>
                        <td>
                            <input title="Country"
                                   type="text"
                                   name="{$smarty.const.FORM_ADDRESS_COUNTRY}"
                                   value="{$user.country}" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-10">Email*:</label>
                        </td>
                        <td>
                            <input title="Email"
                                   type="text"
                                   name="{$smarty.const.FORM_EMAIL}"
                                   value="{$user.email}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-11">Phone*:</label>
                        </td>
                        <td>
                            <input title="Phone"
                                   type="text"
                                   name="{$smarty.const.FORM_PHONE}"
                                   value="{$user.phone}" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-12">Security Question 1*:</label>
                        </td>
                        <td>
                            <input title="Security Question 1"
                                   type="text"
                                   name="{$smarty.const.FORM_PASSPHRASE_1_QUESTION}"
                                   value="{$user.question1}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-13">Security Answer 1*:</label>
                        </td>
                        <td>
                            <input title="Security Answer 1"
                                   type="password"
                                   name="{$smarty.const.FORM_PASSPHRASE_1_ANSWER}"
                                   value="{$user.answer1}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-14">Security Clue 1*:</label>
                        </td>
                        <td>
                            <input title="Security Clue 1"
                                   type="text"
                                   name="{$smarty.const.FORM_PASSPHRASE_1_CLUE}"
                                   value="{$user.clue1}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-15">Security Question 2:</label>
                        </td>
                        <td>
                            <input title="Security Question 2"
                                   type="text"
                                   name="{$smarty.const.FORM_PASSPHRASE_2_QUESTION}"
                                   value="{$user.question2}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-16">Security Answer 2:</label>
                        </td>
                        <td>
                            <input title="Security Answer 2"
                                   type="password"
                                   name="{$smarty.const.FORM_PASSPHRASE_2_ANSWER}"
                                   value="{$user.answer2}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-17">Security Clue 2:</label>
                        </td>
                        <td>
                            <input title="Security Clue 2"
                                   type="text"
                                   name="{$smarty.const.FORM_PASSPHRASE_2_CLUE}"
                                   value="{$user.clue2}" />
                        </td>
                    </tr>
                    * Required
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
    </div>
</div>
