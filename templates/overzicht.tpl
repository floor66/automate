{extends file="base.tpl"}

{block name="page_title"}{$categorie|capitalize} | Overzicht{/block}

{block name="more_css"}
<link href="/static/css/overzicht.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
{if isset($resultaten)}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-bars"></i> {$categorie|capitalize} <small>Overzicht</small></h2></div>
		<div class="panel-body">
			<form method="post" action="/automate/{$categorie}/overzicht/" id="sorteer_form">
				<div class="input-group input-group-md" id="resultaten">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" id="vertoon">Vertoon</button>
					</span>
					<input type="text" class="form-control" id="limit" name="limit" placeholder="{$limiet}" />
					<span class="input-group-addon">
						resultaten per pagina,
					</span>
					<span class="input-group-addon" id="richting_toggle">
						<input type="hidden" name="richting" id="richting" />
						<i class="fa fa-fw {$sorteer_richting_icoon}" /></i><span>{$sorteer_richting}</span>
					</span>
					<span class="input-group-addon">
						gesorteerd op
					</span>
					<span class="input-group-btn">
						<input type="hidden" name="sorteer_kolom" id="sorteer_kolom" value="{$sorteer_kolom}" />
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="selected"><span>{$sorteer_kolom_leesbaar}</span> <span class="caret"></span></button>
						<ul class="dropdown-menu">
						{foreach $presenteerbare_kolommen as $kolom}
							<li class="sorteren-veranderen{if $kolom == $sorteer_kolom_leesbaar} active{/if}" id="{$kolom_titels.{$kolom@index}}"><a href="#">{$kolom}</a></li>
						{/foreach}
						</ul>
					</span>
					<input type="hidden" name="pagina" id="pagina" value="" />
				</div>
			</form>
			<p><br />Klik op een van de kolomtitels om in deze resultaten nog verder door te sorteren.</p>
			<strong>Pagina: </strong>
			<div class="btn-group" id="pagina_knoppen">
			{if $aantal_paginas > 1}
				<button type="button" class="btn btn-default" data-pagina="{$huidige_pagina - 1}" id="vorige">&lt;&lt;</button>
			{/if}
				<button type="button" class="btn btn-default{if $huidige_pagina == 1} active{/if}" data-pagina="1">1</button>
			{if $aantal_paginas > 1}
				{if $huidige_pagina > 1 && $huidige_pagina < $aantal_paginas}
				<button type="button" class="btn btn-default active" data-pagina="{$huidige_pagina}">{$huidige_pagina}</button>
				{/if}
				{if $aantal_paginas > 3}
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">...</button>
					<div class="dropdown-menu">
						<div class="input-group" style="padding: 0px 5px 0px 5px;">
							<input type="text" class="form-control" id="pagina_input" placeholder="..." />
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" id="ga_naar_pagina"><i class="fa fa-fw fa-lg fa-external-link-square"></i></button>
							</span>
						</div>
					</div>
				</div>
				{/if}
				<button type="button" class="btn btn-default{if $huidige_pagina == $aantal_paginas} active{/if}" data-pagina="{$aantal_paginas}">{$aantal_paginas}</button>
				<button type="button" class="btn btn-default" data-pagina="{$huidige_pagina + 1}" id="volgende">&gt;&gt;</button>
			{/if}
			</div>
		</div>
		<div id="scroll_fix">
			<table class="table table-bordered table-hover tablesorter" id="overzicht">
				<thead>
				{foreach $presenteerbare_kolommen as $kolom}
					<th>{$kolom}</th>
				{/foreach}
				</thead>
				<tbody>
				{foreach $resultaten as $resultaat}
					<tr>
					{foreach $resultaat as $kolom => $waarde}
						<td{if strstr($kolom, "datum")} data-date="{$waarde}"{/if}>{if strstr($kolom, "datum")}{$waarde|date_format:"%d-%m-%Y"}{else}{$waarde}{/if}</td>
					{/foreach}
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
			<p>Er zijn geen gegevens in de database gevonden voor <strong>'{$categorie|capitalize}'</strong>. Raadpleeg de systeembeheerder als dit overwacht is.</p>
		</div>
	</div>
{/if}
</div>
<script type="text/javascript" src="/static/js/overzicht.js"></script>
{/block}
