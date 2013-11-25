<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:23
         compiled from "skins/system/dtml/it/widget/TextField.html" */ ?>
<?php /*%%SmartyHeaderCode:99437017552936f67496239-77870023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75f8f6b7ddcff435e3e93431a64fb09bb7f2b040' => 
    array (
      0 => 'skins/system/dtml/it/widget/TextField.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99437017552936f67496239-77870023',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'label' => 0,
    'id' => 0,
    'type' => 0,
    'name' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936f674baee7_05203732',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f674baee7_05203732')) {function content_52936f674baee7_05203732($_smarty_tpl) {?><!-- text field widget-->
<fieldset>
    <label><?php echo $_smarty_tpl->tpl_vars['label']->value;?>
</label>
    <input id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" type="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" style="width:92%;"/>
</fieldset>
<?php }} ?>