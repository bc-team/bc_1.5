<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:36:01
         compiled from "skins/system/dtml/it/menu_admin.html" */ ?>
<?php /*%%SmartyHeaderCode:209006240352936e6103db19-12736293%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b55987e2af00644d159d782c18523fadb42483f0' => 
    array (
      0 => 'skins/system/dtml/it/menu_admin.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209006240352936e6103db19-12736293',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'instances' => 0,
    'category' => 0,
    'service' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936e61122c19_07859308',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936e61122c19_07859308')) {function content_52936e61122c19_07859308($_smarty_tpl) {?><form class="quick_search">
    <input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
</form>  
<hr>
<div id="menu-admin-wrapper">
    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['instances']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
        <h3><?php echo $_smarty_tpl->tpl_vars['category']->value->name;?>
 <a href="#" class="toggleLink">Hide</a></h3>
        <ul class="toggle">
            <?php  $_smarty_tpl->tpl_vars['service'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['service']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value->sys_service; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['service']->key => $_smarty_tpl->tpl_vars['service']->value){
$_smarty_tpl->tpl_vars['service']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['service']->value->name=='User Management'){?>
                    <li class="icn_view_users">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='News'){?>
                    <li class="icn_new_article">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Image'){?>
                    <li class="icn_photo">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Menu Management'){?>
                    <li class="icn_categories">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Slider'){?>
                    <li class="icn_slider">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Group Management'){?>
                    <li class="icn_folder">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Page Management'){?>
                    <li class="icn_page">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Service Management'){?>
                    <li class="icn_settings">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Service Category Management'){?>
                    <li class="icn_settings">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }elseif($_smarty_tpl->tpl_vars['service']->value->name=='Admin Room'){?>
                    <li class="icn_bed">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }else{ ?>
                    <li>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service']->value->script;?>
?action=report"><?php echo $_smarty_tpl->tpl_vars['service']->value->entry;?>
 </a>
                    </li>
                <?php }?>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<footer>
    <hr />
        <?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

</footer><?php }} ?>