{if $config.index_page eq 'messages'}
{include file='message/register.tpl'}
{else}
<link rel="stylesheet"
      href="{$config.base_url}css/register.css" type="text/css" />

<div id="trans_wrap">
    {* SUB NAVIGATION SECTION *}
    
    <div class="register">
	    <header role="banner">
			<img src="{$config.base_url}/images/logo_large.png" role="brand" alt="PayPhoneApp">
		</header>
	
		<div id="main" role="main">
			<h1>Help us test PayPhoneAPP</h1>
			<h2>in Gastown.</h2>
			<h3>Enter your email address and we will contact you!</h3>
			<form action="{$site_url}/user/create" method="post" name="register_form">
				<input title="Email" type="text" name="{$smarty.const.FORM_EMAIL}" placeholder="Email">
				{if $errors}
				    <div class="error">
				        {$errors}
				    </div>
				{/if}
				{* Phone field not implemented yet
				<input title="Phone" type="text" name="{$smarty.const.FORM_PHONE}" placeholder="Phone">
				*}
				<input title="Sign Up" type="submit" value="Sign Up">
				<a href="{$site_url}/user/login" id="signin-link">Sign In</a>
			</form>
		</div>
    </div>
</div>

<div class="push"></div>

<script src="{$config.base_url}js/v_center.js"></script>
{/if}

{include file='include/google_analytics.tpl'}
