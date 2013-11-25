<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:23
         compiled from "skins/system/dtml/it/widget/PasswordField.html" */ ?>
<?php /*%%SmartyHeaderCode:97232788052936f674be9f2-63758608%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fa8f66df82ca0359c56548145c6ce0cdd1332d2' => 
    array (
      0 => 'skins/system/dtml/it/widget/PasswordField.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97232788052936f674be9f2-63758608',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'label' => 0,
    'type' => 0,
    'size' => 0,
    'maxlength' => 0,
    'id' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936f674e9077_33877913',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f674e9077_33877913')) {function content_52936f674e9077_33877913($_smarty_tpl) {?><!--div>
	<label class="flt_lft line_height30 w230 right_align mr20" for="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['label']->value;?>
</label>
	<input class="mb20 w220" id="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" type="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" size="<?php echo $_smarty_tpl->tpl_vars['size']->value;?>
" maxlength="<?php echo $_smarty_tpl->tpl_vars['maxlength']->value;?>
" />
</div>
<div class="clear">&nbsp;</div-->
<fieldset> <!-- to make two field float next to one another, adjust values accordingly -->
    <label><?php echo $_smarty_tpl->tpl_vars['label']->value;?>
</label>
    <input id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" type="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" style="width:92%;"/>
</fieldset>

<?php }} ?>