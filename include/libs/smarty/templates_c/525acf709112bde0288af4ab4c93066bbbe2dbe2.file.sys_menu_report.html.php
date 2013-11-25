<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:12
         compiled from "skins/system/dtml/it/report/sys_menu_report.html" */ ?>
<?php /*%%SmartyHeaderCode:44238472652936f5c6bcd67-23136667%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '525acf709112bde0288af4ab4c93066bbbe2dbe2' => 
    array (
      0 => 'skins/system/dtml/it/report/sys_menu_report.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '44238472652936f5c6bcd67-23136667',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'service_link' => 0,
    'instances' => 0,
    'instance' => 0,
    'child_menu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936f5c76e6b1_00326223',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f5c76e6b1_00326223')) {function content_52936f5c76e6b1_00326223($_smarty_tpl) {?><article class="module width_3_quarter">
    <header><h3 class="tabs_involved">Content Manager</h3>
        <ul class="tabs">
            <li class="active"><a href="#tab1">Men&ugrave;</a></li>
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
                    <th class="header">Entry Name</th>
                    <th class="header">Padre</th>
                    <th class="header">Page Linked</th>
                    <th class="header">Azione</th>
                </tr>
                </thead>
                <tbody>
                <?php  $_smarty_tpl->tpl_vars['instance'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['instance']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['instances']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['instance']->key => $_smarty_tpl->tpl_vars['instance']->value){
$_smarty_tpl->tpl_vars['instance']->_loop = true;
?>
                   <?php if ($_smarty_tpl->tpl_vars['instance']->value->parent==null){?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['instance']->value->entry;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['instance']->value->parent->entry;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['instance']->value->linked_page->title;?>
</td>
                            <td>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit&preload=1&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
">
                                    <img src="skins/system/images/icn_edit.png" title="Modifica" />
                                </a>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=delete&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
">
                                    <img type="image" src="skins/system/images/icn_trash.png" title="Rimuovi">
                                </a>
                            </td>
                        </tr>
                        <?php if ($_smarty_tpl->tpl_vars['instance']->value->sys_menu!=null){?>
                            <?php  $_smarty_tpl->tpl_vars['child_menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child_menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['instance']->value->sys_menu; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child_menu']->key => $_smarty_tpl->tpl_vars['child_menu']->value){
$_smarty_tpl->tpl_vars['child_menu']->_loop = true;
?>
                                <?php if ($_smarty_tpl->tpl_vars['child_menu']->value->linked_page==0){?>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['child_menu']->value->entry;?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['instance']->value->parent->entry;?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['child_menu']->value->linked_page->title;?>
</td>
                                        <td>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit&preload=1&value=<?php echo $_smarty_tpl->tpl_vars['child_menu']->value->id;?>
">
                                                <img src="skins/system/images/icn_edit.png" title="Modifica" />
                                            </a>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=delete&value=<?php echo $_smarty_tpl->tpl_vars['child_menu']->value->id;?>
">
                                                <img type="image" src="skins/system/images/icn_trash.png" title="Rimuovi">
                                            </a>
                                        </td>
                                    </tr>
                            <?php }else{ ?>
                            <?php }?>
                            <?php } ?>
                        <?php }?>
                    <?php }?>
                    <!-- END #main-menu -->
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