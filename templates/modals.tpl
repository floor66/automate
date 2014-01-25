<div class="modal fade" id="uitlog_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Weet u zeker dat u uit wilt loggen?</h4>
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<a class="btn btn-danger" href="/automate/logout/" title="Uitloggen"><i class="fa fa-lg fa-power-off"></i></a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Terug</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="zoek_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title"><span></span> <small>Zoekopdracht</small></h1>
			</div>
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<form method="post" action="/automate/" id="zoek_form">
					<input type="hidden" name="zoek_kolom" id="input_zoek_kolom" />
					<input type="hidden" name="sorteer_kolom" id="input_sorteer_kolom" />
					<p>Kies hier op welke kolom en met welke zoekterm u wilt zoeken.</p>
					<div class="input-group input-group-md">
						<span class="input-group-btn mijn-dropdown-select" data-references="input_zoek_kolom">
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span>Zoeken op...</span> <span class="caret"></span></button>
							<ul class="dropdown-menu"></ul>
						</span>
						<input type="text" class="form-control" name="zoek_term" id="input_zoek_term" placeholder="Vul uw zoekterm in" required />
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<button type="button" class="btn btn-primary" id="button_zoeken"><i class="fa fa-lg fa-search"></i></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Terug</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{$smarty.const.STATIC_FOLDER}/js/modals.js"></script>
