<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">
<h2>Disable Account</h2>
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
{if !empty($disabled)}
    {if $disabled == 1}
        Account #{$id} has been disabled.
    {elseif $disabled == -1}
        Account #{$id} not found.
    {elseif $disabled == 2}
        Account #{$id} has already been disabled.
    {else}
        Account #{$id} could not be disabled.
    {/if}
{else}
    Disable process failed.
{/if}
