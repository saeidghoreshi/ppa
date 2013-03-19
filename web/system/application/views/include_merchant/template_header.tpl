<script type="text/javascript" src="{$config.base_url}js/header.js"></script>

<div id="header" class="clearfix">
    <h1 id="logo_merch" class="linline">
        <a href="{$config.base_url}merchant/payment/request_new" title="PayPhoneApp">Payphoneapp.com</a>
    </h1>
    {if $is_logged_in}
        <div class="panel_controls rinline_merch">
                {if !empty($smarty.session.user_firstname)}
                    Hello, {$smarty.session.user_firstname}!
		&nbsp;|&nbsp;
		{/if}
            <a href="{$site_url}/user/logout">Sign Out</a>
            &nbsp;|&nbsp;
            <a href="javascript:return false;">Manager</a>
            &nbsp;|&nbsp;
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
<div id="h_navigation" class="navigation_merch" style="margin: 0 0 0 300px;">
        <div class="inner">
                <ul class="clearfix">
                        <li><a id="h_invite" class="first" href="{$config.base_url}merchant/sms_twilio"><span><span class="i"><b>Invite</b></span></a></li>
                        <li><a id="h_request" href="{$config.base_url}merchant/payment/request_new"><span><span class="i"><b>Request Payment</b></span></span></a></li>
                        {if false}<li><a id="h_refill" href="{$config.base_url}merchant/payment/refill"><span><span class="i"><b>Refill GC</b></span></span></a></li>{/if}
                        <li class="last lower"><a id="h_receiptsmerch" class="last" href="{$config.base_url}merchant/transaction/recent"><span><span class="i"><b>Receipts</b></span></span></a></li>
                </ul>
        </div>
</div>
{else}
<div id="loggedout-header">
        &nbsp;
</div>
{/if}