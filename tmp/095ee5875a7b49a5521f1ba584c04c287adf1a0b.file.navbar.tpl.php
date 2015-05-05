<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-05 11:15:02
         compiled from "..\templates\navbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2797955488a16349863-75589707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '095ee5875a7b49a5521f1ba584c04c287adf1a0b' => 
    array (
      0 => '..\\templates\\navbar.tpl',
      1 => 1430815860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2797955488a16349863-75589707',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55488a163553e0_49714820',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55488a163553e0_49714820')) {function content_55488a163553e0_49714820($_smarty_tpl) {?><nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">timetable.</a>
		</div>

		<div class="collapse navbar-collapse" id="navbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
				<li><a href="#">Link</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php if (!isset($_SESSION['username'])) {?><li><a href="login.php">Login</a></li>
				<?php } else { ?><li><a href="logout.php">Logout</a></li><?php }?>
			</ul>
		</div>
	</div>
</nav><?php }} ?>
