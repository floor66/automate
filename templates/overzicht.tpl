{extends file="base.tpl"}

{block name="page_title"}Overizcht{/block}

{block name="more_css"}
<link href="/static/css/overzicht.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
	<div class="panel panel-default">
	{if $data_arr}
		<div class="panel-heading"><h2><i class="fa fa-bars"></i> {$categorie} <small>Overzicht</small></h2></div>
		<table class="table table-bordered">
			{foreach $data_arr as $data}
				{foreach $data as $key => $var}
				<th>{$key}</th>
				{/foreach}
				<tr>
				{foreach $data as $key => $var}
				<td>{$var}</td>
				{/foreach}
				</tr>
			{/foreach}
		</table>
	{/if}
	</div>
</div>
{/block}
