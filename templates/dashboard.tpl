{extends file="base.tpl"}

{block name="page_title"}Dashboard{/block}

{block name="more_css"}
<link href="/static/css/dashboard.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="jumbotron">
	<h1><i class="fa fa-bar-chart-o"></i> Dashboard</h1>
	<p>Welkom, {$naam}. Dit is het overzicht van {$vandaag}.</p>
</div>
{/block}
