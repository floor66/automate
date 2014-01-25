{extends file="base.tpl"}

{block name="page_title"}Inloggen{/block}

{block name="extra_css"}
<link href="{$smarty.const.STATIC_FOLDER}/css/login.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="jumbotron">
	<h1><img src="{$smarty.const.STATIC_FOLDER}/img/logo-performance.png" alt="Performance Autogarage" title="Performance Autogarage" /> Performance&trade; Auto-Mate</h1>
	{if isset($fout)}
	<div class="alert alert-danger alert-dismissable text-center">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Fout:</strong> {$fout}
	</div>
	{/if}
	<form class="form-signin" method="post" action="/automate/" role="form">
		<h2 class="form-signin-heading">
			Log alstublieft in <i class="fa fa-user pull-right"></i> 
		</h2>
		<input type="text" name="gebruikersnaam" class="form-control" placeholder="Gebruikersnaam" required autofocus>
		<input type="password" name="wachtwoord" class="form-control" placeholder="Wachtwoord" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
	</form>
</div>
{/block}
