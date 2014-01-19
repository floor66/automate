{extends file="base.tpl"}

{block name="page_title"}Overzicht{/block}

{block name="more_css"}
<link href="/static/css/overzicht.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
	{if isset($data_arr)}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-bars"></i> {$categorie} <small>Overzicht</small></h2></div>
		<div class="panel-body">
			<p>Klik op een van de kolomtitels om te sorteren op de desbetreffende kolom.</p>
			<div class="input-group input-group-md" id="resultaten">
				<span class="input-group-addon">Laat</span>
				<input type="text" class="form-control" id="limit" placeholder="{$data_arr|@count}" />
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">resultaten zien</button>
				</span>
			</div>
		</div>
		<div id="prnt">
			<table class="table table-bordered table-hover tablesorter" id="overzicht">
				<thead>
					{foreach $data_arr.0 as $key => $var}<th>{$key}</th>{/foreach}
				</thead>
				<tbody>
				{foreach $data_arr as $data}
					<tr>
						{foreach $data as $key => $var}<td{if $key == "#"} id="{$smarty.get.cat}_{$var}"{/if}>{$var}</td>{/foreach}
					</tr>
				{/foreach}
				</tbody>
			</table>
		</div>
	</div>
	{else}
	<div class="panel panel-danger">
		<div class="panel-heading"><h3><i class="fa fa-exclamation-triangle"></i> Geen data gevonden</h3></div>
		<div class="panel-body">
			<p>Er zijn geen gegevens in de database gevonden voor <strong>'{$categorie}'</strong>. Raadpleeg de systeembeheerder als dit overwacht is.</p>
		</div>
	</div>
	{/if}
</div>
<script type="text/javascript" src="/static/js/overzicht.js"></script>
{/block}
