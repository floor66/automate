{extends file="base.tpl"}

{block name="page_title"}{$data.categorie|capitalize} | Overzicht{/block}

{block name="more_css"}
<link href="/static/css/overzicht.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="row">
{if isset($data.resultaten)}
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-bars"></i> {$data.categorie|capitalize} <small>Overzicht</small></h2></div>
		<div class="panel-body">
			<form method="post" action="/automate/{$data.categorie}/overzicht/" id="sorteer_form">
				<input type="hidden" name="pagina" id="input_pagina" />
				<input type="hidden" name="richting" id="input_richting" />
				<input type="hidden" name="sorteer_kolom" id="input_sorteer_kolom" value="{$data.sorteer_kolom}" />
				<div class="input-group input-group-md" id="resultaten">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" id="button_vertoon">Vertoon</button>
					</span>
					<input type="text" class="form-control" id="input_limiet" name="limiet" placeholder="{$data.limiet}" />
					<span class="input-group-addon">
						resultaten per pagina,
					</span>
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" id="richting_toggle"><i class="fa fa-fw {$data.sorteer_richting_icoon}" /></i><span>{$data.sorteer_richting_text}</span></button>
					</span>
					<span class="input-group-addon">
						gesorteerd op
					</span>
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="button_selected"><span>{$data.sorteer_kolom_leesbaar}</span> <span class="caret"></span></button>
						<ul class="dropdown-menu">
						{foreach $data.presenteerbare_kolommen as $kolom}
							<li class="sorteren-veranderen{if $kolom == $data.sorteer_kolom_leesbaar} active{/if}" id="{$data.kolom_titels.{$kolom@index}}"><a href="#">{$kolom}</a></li>
						{/foreach}
						</ul>
					</span>
				</div>
			</form>
			<p><br />Klik op een van de kolomtitels om in deze resultaten nog verder door te sorteren.</p>
			<strong>Pagina: </strong>
			<div class="btn-group" id="pagina_buttons">
			{if $data.aantal_paginas > 1}
				<button type="button" class="btn btn-default" data-pagina="{$data.pagina - 1}" id="pagina_vorige">&lt;&lt;</button>
			{/if}
				<button type="button" class="btn btn-default{if $data.pagina == 1} active{/if}" data-pagina="1">1</button>
			{if $data.aantal_paginas > 1}
				{if $data.pagina > 1 && $data.pagina < $data.aantal_paginas}
				<button type="button" class="btn btn-default active" data-pagina="{$data.pagina}">{$data.pagina}</button>
				{/if}
				{if $data.aantal_paginas > 3}
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">...</button>
					<div class="dropdown-menu">
						<div class="input-group" style="padding: 0px 5px 0px 5px;">
							<input type="text" class="form-control" id="dropdown_input_pagina" placeholder="..." />
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" id="dropdown_pagina_verstuur"><i class="fa fa-fw fa-lg fa-external-link-square"></i></button>
							</span>
						</div>
					</div>
				</div>
				{elseif $data.aantal_paginas == 3 && $data.pagina != 3}
				<button type="button" class="btn btn-default" data-pagina="2">2</button>
				{/if}
				<button type="button" class="btn btn-default{if $data.pagina == $data.aantal_paginas} active{/if}" data-pagina="{$data.aantal_paginas}">{$data.aantal_paginas}</button>
				<button type="button" class="btn btn-default" data-pagina="{$data.pagina + 1}" id="pagina_volgende">&gt;&gt;</button>
			{/if}
			</div>
		</div>
		<div id="scroll_fix">
			<table class="table table-bordered table-hover tablesorter" id="overzicht">
				<thead>
				{foreach $data.presenteerbare_kolommen as $kolom}
					<th>{$kolom}</th>
				{/foreach}
				</thead>
				<tbody>
				{foreach $data.resultaten as $resultaat}
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
			<p>Er zijn geen gegevens in de database gevonden voor <strong>'{$data.categorie|capitalize}'</strong>. Raadpleeg de systeembeheerder als dit overwacht is.</p>
		</div>
	</div>
{/if}
</div>
<script type="text/javascript" src="/static/js/overzicht.js"></script>
{/block}
