<link rel="stylesheet" href="{$config.base_url}css/register.css" type="text/css" />
{literal}
<style type="text/css">
<!--
#wrapper {border: none; padding: 20px;}
#wrap {}
-->
</style>
{/literal}
<div id="trans_wrap">
    {* SUB NAVIGATION SECTION *}
    
    <div class="register">
	    <header role="banner">
    		</header>
	
		<div id="main" role="main">
			<h1>Help us test the GoodList</h1>
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
			</form>
		</div>
    </div>
</div>

<div class="push"></div>

<script src="{$config.base_url}js/v_center.js"></script>