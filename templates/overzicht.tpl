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
		<table class="table table-bordered table-hover">
			{foreach $data_arr as $data}
				{foreach $data as $key => $var}
				<th>{$key}</th>
				{/foreach}
				<tr>
				{foreach $data as $key => $var}
					<td{if $key == "#"} id="{$smarty.get.cat}_{$var}"{/if}>{$var}</td>
				{/foreach}
				</tr>
			{/foreach}
		</table>
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
{/block}
