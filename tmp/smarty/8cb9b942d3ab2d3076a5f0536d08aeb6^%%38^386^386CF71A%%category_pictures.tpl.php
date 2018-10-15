<?php /* Smarty version 2.6.28, created on 2018-10-14 20:49:56
         compiled from category_pictures.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'category_pictures.tpl', 1, false),array('function', 'oxmultilang', 'category_pictures.tpl', 14, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='GENERAL_ADMIN_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form name="transfer" id="transfer" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

    <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
    <input type="hidden" name="cl" value="category_pictures">
    <input type="hidden" name="editlanguage" value="<?php echo $this->_tpl_vars['editlanguage']; ?>
">
</form>


<table cellspacing="0" cellpadding="0" border="0" width="98%">
<tr>
    <td valign="top" class="edittext">
      <?php echo $this->_tpl_vars['edit']->oxcategories__oxtitle->value; ?>
 <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_THUMB'), $this);?>

      <?php if ($this->_tpl_vars['edit']->oxcategories__oxthumb->value): ?>
        :<br><br>
        <img src="<?php echo $this->_tpl_vars['edit']->getThumbUrl(); ?>
" border="0" hspace="0" vspace="0">
      <?php endif; ?>
    </td>
    <td valign="top" class="edittext">
      <?php echo $this->_tpl_vars['edit']->oxcategories__oxtitle->value; ?>
 <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_ICON'), $this);?>

      <?php if ($this->_tpl_vars['edit']->oxcategories__oxicon->value): ?>
        :<br><br>
        <img src="<?php echo $this->_tpl_vars['edit']->getIconUrl(); ?>
" border="0" hspace="0" vspace="0">
      <?php endif; ?>
    </td>
</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottomnaviitem.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottomitem.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>