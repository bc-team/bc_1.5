<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:23
         compiled from "skins/system/dtml/it/form.html" */ ?>
<?php /*%%SmartyHeaderCode:96276426852936f67539257-45761309%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '116e01f4fa17e192225a47728b502133db5002f7' => 
    array (
      0 => 'skins/system/dtml/it/form.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96276426852936f67539257-45761309',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'value' => 0,
    'formName' => 0,
    'formMethod' => 0,
    'formPage' => 0,
    'actionHeader' => 0,
    'content' => 0,
    'closing' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936f675529e8_32322065',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f675529e8_32322065')) {function content_52936f675529e8_32322065($_smarty_tpl) {?><script type="text/javascript">
function deleteThis(parameter)
{
	document.location.href = document.URL+"&action=delete&value=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
"
}
</script>

<div class="module_form">
<form  id="form" name="<?php echo $_smarty_tpl->tpl_vars['formName']->value;?>
" method="<?php echo $_smarty_tpl->tpl_vars['formMethod']->value;?>
" enctype="multipart/form-data" >
	<input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['formPage']->value;?>
">
	<?php echo $_smarty_tpl->tpl_vars['actionHeader']->value;?>

	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

	<?php echo $_smarty_tpl->tpl_vars['closing']->value;?>

</div><?php }} ?>