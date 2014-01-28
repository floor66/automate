{extends file="base.tpl"}

{block name="page_title"}Beheren{/block}

{block name="extra_css"}
<link href="{$smarty.const.STATIC_FOLDER}/css/beheren.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
	{if isset($data.kolommen)}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-wrench"></i> {$data.categorie|capitalize} <small>Beheren</small></h2></div>
		<div class="panel-body">
			<form method="post" action="/automate/{$data.categorie}/beheren/">
				<div class="row">
					{if isset($data.bericht)}
					<div class="alert alert-{if $data.bericht.type == 'fout'}danger{else}success{/if} alert-dismissable text-center">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{$data.bericht.text}
					</div>
					{/if}
						<div class="col-md-6">
							<p>Kies hier welke kolummen u wil laten zien in het overzicht/de zoekresultaten voor <strong>{$data.categorie|capitalize}</strong>.</p>
							<ul style="list-style-type: none;">
							{foreach $data.kolommen as $kolom}
								<li><label><input type="checkbox" name="overzicht_kolommen[{$kolom.titel}]" {if $kolom.weergeven_in_overzicht == 1} checked{/if}{if $kolom.titel == "{$data.categorie}_id"} disabled{/if} /> <strong>{$kolom.titel_net}</strong></label></li>
							{/foreach}
							</ul>
						</div>
						<div class="col-md-6">
							<p>Als er in een overzicht/zoekresultaat gerefereerd wordt naar '<strong>{$data.categorie|capitalize}</strong>', laat dan deze waarde(n) zien:</p>
							<ul style="list-style-type: none;">
							{foreach $data.kolommen as $kolom}
								<li><label><input type="checkbox" name="vreemde_weergaven[{$kolom.titel}]" {if $kolom.weergeven_als_vreemd == 1} checked{/if} /> <strong>{$kolom.titel_net}</strong></label></li>
							{/foreach}
							</ul>
						</div>
				</div>
				<input type="submit" name="opslaan" class="btn btn-lg btn-primary btn-block" id="opslaan" value="Opslaan" />
			</form>
		</div>
	</div>
	{else}
	<div class="panel panel-danger">
		<div class="panel-heading"><h3><i class="fa fa-exclamation-triangle"></i> Kritieke fout</h3></div>
		<div class="panel-body">
			<p>Er zijn geen instellingen gevonden voor <strong>'{$data.categorie|capitalize}'</strong>. Raadpleeg de systeembeheerder.</p>
		</div>
	</div>
	{/if}
</div>
{/block}
