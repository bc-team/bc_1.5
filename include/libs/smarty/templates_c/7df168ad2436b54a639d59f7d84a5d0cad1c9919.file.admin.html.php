<?php /* Smarty version Smarty-3.1.13, created on 2013-11-25 16:55:01
         compiled from "skins/system/dtml/it/admin.html" */ ?>
<?php /*%%SmartyHeaderCode:967935863529372d5b27492-92524514%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7df168ad2436b54a639d59f7d84a5d0cad1c9919' => 
    array (
      0 => 'skins/system/dtml/it/admin.html',
      1 => 1385394717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '967935863529372d5b27492-92524514',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_529372d5b29288_99094623',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_529372d5b29288_99094623')) {function content_529372d5b29288_99094623($_smarty_tpl) {?>
<div id="form-login">
    <h1 class="bc-logo"></h1>
    <form action="login.php" method="post">
        <table>
            <tr>
                <td>Username</td>
                <td><input class="" type="text" name="username" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input class="" type="password" name="password" /></td>
            </tr>
        </table>
        <div class="closing">
            <label class="">&nbsp;</label>
            <input class="" type="submit" value="login" />
            <input class="" type="reset" value="reset" />
        </div>
    </form>
</div>

<?php }} ?>