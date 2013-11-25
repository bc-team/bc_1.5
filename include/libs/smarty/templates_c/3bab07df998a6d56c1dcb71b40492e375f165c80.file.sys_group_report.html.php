<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:03
         compiled from "skins/system/dtml/it/report/sys_group_report.html" */ ?>
<?php /*%%SmartyHeaderCode:214386934352936f53a984a7-69798257%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3bab07df998a6d56c1dcb71b40492e375f165c80' => 
    array (
      0 => 'skins/system/dtml/it/report/sys_group_report.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214386934352936f53a984a7-69798257',
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
  'unifunc' => 'content_52936f53b0d6d3_77187184',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f53b0d6d3_77187184')) {function content_52936f53b0d6d3_77187184($_smarty_tpl) {?><article class="module width_3_quarter">
    <header><h3 class="tabs_involved">Content Manager</h3>
        <ul class="tabs">
            <li class="active"><a href="#tab1">Groups</a></li>
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
                    <th class="header">Nome</th>
                    <th class="header">Category</th>
                    <th class="header">Attivo</th>
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
                    <td><?php echo $_smarty_tpl->tpl_vars['instance']->value->name;?>
</td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit&preload=1&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
" title="Modifica"><img src="skins/system/images/icn_edit.png" alt="modifica elemento"/> </a>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=delete&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->username;?>
" title="Rimuovi"><img src="skins/system/images/icn_trash.png" alt="elimina elemento"/> </a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div><!-- end of #tab1 -->

    </div><!-- end of .tab_container -->
    <?php }else{ ?>
        <h1>NON CI SONO <?php echo $_smarty_tpl->tpl_vars['instance']->value->name;?>
</h1>
    <?php }?>
</article>


<!--<h1 class="inl_blk mb15 mt15">Groups Manager</h1>
<a class="addLink" href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit" title="aggiungi un nuovo servizio">aggiungi</a>
<?php if ($_smarty_tpl->tpl_vars['instances']->value!=null||$_smarty_tpl->tpl_vars['instance']->value!=null){?>
<?php  $_smarty_tpl->tpl_vars['instance'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['instance']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['instances']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['instance']->key => $_smarty_tpl->tpl_vars['instance']->value){
$_smarty_tpl->tpl_vars['instance']->_loop = true;
?>
	<ul>
		<li class="border_bm">
			<h2>
				<?php echo $_smarty_tpl->tpl_vars['instance']->value->name;?>

			</h2>
			<h6 class="inl_blk mr10">
				<a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=emit&preload=1&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
" title="modifica il servizio">Modifica</a>
			</h6>
			<h6 class="inl_blk mr10">
				<a href="<?php echo $_smarty_tpl->tpl_vars['service_link']->value;?>
?action=delete&value=<?php echo $_smarty_tpl->tpl_vars['instance']->value->id;?>
" title="cancellazione rapida">Rimuovi</a>
			</h6>
		</li>
	</ul>
<?php } ?>
<?php }else{ ?>
	<h1 class="inl_blk mb15 mt15">NON CI SONO <?php echo $_smarty_tpl->tpl_vars['instance']->value->name;?>
</h1>
<?php }?>  -->

<?php }} ?>