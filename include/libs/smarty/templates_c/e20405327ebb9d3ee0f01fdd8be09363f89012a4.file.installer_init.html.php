<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 15:55:41
         compiled from "skins/system/dtml/it/installer_init.html" */ ?>
<?php /*%%SmartyHeaderCode:995367519529364ed765738-06029900%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e20405327ebb9d3ee0f01fdd8be09363f89012a4' => 
    array (
      0 => 'skins/system/dtml/it/installer_init.html',
      1 => 1385390584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '995367519529364ed765738-06029900',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_529364ed767472_45776339',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_529364ed767472_45776339')) {function content_529364ed767472_45776339($_smarty_tpl) {?><div class="installer-wrapper">
    <p>
	Sembra non vi sia un file
	<strong>config.cfg</strong>
	. Occorre averlo per poter iniziare.
</p>
<p>
	Serve altro aiuto? <a href="http://www.becontent.org">Eccolo</a>.
</p>

<p>Prima di iniziare occorrono alcune
	informazioni sul database. Prima di procedere occorre conoscere i
	seguenti elementi.</p>

<ol>
	<li>Nome del database</li>
	<li>Nome utente del database</li>
	<li>Password del database</li>
	<li>Host del database</li>
	<li>Prefisso tabelle </li>
</ol>
<p>
	<strong>Se per qualsiasi motivo questa creazione automatica di
		file non dovesse funzionare non ti preoccupare. Tutto quello che devi
		fare e compilare i parametri del database su un file di configurazione.
        Puoi modificare la tua configurazione in qualsiasi momento tramite il file
        <code>config.cfg</code>
	</strong>
</p>
<p>Con ogni probabilit&agrave;, queste informazioni sono gi&agrave; state fornite
	dal proprio fornitore di hosting. Se non si dispone di queste
	informazioni occorrer&agrave; contattare il fornitore prima di poter
	proseguire.</p>

<div>
	<form class="" action="installer.php" method="POST">
		<div>Ancora non hai configurato beContent...</div>
		<div style="margin-top: 10px;">
			<label class="flt_lft line_height30 w230 right_align mr20">&nbsp;</label>
			<input type="hidden" name="stateComplete" value="ok" /> <input
				type="submit" value="Crea il file di configurazione" />
		</div>
	</form>
</div>

</div><?php }} ?>