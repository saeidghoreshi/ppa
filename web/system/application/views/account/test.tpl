<h2>Bean Stream Response</h2>
<br/>
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
