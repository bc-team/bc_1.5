<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:53:25
         compiled from "skins/system/dtml/it/frame-public.html" */ ?>
<?php /*%%SmartyHeaderCode:17482812352937275b502d7-96393314%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca2f644c6a3cd52cb11aa03e951856deba3754ea' => 
    array (
      0 => 'skins/system/dtml/it/frame-public.html',
      1 => 1385394717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17482812352937275b502d7-96393314',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'head' => 0,
    'header' => 0,
    'sitemap' => 0,
    'menu' => 0,
    'body' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52937275b68ea1_13169628',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52937275b68ea1_13169628')) {function content_52937275b68ea1_13169628($_smarty_tpl) {?><!doctype html>
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
            <?php echo $_smarty_tpl->tpl_vars['sitemap']->value;?>

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