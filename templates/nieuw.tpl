{extends file="base.tpl"}

{block name="page_title"}{$data.categorie|capitalize} | Nieuw{/block}

{block name="extra_css"}
<link href="{$smarty.const.STATIC_FOLDER}/css/nieuw.css" rel="stylesheet">
{/block}

{block name="extra_js"}
<script type="text/javascript" src="{$smarty.const.STATIC_FOLDER}/js/nieuw.js"></script>
{/block}

{block name="container"}
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading"><h2><i class="fa fa-bars"></i> {$data.categorie|capitalize} <small>Nieuw</small></h2></div>
		<div class="panel-body">
			<span class="verplicht">Alle velden gemarkeerd met een * zijn verplicht</span>
			<form method="POST" action="/automate/$data.categorie/nieuw/">
			{if $data.categorie == "klant"}
				<fieldset>
					<legend>Nieuwe klant</legend>
					<div class="row">
						<div class="col-md-5 col-md-offset-1">
							<strong>Voornaam</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="voornaam" />
							<strong>Tussenvoegsel</strong>: <input type="text" class="form-control" name="tussenvoegsel" />
							<strong>Achternaam</strong><span class="verplicht">*</span>: <input type="text" class="form-control" name="achternaam" />
							<strong>Geslacht</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="geslacht" />
							<strong>Geboortedatum</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="geboortedatum" />
							<strong>E-Mail</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="email" />
						</div>
						<div class="col-md-5">
							<strong>Adres</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="adres" />
							<strong>Postcode</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="postcode" />
							<strong>Telefoon (thuis)</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="telefoon_thuis" />
							<strong>Telefoon (mobiel)</strong><span class="verplicht">*</span>: <input type="text" class="form-control" required name="telefoon_mobiel" />
							<strong>Notities</strong>: <textarea class="form-control" name="notities" rows="5"></textarea>
						</div>
					</div>
				</fieldset>
				<input type="submit" class="form-control btn-primary submit" value="Aanmaken" name="nieuw" />
			{else}
			
			{/if}
			</form>
		</div>
	</div>
</div>
{/block}
