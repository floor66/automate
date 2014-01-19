{extends file="base.tpl"}

{block name="page_title"}Beheren{/block}

{block name="more_css"}
<link href="/static/css/beheren.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
	{if $weergave_instellingen}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-bars"></i> {$categorie} <small>Beheren</small></h2></div>
		<div class="panel-body">
			Kies hier welke kolummen u wil laten zien in het overzicht voor <strong>{$categorie}</strong>.
		</div>
		<table class="table">
			<th>Kolom</th><th>Weergeven?</th>
		{foreach $weergave_instellingen as $k => $v}
			<tr><td>{$k}</td><td><input type="checkbox" name="test" value="{$v}" {if $v == 1}checked{/if} /></td></tr>
		{/foreach}
		</table>
		<button class="btn btn-lg btn-primary btn-block" id="opslaan">Opslaan</button>
	</div>
	{else}
	<div class="panel panel-danger">
		<div class="panel-heading"><h3><i class="fa fa-exclamation-triangle"></i> Kritieke fout</h3></div>
		<div class="panel-body">
			<p>Er zijn geen instellingen gevonden voor <strong>'{$categorie}'</strong>. Raadpleeg de systeembeheerder.</p>
		</div>
	</div>
	{/if}
</div>
{/block}
