<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="index,follow"/>
	<meta charset="utf-8"/>
	<title>{$title} - RiverRise.net</title>
	{if $keywords}
		<meta name="keywords" content="{$keywords}"/>
	{/if}
	{if $description}
		<meta name="description" content="{$description}"/>
	{/if}
	<meta name="generator" content="{$site.app_name} {$app_version}"/>
	<script src="/{$MainTemplateDir}/js/jquery.min.js" type="text/javascript"></script>
	<script src="/{$MainTemplateDir}/js/jquery.easing.min.js" type="text/javascript"></script>
	<script src="/{$MainTemplateDir}/js/jquery.cellAPI.js" type="text/javascript"></script>
	{if $pageName == "news" || $pageName == "news_entry"}
		<script src="/{$MainTemplateDir}/js/news.js" type="text/javascript"></script>
	{/if}
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href="/{$MainTemplateDir}/style.css" rel="stylesheet" type="text/css" />
</head>
