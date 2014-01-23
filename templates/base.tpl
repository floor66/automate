<!DOCTYPE html>
<html>
	<head>
		<title>Performance | {block name="page_title"}{/block}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="/static/img/favicon.ico" />
		<link href="/static/css/bootstrap.min.css" rel="stylesheet">
		<link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="/static/css/base.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		{block name="extra_css"}{/block}
		<script src="/static/js/jquery-2.0.3.min.js"></script>
		<script src="/static/js/jquery.tablesorter.min.js"></script>
	</head>
	<body>
		{if $smarty.template != "login.tpl"}
			{include file="nav.tpl"}
			{include file="modals.tpl"}
		{/if}
		<div class="container">
			{block name="container"}{/block}
		</div>
		{block name="extra_js"}{/block}
		<script src="/static/js/bootstrap.min.js"></script>
	</body>
</html>
