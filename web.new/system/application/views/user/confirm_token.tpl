<link rel="stylesheet"
      href="{$config.base_url}css/register.css" type="text/css" />

{if $errors}
    <div class="error">
        {$errors}
    </div>
{else}
    {if empty($show_token_form) || !$show_token_form}
        <div id="trans_wrap">
		    <div class="register">
		    	<header role="banner">
					<img src="{$config.base_url}/images/logo_large.png" role="brand" alt="PayPhoneApp">
				</header>
				
				<div id="main" role="main">
					<div id="header-left"><h1>Create a Passcode</h1></div>
		    	    <div class="clear"></div>
		    	    <br />
		     	    <form action="{$site_url}/user/new_passcode" method="post" name="new_passcode_form">
			        	<label for="register-1" class="right">Passcode:</label>
		                <input title="Passcode"
		                       type="password"
		                       name="{$smarty.const.FORM_PASSCODE}"
		                       value="" />
			            <label for="register-2" class="right">Confirm Passcode:</label>
			            <input title="Confirm Passcode"
		                       type="password"
		                       name="{$smarty.const.FORM_CONFIRM_PASSCODE}"
		                       value="" />
		                    <span>
		                        <input type='hidden' name='email'
		                               value='{$email}' />
		                        <input title="Save"
		                               type="submit"
		                               value="Save" />
		                    </span>
			            </div>
			        </form>
				</div>
		    </div>
		</div>
    {/if}
{/if}

{if !empty($show_token_form)}
        <div id="trans_wrap">
            {* SUB NAVIGATION SECTION *}
            <div class="custom_report clearfix">
                <div class="linline">&nbsp;</div>
                <div class="rinline">&nbsp;</div>
            </div>

            <div class="register">
                <h3>Enter <small>Confirmation</small><br /> Code</h3>

                <form action="{$site_url}/user/confirm"
                      method="post"
                      name="token_form">
                    <div id="profile-info">
                        <table class="register">
                            <tr>
                                <td class="right">
                                    <label for="register-1">Confirmation Code</label>
                                </td>
                                <td>
                                    <input title="Confirmation Code"
                                           type="text"
                                           name="{$smarty.const.FORM_TOKEN}"
                                           value="" />
                                </td>
                            </tr>
                        </table>
                        <div class="actions">
                            <span class="custom_button">
                                <span>
                                    <input title="Confirm"
                                           type="submit"
                                           value="Confirm" />
                                </span>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
{/if}

<div class="push"></div>

<script src="{$config.base_url}js/v_center.js"></script>