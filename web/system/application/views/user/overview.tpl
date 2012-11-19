<link rel="stylesheet" href="{$config.base_url}css/profile.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_profile">

<div id="trans_wrap">
	<div id="header-left">
		<h1>Profile Info</h1>
	</div>
	<div id="header-right">
    {* ADD/EDIT/DELETE/SUSPEND SECTION *}
    <div class="custom_report clearfix">
        <div class="linline">&nbsp;</div>
        <div class="rinline">
            <span class="custom_button">
                <span>
                    <a href="{$site_url}/user/edit">
                        Edit
                    </a>
                    &nbsp;|&nbsp;
                    <a href="{$site_url}/user/edit_passcode">
                        Change Passcode
                    </a>
                </span>
            </span>
        </div>
    </div>
    </div>

    {* INFO SECTION *}
    <div class="profile_info">
        <table class="profile_info">
            <tr>
                <td class="right">First Name:</td>
                <td>{$user.firstname|default:""}</td>
            </tr>
            <tr>
                <td class="right">Last Name:</td>
                <td>{$user.lastname|default:""}</td>
            </tr>
            <tr>
                <td class="right">Prefix:</td>
                <td>{$user.prefix|default:""}</td>
            </tr>
            <tr>
                <td class="right">Date of Birth:</td>
                <td>{if $user.dob ne '0000-00-00'}{$user.dob|default:''}{/if}</td>
            </tr>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="right">Street Address:</td>
                <td>{$user.street|default:""}</td>
            </tr>
            <tr>
                <td class="right">City:</td>
                <td>{$user.city|default:""}</td>
            </tr>
            <tr>
                <td class="right">State/Province:</td>
                <td>{$user.state|default:""}</td>
            </tr>
            <tr>
                <td class="right">Zip/Postal Code:</td>
                <td>{$user.zip|default:""}</td>
            </tr>
            <tr>
                <td class="right">Country:</td>
                <td>{$user.country|default:""}</td>
            </tr>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="right">Email:</td>
                <td>{$user.email}</td>
            </tr>
            <tr>
                <td class="right">Phone:</td>
                <td>{$user.phone}</td>
            </tr>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="right">Security Question 1:</td>
                <td>{$user.question1}</td>
            </tr>
            <tr>
                <td class="right">Security Answer 1:</td>
                <td>{"/./"|preg_replace:"*":$user.answer1}</td>
            </tr>
            <tr>
                <td class="right">Security Clue 1:</td>
                <td>{$user.clue1}</td>
            </tr>
            <tr>
                <td class="right">Security Question 2:</td>
                <td>{$user.question2}</td>
            </tr>
            <tr>
                <td class="right">Security Answer 2:</td>
                <td>{"/./"|preg_replace:"*":$user.answer2}</td>
            </tr>
            <tr>
                <td class="right">Security Clue 2:</td>
                <td>{$user.clue2}</td>
            </tr>
        </table>
    </div>
</div>
