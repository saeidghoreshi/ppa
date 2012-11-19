<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--HTMLHEADER-->
    {include file="include_merchant/template_htmlheader.tpl"}
    <!--END HTMLHEADER-->
    <body>
        <div id='wrap_merch'>
            <div class='wrap'>
                <!--HEADER-->
                {include file="include_merchant/template_header.tpl"}
                <!--END HEADER-->
                <!--BODY-->
                {if $template ne 'user/register' and $template ne 'user/create' and $template ne 'user/confirm_email' and $template ne 'user/login' and $template ne 'login' and $template ne 'user/confirm_passcode' and $template ne 'user/confirm_token'}<div id="bodyContent_merch">
                <div id="white_merch"></div>{/if}
                {include file="$template.tpl"}
                {if $template ne 'user/register' and $template ne 'user/create' and $template ne 'user/confirm_email' and $template ne 'user/login' and $template ne 'login' and $template ne 'user/confirm_passcode' and $template ne 'user/confirm_token'}</div>{/if}
                <!--END BODY-->
            </div>
        </div>
        <div id="bg-layer"></div>
        <!--FOOTER-->
        {include file="include_merchant/template_footer.tpl"}
        <!--END FOOTER-->
    </body>
</html>
