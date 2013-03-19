<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--HTMLHEADER-->
    {include file="include_messages/template_htmlheader.tpl"}
    <!--END HTMLHEADER-->
    <body>
        <div id='wrap'>
            <div class='wrap'>
                <!--HEADER-->
                {include file="include_messages/template_header.tpl"}
                <!--END HEADER-->
                <!--BODY-->
                <div id="bodyContent">
                <div id="white"></div>
                {include file="$template.tpl"}
                </div>
                <!--FOOTER-->
		        {include file="include_messages/template_footer.tpl"}
		        <!--END FOOTER-->
                <!--END BODY-->
            </div>
        </div>
        <div id="bg-layer"></div>
    </body>
</html>
