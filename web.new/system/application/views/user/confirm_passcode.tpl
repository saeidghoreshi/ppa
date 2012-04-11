<link rel="stylesheet"
      href="{$config.base_url}css/register.css" type="text/css" />

{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

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

<script src="{$config.base_url}js/v_center.js"></script>