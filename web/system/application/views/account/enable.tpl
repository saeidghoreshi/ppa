<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">
<h2>Enable Account</h2>
<br/>
<br/>
{if !empty($response)}
    <h3>Bean Stream Response</h3>
    <ul>
    {foreach from=$response key=k item=v}
        <li>{$k}: {$v}</li>
    {/foreach}
    </ul>
{else}
    Bean Stream response not found.
{/if}
<br/>
{if !empty($enabled)}
    {if $enabled == 1}
        Account #{$id} has been enabled.
    {elseif $enabled == -1}
        Account #{$id} not found.
    {elseif $enabled == 2}
        Account #{$id} has already been enabled.
    {else}
        Account #{$id} could not be enabled.
    {/if}
{else}
    Enable process failed.
{/if}
