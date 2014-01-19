{extends file="base.tpl"}

{block name="page_title"}Beheren{/block}

{block name="more_css"}
<link href="/static/css/beheren.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
	{if isset($weergave_instellingen)}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-wrench"></i> {$categorie} <small>Beheren</small></h2></div>
		<div class="panel-body">
			{if isset($bericht)}
			<div class="alert alert-{if $bericht.type == 'fout'}danger{else}success{/if} alert-dismissable text-center">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{$bericht.text}
			</div>
			{/if}
			Kies hier welke kolummen u wil laten zien in het overzicht voor <strong>{$categorie}</strong>.
		</div>
		<form method="post" action="/automate/{$smarty.get.cat}/beheren/">
			<ul style="list-style-type: none;">
			{foreach $weergave_instellingen as $k => $v}
				<li><label><input type="checkbox" name="{$k}" value="{$v}"{if $v == 1} checked{/if}{if $k == "{$smarty.get.cat}_id"} disabled{/if} /> <strong>{$k}</strong></label></li>
			{/foreach}
			</ul>
			<input type="submit" name="opslaan" class="btn btn-lg btn-primary btn-block" id="opslaan" value="Opslaan" />
		</form>
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
