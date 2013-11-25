<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:37:49
         compiled from "skins/system/dtml/it/frame-private.html" */ ?>
<?php /*%%SmartyHeaderCode:145685233352936ecde4d0e2-45625102%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9d97b2719862e5e912e9e1f44f91b7d356ad505' => 
    array (
      0 => 'skins/system/dtml/it/frame-private.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145685233352936ecde4d0e2-45625102',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'head' => 0,
    'header' => 0,
    'menu' => 0,
    'body' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936ecde60343_27584214',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936ecde60343_27584214')) {function content_52936ecde60343_27584214($_smarty_tpl) {?><!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<?php echo $_smarty_tpl->tpl_vars['head']->value;?>


<body>
	<div id="wrapper">
		<div class="container">
				<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

			<!-- BAR MENU -->
            <aside id="sidebar" class="column">
                <?php echo $_smarty_tpl->tpl_vars['menu']->value;?>

            </aside>
            <section id="main" class="column">
				<?php echo $_smarty_tpl->tpl_vars['body']->value;?>

            </section>
		</div>
	</div>
</body>
</html>
<?php }} ?>