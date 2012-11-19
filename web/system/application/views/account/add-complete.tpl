<link rel="stylesheet"
      href="{$config.base_url}css/account-complete.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">
<div id="trans_wrap">
	<div id="header-left">
		<h1>Account Created</h1>
	</div>
	<div id="header-right">
		&nbsp;
	</div>
	<div class="clear"></div>
	
    <div class="account_info">
		<p>You have successfully added an account!</p>
{if false}
        {* The below debug statements are for testing purposes *}
        <h2>Testing Bean Stream Response</h2>
        <br/>
        {if !empty($response)}
            Response
            <ul>
            {foreach from=$response key=k item=v}
                <li>{$k}: {$v}</li>
            {/foreach}
            </ul>
        {else}
            Bean Stream response not found.
        {/if}
{/if}
		
        <!--<a title="O.K." class="ok_button"
           href="{$site_url}/account#">Ok</a>-->
    </div>
    <br />
    <a class='button ok_button' id='submit-request' href="{$site_url}/account">OK</a>
</div>
