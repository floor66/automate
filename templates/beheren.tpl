{extends file="base.tpl"}

{block name="page_title"}Beheren{/block}

{block name="extra_css"}
<link href="{$smarty.const.STATIC_FOLDER}/css/beheren.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
	{if isset($data.weergave_instellingen)}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-wrench"></i> {$data.categorie|capitalize} <small>Beheren</small></h2></div>
		<div class="panel-body">
			{if isset($data.bericht)}
			<div class="alert alert-{if $data.bericht.type == 'fout'}danger{else}success{/if} alert-dismissable text-center">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{$data.bericht.text}
			</div>
			{/if}
			Kies hier welke kolummen u wil laten zien in het overzicht/de zoekresultaten voor <strong>{$data.categorie|capitalize}</strong>.
		</div>
		<form method="post" action="/automate/{$smarty.get.cat}/beheren/">
			<ul style="list-style-type: none;">
			{foreach $data.weergave_instellingen as $kolom => $status}
				<li><label><input type="checkbox" name="{$kolom}" value="{$status}"{if $status == 1} checked{/if}{if $kolom == "{$data.categorie}_id"} disabled{/if} /> <strong>{$kolom}</strong></label></li>
			{/foreach}
			</ul>
			<input type="submit" name="opslaan" class="btn btn-lg btn-primary btn-block" id="opslaan" value="Opslaan" />
		</form>
	</div>
	{else}
	<div class="panel panel-danger">
		<div class="panel-heading"><h3><i class="fa fa-exclamation-triangle"></i> Kritieke fout</h3></div>
		<div class="panel-body">
			<p>Er zijn geen instellingen gevonden voor <strong>'{$data.categorie}'</strong>. Raadpleeg de systeembeheerder.</p>
		</div>
	</div>
	{/if}
</div>
{/block}
