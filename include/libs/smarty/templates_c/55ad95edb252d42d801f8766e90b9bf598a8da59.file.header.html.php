<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:53:25
         compiled from "skins/system/dtml/it/header.html" */ ?>
<?php /*%%SmartyHeaderCode:197253826852937275ae5899-86216818%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55ad95edb252d42d801f8766e90b9bf598a8da59' => 
    array (
      0 => 'skins/system/dtml/it/header.html',
      1 => 1385394717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197253826852937275ae5899-86216818',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'webApp' => 0,
    'instance' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52937275b1d318_07356791',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52937275b1d318_07356791')) {function content_52937275b1d318_07356791($_smarty_tpl) {?><header id="header">
    <hgroup>
        <h1 class="site_title">beContent Admin</h1>
        <?php if ($_smarty_tpl->tpl_vars['webApp']->value!=null){?>
            <h2 class="section_title"><?php echo $_smarty_tpl->tpl_vars['webApp']->value;?>
</h2><div class="btn_view_site"><a href="index.php">View Site</a></div>
        <?php }else{ ?>
            <h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="index.php">View Site</a></div>
        <?php }?>
    </hgroup>
</header> <!-- end of header bar -->
<section id="secondary_bar">
    <div class="user">
        <?php if ($_smarty_tpl->tpl_vars['instance']->value->username!=null){?>
         <p><?php echo $_smarty_tpl->tpl_vars['instance']->value->username;?>
 (<a href="#"></a>)</p>
         <a class="logout_user" href="logout.php" title="Logout">Logout</a>
        <?php }else{ ?>
            <p></p>
        <?php }?>
    </div>
</section><?php }} ?>