<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:07
         compiled from "skins/system/dtml/it/report/sys_service_report.html" */ ?>
<?php /*%%SmartyHeaderCode:66855285652936f571d5d53-58579900%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ab41e833ee0abdccfbb46b47c841e74e2bbc2af' => 
    array (
      0 => 'skins/system/dtml/it/report/sys_service_report.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '66855285652936f571d5d53-58579900',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'service_link' => 0,
    'instances' => 0,
    'instance' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936f5721a1c6_47035102',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f5721a1c6_47035102')) {function content_52936f5721a1c6_47035102($_smarty_tpl) {?><article class="module width_3_quarter">
    <header><h3 class="tabs_involved">Content Manager</h3>
        <ul class="tabs">
            <li class="active"><a href="#tab1">Service</a></li>
            <li>
                <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit">
                    <img class="add_entities" src="skins/system/images/icn_plus.png" title="Aggiungi"/>
                </a>
            </li>
        </ul>
    </header>
    <?php if ($_smarty_tpl->tpl_vars['instances']->value!=null||$_smarty_tpl->tpl_vars['instance']->value!=null){?>
    <div class="tab_container">
        <div id="tab1" class="tab_content" style="display: block;">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th class="header"></th>
                    <th class="header">Menu Entry</th>
                    <th class="header">Nome</th>
                    <th class="header">Azione</th>
                </tr>
                </thead>
                <tbody>
                <?php  $_smarty_tpl->tpl_vars['instance'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['instance']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['instances']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['instance']->key => $_smarty_tpl->tpl_vars['instance']->value){
$_smarty_tpl->tpl_vars['instance']->_loop = true;
?>
                <tr>
                    <td><input type="checkbox"></td>
                    <td class="text_uppercase"><?php echo $_smarty_tpl->tpl_vars['instance']->value->entry;?>
</td>
                    <td class="text_uppercase"><?php echo $_smarty_tpl->tpl_vars['instance']->value->name;?>
</td>
                    <td>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit&preload=1&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
" title="Modifica"><img src="skins/system/images/icn_edit.png" alt="modifica elemento"/> </a>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=delete&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
" title="Rimuovi"><img src="skins/system/images/icn_trash.png" alt="elimina elemento"/> </a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div><!-- end of #tab1 -->

    </div><!-- end of .tab_container -->

</article>
<?php }else{ ?>
<h1>NON CI SONO servizi</h1>
<?php }?>
<?php }} ?>