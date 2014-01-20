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
			<div class="input-group input-group-md" id="resultaten">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="button" id="vertoon">Vertoon</button>
				</span>
				<input type="text" class="form-control" id="limit" placeholder="{$data_arr|@count}" />
				<span class="input-group-addon">
					resultaten
				</span>
				<span class="input-group-addon">
					<label><input type="checkbox" name="richting" id="richting" value="{$smarty.get.dir}"{if $smarty.get.dir == "ASC"} checked{/if} /> <span>{if $smarty.get.dir == "ASC"}Oplopend{else}Aflopend{/if}</span></label>
				</span>
				<span class="input-group-addon">
					gesorteerd op
				</span>
				<div class="input-group-btn">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="selected"><span>{$readable_sort}</span> <span class="caret"></span></button>
					<ul class="dropdown-menu">
						{foreach $presenteerbare_titels as $key}<li class="sorteren-veranderen{if $key == $readable_sort} active{/if}" id="{$ruwe_titels.{$key@index}}"><a href="#">{$key}</a></li>{/foreach}
					</ul>
				</div>
			</div>
			<p><br />Klik op een van de kolomtitels om in deze resultaten nog verder te sorteren.</p>
		</div>
		<div id="prnt">
			<table class="table table-bordered table-hover tablesorter" id="overzicht">
				<thead>
					{foreach $presenteerbare_titels as $key}<th>{$key}</th>{/foreach}
				</thead>
				<tbody>
				{foreach $data_arr as $data}
					<tr>
						{foreach $data as $key => $var}<td{if $key == "#"} id="{$smarty.get.cat}_{$var}"{/if}{if strstr($key, "datum")} data-date="{$var}"{/if}>{if strstr($key, "datum")}{$var|date_format:"%d-%m-%Y"}{else}{$var}{/if}</td>{/foreach}
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
