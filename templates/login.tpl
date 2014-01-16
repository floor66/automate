{extends file="base.tpl"}

{block name="page_title"}Inloggen{/block}

{block name="more_css"}
<link href="css/login.css" rel="stylesheet">
{/block}

{block name="container"}
<div class="jumbotron">
	<h1><img src="img/logo-performance.png" alt="Performance Autogarage" title="Performance Autogarage" /> Performance&trade; Auto-Mate</h1>
	<form class="form-signin" role="form">
		<h2 class="form-signin-heading">
			Log alstublieft in <span class="glyphicon glyphicon-user pull-right"></span> 
		</h2>
		<input type="text" class="form-control" placeholder="Gebruikersnaam" required autofocus>
		<input type="password" class="form-control" placeholder="Wachtwoord" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
	</form>
</div>
{/block}
