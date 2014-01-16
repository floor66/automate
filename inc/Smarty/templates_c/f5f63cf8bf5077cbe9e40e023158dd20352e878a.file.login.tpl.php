<?php /* Smarty version Smarty-3.1.16, created on 2014-01-16 19:14:02
         compiled from "./templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152124438552d8154a0acb67-35548439%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5f63cf8bf5077cbe9e40e023158dd20352e878a' => 
    array (
      0 => './templates/login.tpl',
      1 => 1389895901,
      2 => 'file',
    ),
    'd727a2f7c0bda098bc7da6c28169b69f69e5ee74' => 
    array (
      0 => './templates/base.tpl',
      1 => 1389896041,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152124438552d8154a0acb67-35548439',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_52d8154a115d83_37258127',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d8154a115d83_37258127')) {function content_52d8154a115d83_37258127($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<title>Inloggen</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/base.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		
<link href="css/login.css" rel="stylesheet">

	</head>
	<body>
		<div class="container">
			
<div class="jumbotron">
	<h1><img src="img/logo-performance.png" /> Performance&trade; Auto-Mate</h1>
	<form class="form-signin" role="form">
		<h2 class="form-signin-heading">
			<span class="glyphicon glyphicon-user"></span> Log alstublieft in
		</h2>
		<input type="text" class="form-control" placeholder="Gebruikersnaam" required autofocus>
		<input type="password" class="form-control" placeholder="Wachtwoord" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
	</form>
</div>

		</div>
		<script src="js/jquery-2.0.3.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
<?php }} ?>
