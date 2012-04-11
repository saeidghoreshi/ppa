<div class="custom_report clearfix">
    <div class="linline">
        <a class="custom_button"
           href="{$site_url}/account/add">
        <span>
            <img src="images/icon_plus.png" height="11" width="11"
                 alt="" />
            &nbsp;
            Add Account
        </span>
        </a>
    </div>
    {if empty($account) || empty($account.id)}
        <div class="rinline">
            <span class="custom_button">
                <span>
                    <a href="javascript:window.print();">Print</a>
{if false}
                    &nbsp;|&nbsp;
                    <a href="{$uri_string}#">Save</a>
                    &nbsp;|&nbsp;
                    <a href="{$uri_string}#">Export</a>
{/if}
                </span>
            </span>
        </div>
    {else}
        <div class="rinline">
            <span class="custom_button">
                <span>
                    <a href="{$site_url}/account/edit/{$account.id}">
                    Edit
                    </a>
                    &nbsp;|&nbsp;
                    <a href="{$uri_string}#">Delete</a>
                    &nbsp;|&nbsp;
                    <a href="{$site_url}/account/disable/{$account.id}">
                    Suspend
                    </a>
                </span>
            </span>
        </div>
    {/if}
</div>
