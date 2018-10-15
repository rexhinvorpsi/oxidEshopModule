<?php /* Smarty version 2.6.28, created on 2018-10-14 21:26:08
         compiled from email/html/register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'email/html/register.tpl', 5, false),array('modifier', 'default', 'email/html/register.tpl', 7, false),array('function', 'oxcontent', 'email/html/register.tpl', 7, false),)), $this); ?>
<?php $this->assign('shop', $this->_tpl_vars['oEmailView']->getShop()); ?>
<?php $this->assign('oViewConf', $this->_tpl_vars['oEmailView']->getViewConfig()); ?>
<?php $this->assign('user', $this->_tpl_vars['oEmailView']->getUser()); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "email/html/header.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='DD_REGISTER_HEADING')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo smarty_function_oxcontent(array('ident' => ((is_array($_tmp=@$this->_tpl_vars['contentident'])) ? $this->_run_mod_handler('default', true, $_tmp, 'oxregisteremail') : smarty_modifier_default($_tmp, 'oxregisteremail'))), $this);?>
<br/>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "email/html/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>