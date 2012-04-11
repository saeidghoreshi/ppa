<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="{$config.meta_cotent}" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <title>{$config.title|strip_tags|escape}</title>
    <meta name="description"
          content="{$config.description|strip_tags|escape}" />
    <meta name="keywords" content="{$config.keywords|strip_tags|escape}" />
    <meta name="robots"
          content="{$config.meta_robots|default:$config.meta_defaultrobots}">
    <base href="{$config.base_url}">
    <link rel="stylesheet"
          href="{$config.base_url}css/general.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"
            type="text/javascript"></script>
    <script src="{$config.base_url}js/jquery.ezmark.min.js"
            type="text/javascript"></script>
    <script src="{$config.base_url}js/resizable-tables.js"
            type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="{$config.base_url}js/jquery-1.4.4.min.js"></script>
    <!--[if IE 6]>
	<script type="text/javascript" src="js/belatedpng.js"></script>
	<link rel="stylesheet" href="css/ie6.css" type="text/css" />
	<script type="text/javascript" src="js/ie6.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('a.view_rec, span.add_annotation, img, h1#logo_merch, th.flag');
	</script>
    <![endif]-->
    <!--[if IE 7]>
	<link rel="stylesheet" href="css/ie6.css" type="text/css" />
	<script type="text/javascript" src="js/ie6.js"></script>
    <![endif]-->
</head>