<script type="text/javascript" src="{$config.base_url}js/header.js"></script>

<div id="header" class="clearfix">
    <h1 id="logo" class="linline">
        <a href="{$config.base_url}" title="PayPhoneApp">Payphoneapp.com</a>
    </h1>
    {if $is_logged_in}
        <div class="panel_controls rinline">
                {if !empty($smarty.session.user_firstname)}
                    Hello, {$smarty.session.user_firstname}!
		&nbsp;|&nbsp;
		{/if}
            <a href="{$site_url}/user/logout">Sign Out</a>
            &nbsp;|&nbsp;
            <!--<a href="#">Settings</a>
            &nbsp;|&nbsp;-->
            <a href="{$site_url}/info/contact">Help</a>
        </div>
    {else}
    	<div class="panel_controls rinline">
            <a href="{$site_url}/user/login">Sign In</a>
            &nbsp;|&nbsp;
            <a href="{$site_url}/user/register">Register</a>
            &nbsp;|&nbsp;
            <a href="{$site_url}/info/contact">Help</a>
        </div>
    {/if}
</div>

{if $is_logged_in}
<div id="h_navigation" class="navigation">
        <div class="inner">
                <ul class="clearfix">
                        <li><a id="h_overview" class="first" href="{$site_url}/summary"><span><span class="i"><b>Overview</b></span></a></li>
                        <li><a id="h_transaction" href="{$site_url}/transaction"><span><span class="i"><b>Receipts</b></span></span></a></li>
                        <li><a id="h_account" href="{$site_url}/account"><span><span class="i"><b>Accounts</b></span></span></a></li>
                        <li><a id="h_profile" href="{$site_url}/user"><span><span class="i"><b>Profile</b></span></span></a></li>
                        <li class="last lower"><a id="h_shops" class="last" href="{$site_url}/shops"><span><span class="i"><b>Shops &amp; Restaurants</b></span></span></a></li>
                </ul>
        </div>
</div>
{else}
<div id="loggedout-header">
        &nbsp;
</div>
{/if}
