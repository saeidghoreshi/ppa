<head>
    <meta http-equiv="Content-Type" content="{$config.meta_cotent}" />
    <meta charset="utf-8" />
    <title>{$config.title|strip_tags|escape}</title>
    <meta name="description" content="{$config.description|strip_tags|escape}" />
    <meta name="keywords" content="{$config.keywords|strip_tags|escape}" />
    <meta name="robots" content="{$config.meta_robots|default:$config.meta_defaultrobots}">
    <meta name="viewport" content="initial-scale=1.0; width=device-width; user-scalable=no">
    <base href="{$config.base_url}">
    <link rel="stylesheet" href="{$config.base_url}css/mobile/mobile.css" type="text/css">
</head>
