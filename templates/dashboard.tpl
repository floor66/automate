{extends file="base.tpl"}

{block name="page_title"}Dashboard{/block}

{block name="extra_css"}
<link href="{$smarty.const.STATIC_FOLDER}/css/dashboard.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="jumbotron">
	<h1><i class="fa fa-bar-chart-o"></i> Dashboard</h1>
	<p>Welkom, {$voornaam}. Dit is het overzicht van {$smarty.now|date_format:"%e %B %Y"}.</p>
	<p>Het systeem bevat {$aantallen["klant"]} klanten, {$aantallen["auto"]} auto's en {$aantallen["product"]} producten.</p>
</div>
{/block}
