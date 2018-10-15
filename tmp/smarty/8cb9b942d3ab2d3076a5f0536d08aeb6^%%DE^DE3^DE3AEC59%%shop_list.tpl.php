<?php /* Smarty version 2.6.28, created on 2018-10-14 21:49:26
         compiled from shop_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'shop_list.tpl', 1, false),array('modifier', 'oxaddslashes', 'shop_list.tpl', 63, false),array('function', 'oxmultilang', 'shop_list.tpl', 64, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='GENERAL_ADMIN_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)),'box' => 'list')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('where', $this->_tpl_vars['oView']->getListFilter()); ?>

<?php if ($this->_tpl_vars['readonly']): ?>
    <?php $this->assign('readonly', 'readonly disabled'); ?>
<?php else: ?>
    <?php $this->assign('readonly', ""); ?>
<?php endif; ?>

<script type="text/javascript">
<!--
function editThis( sID )
{
    var oForm = top.navigation.adminnav.document.getElementById( "search" );
    if ( oForm ) {
        // passing this info about active view and tab to nav frame
        var oInputElement = document.createElement( 'input' );
        oInputElement.setAttribute( 'name', 'listview');
        oInputElement.setAttribute( 'type', 'hidden' );
        oInputElement.value = "<?php echo $this->_tpl_vars['oViewConf']->getActiveClassName(); ?>
";
        oForm.appendChild( oInputElement );

        var oInputElement = document.createElement( 'input' );
        oInputElement.setAttribute( 'name', 'actedit');
        oInputElement.setAttribute( 'type', 'hidden' );
        oInputElement.value = "<?php echo $this->_tpl_vars['actedit']; ?>
";
        oForm.appendChild( oInputElement );

        var oInputElement = document.createElement( 'input' );
        oInputElement.setAttribute( 'name', 'editview');
        oInputElement.setAttribute( 'type', 'hidden' );
        oInputElement.value = top.oxid.admin.getClass( sID );
        oForm.appendChild( oInputElement );

        // selecting shop
        top.navigation.adminnav.selectShop( sID );
    }
}


window.onload = function ()
{
    <?php if ($this->_tpl_vars['updatenav']): ?>
    var oTransfer = top.basefrm.edit.document.getElementById( "transfer" );
    oTransfer.updatenav.value = 1;
    oTransfer.cl.value = '<?php echo $this->_tpl_vars['default_edit']; ?>
';
    <?php endif; ?>
    top.reloadEditFrame();
}
         //-->
</script>

<form name="search" id="search" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_formparams.tpl", 'smarty_include_vars' => array('cl' => 'shop_list','lstrt' => $this->_tpl_vars['lstrt'],'actedit' => $this->_tpl_vars['actedit'],'oxid' => $this->_tpl_vars['oxid'],'fnc' => "",'language' => $this->_tpl_vars['actlang'],'editlanguage' => $this->_tpl_vars['actlang'],'delshopid' => "",'updatenav' => "")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>




<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagetabsnippet.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
if (parent.parent != null && parent.parent.setTitle )
{   parent.parent.sShopTitle   = "<?php echo ((is_array($_tmp=$this->_tpl_vars['actshopobj']->oxshops__oxname->getRawValue())) ? $this->_run_mod_handler('oxaddslashes', true, $_tmp) : smarty_modifier_oxaddslashes($_tmp)); ?>
";
    parent.parent.sMenuItem    = "<?php echo smarty_function_oxmultilang(array('ident' => 'SHOP_LIST_MENUITEM'), $this);?>
";
    parent.parent.sMenuSubItem = "<?php echo smarty_function_oxmultilang(array('ident' => 'SHOP_LIST_MENUSUBITEM'), $this);?>
";
    parent.parent.sWorkArea    = "<?php echo $this->_tpl_vars['_act']; ?>
";
    parent.parent.setTitle();
}
</script>
</body>
</html>