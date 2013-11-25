<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:40:23
         compiled from "skins/system/dtml/it/widget/CheckBox.html" */ ?>
<?php /*%%SmartyHeaderCode:108433026052936f674ef1b0-06981331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9280ea9b0fe1eaefbc9731c26a1cb45218937467' => 
    array (
      0 => 'skins/system/dtml/it/widget/CheckBox.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '108433026052936f674ef1b0-06981331',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'value' => 0,
    'checked' => 0,
    'label' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52936f6752a889_94000170',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52936f6752a889_94000170')) {function content_52936f6752a889_94000170($_smarty_tpl) {?><!-- check box widget-->
<input class="" id="input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" />
<span class="">&nbsp;</span>
<div id="">
   <label class="" title="clicca per selezionare/desselezionare">
   	  <input id="check_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" class="mt7 flt_lft" type="checkbox" <?php echo $_smarty_tpl->tpl_vars['checked']->value;?>
/>
      <span id="label_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['label']->value;?>
</span>
   </label>
</div>
<div class="clear">&nbsp;</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#label_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").click(function() {
			if ($("#input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").attr("value") == "*") {
				$("#input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").attr("value", "");
			} else {
				$("#input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").attr("value", "*");
			}
		});
		
		$("#check_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").click(function() {
 			if( ( $("#input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").attr("value") == "*") ) {
				$("#input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").attr("value", "");
			} else {
				$("#input_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
").attr("value", "*");
			}
		});
		
		/* $('#input_active').click(function(ev){
			console.log(ev.isImmediatePropagationStopped());
			}); */
	});
</script><?php }} ?>