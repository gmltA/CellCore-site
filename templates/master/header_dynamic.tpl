<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{$title} - {$site.app_descr}</title>
		{if $keywords}
			<meta name="keywords" content="{$keywords}"/>
		{/if}
		{if $description}
			<meta name="description" content="{$description}"/>
		{/if}
		{if $robots}
			<meta name="robots" content="{$robots}"/>
		{/if}

		<meta name="generator" content="{$app_name} {$app_version}"/>
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/{$MainTemplateDir}/css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="/{$MainTemplateDir}/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/{$MainTemplateDir}/css/main.css">

        <script src="/{$MainTemplateDir}/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>