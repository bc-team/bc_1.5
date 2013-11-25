<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 15:55:55
         compiled from "skins/system/dtml/it/installer_databaseform.html" */ ?>
<?php /*%%SmartyHeaderCode:1305011330529364fb5023e6-06443459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd48d737f3c07ce7ac98cfd8134ffd72bf697dcef' => 
    array (
      0 => 'skins/system/dtml/it/installer_databaseform.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1305011330529364fb5023e6-06443459',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_529364fb5267e7_07901102',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_529364fb5267e7_07901102')) {function content_529364fb5267e7_07901102($_smarty_tpl) {?><div class="installer-wrapper">
    <form  action="installer.php" method="POST">
	<div>
		<p>Di seguito puoi inserire i dettagli di connessione al database.
			Se non sei sicuro dei dati da inserire contatta il tuo fornitore di
			hosting.</p>
	</div>
	<fieldset>
		<label ><strong>Username
			Mysql</strong></label> <input  type="text" name="usernameMysql" />
	</fieldset>
	<fieldset>
		<label ><strong>Password
			Mysql</strong></label> <input  type="password" name="passwordMysql" />
	</fieldset>
	<fieldset>
		<label><strong>Nome
			Database</strong> </label> <input  type="text" name="database" /> 
			<small class="line_height30 w100_100 ml20 text"><strong>Attenzione</strong>:	il database deve gi&agrave; esistere</small>
	</fieldset>
	<fieldset>
		<label ><strong>Host
			Mysql</strong></label> <input  type="text" name="host" />
	</fieldset>
	<fieldset>
		<label ><strong>Prefisso tabelle</strong></label> 
		<input  type="text" name="prefix" />
	</fieldset>
	<div>
		<label>&nbsp;</label>
		<input type="hidden" name="InstallerState_2" value="InstallerState_2" />
		<input type="submit" value="Continua" />
	</div>
</form>
</div><?php }} ?>