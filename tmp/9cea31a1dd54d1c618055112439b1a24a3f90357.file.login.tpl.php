<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-05 11:16:10
         compiled from "..\templates\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:490455488a5ac073f5-16393111%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9cea31a1dd54d1c618055112439b1a24a3f90357' => 
    array (
      0 => '..\\templates\\login.tpl',
      1 => 1430814788,
      2 => 'file',
    ),
    '3f6ee17a48f0112659b7cf8a809f9f8a92a39ce1' => 
    array (
      0 => '..\\templates\\index.tpl',
      1 => 1430747847,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '490455488a5ac073f5-16393111',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55488a5ac59493_49311452',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55488a5ac59493_49311452')) {function content_55488a5ac59493_49311452($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<title>timetable</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<?php echo $_smarty_tpl->getSubTemplate ("navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<div class="container">
			
	<form method="post" action="login.php">
		<div class="login fully-center">
			<h1>Please log in!</h1>
			<div class="form-group">
				<label for="username">Username:</label>
				<input class="form-control" name="username" type="text" placeholder="Username" autofocus />
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input class="form-control" name="password" type="password" placeholder="Password" />
			</div>
			<button class="btn btn-primary">Login</button>
			<?php if ($_smarty_tpl->tpl_vars['errors']->value) {?>
				<div class="alert alert-danger">
					<ul>
					<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
						<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
					<?php } ?>
					</ul>
				</div>
			<?php }?>
		</div>
	</form>

		</div>
	</body>
</html><?php }} ?>
