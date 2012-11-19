<link rel="stylesheet"
      href="{$config.base_url}css/login.css" type="text/css" />

<div id="trans_wrap">
    {* SUB NAVIGATION SECTION *}

    {if !$is_logged_in}
        {if empty($passphrase_question)}
        	
        	<div class="login">
				<header role="banner">
					<img src="{$config.base_url}images/logo_large.png" role="brand" alt="PayPhoneApp">
				</header>
		
				<div id="main" role="main">
					<h1>Welcome to PayPhoneAPP! - MESSAGES</h1>
					<h2>Please sign in.</h2>
					<form action="{$site_url}/user/login" method="post" name="login_form">
                                            {if $config.index_page eq 'merchant'}
						<input title="Phone Number" type="text" name="{$smarty.const.FORM_PHONE}" placeholder="Phone Number">
                                            {else}
						<input title="Email" type="text" name="{$smarty.const.FORM_EMAIL}" placeholder="Email">
                                            {/if}
						<input title="Passcode" type="password" name="{$smarty.const.FORM_PASSCODE}" placeholder="Passcode">
						{if $errors}
						    <div class="error">
						        {$errors}
						    </div>
						{/if}
						<input title="Sign In" type="submit" value="Sign In">
						<a href="{$site_url}/user/register" id="signup-link">Sign Up for the beta</a>
					</form>
				</div>
			</div>
        {else}
            <div class="login">
				<header role="banner">
					<img src="{$config.base_url}images/logo_large.png" role="brand" alt="PayPhoneApp">
				</header>
				
				<div id="main" role="main">
                <h1>Verify your passphrase</h1>
	                <form action="{$site_url}/user/passphrase" method="post" name="passphrase_form">
	                    	<p>{$passphrase_question}</p>
							<input title="Question" type="hidden" readonly="" name="{$smarty.const.FORM_PASSPHRASE_QUESTION}" value="{$passphrase_question}" />
							<input title="Answer" type="password" name="{$smarty.const.FORM_PASSPHRASE_ANSWER}" value="" autofocus />
							<input type="hidden" name="{$smarty.const.FORM_PASSPHRASE_SELECTED}" value="{$selected_index}" />
							<input type="hidden" name="{$smarty.const.FORM_ENTITY_ID}" value="{$id}" />
							{if $errors}
							    <div class="error">
							        {$errors}
							    </div>
							{/if}
							<input title="confirm" type="submit" value="Confirm" />
	                </form>
                </div>
            </div>
        {/if}
    {else}
        <h3>&nbsp;</h3>
        You are already logged in.

        <form action="{$site_url}/user"
              method="post"
              name="profile_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Profile JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Profile"
                                   type="submit"
                                   value="Profile" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="{$site_url}/account"
              method="post"
              name="account_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Accounts JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Accounts"
                                   type="submit"
                                   value="Accounts" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="{$site_url}/account/info/35"
              method="post"
              name="account_info_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Account Info JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Account Info"
                                   type="submit"
                                   value="Account Info" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="{$site_url}/account/info/35"
              method="post"
              name="account_info_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Account Info JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Account Info"
                                   type="submit"
                                   value="Account Info" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="{$site_url}/transaction/info"
              method="post"
              name="account_info_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Receipt Info JSON View</label>
                        </td>
                        <td>
                            <input title="Transaction"
                                   type="text"
                                   name="{$smarty.const.FORM_ENTITY_ID}"
                                   value="" />
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Receipt Info"
                                   type="submit"
                                   value="Receipt Info" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="{$site_url}/transaction"
              method="post"
              name="transactions_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Receipt List JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Receipts"
                                   type="submit"
                                   value="Receipts" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

    {/if}
</div>

<div class="push"></div>

<script src="{$config.base_url}js/v_center.js"></script>