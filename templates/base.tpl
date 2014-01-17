<!DOCTYPE html>
<html>
	<head>
		<title>Performance | {block name="page_title"}{/block}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="img/favicon.ico" />
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="css/base.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		{block name="more_css"}{/block}
		<script src="js/jquery-2.0.3.min.js"></script>
	</head>
	<body>
		{if $nav}
			{include file="nav.tpl"}
		{/if}
		<div class="container">
			{block name="container"}{/block}
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
