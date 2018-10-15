<?php /* Smarty version 2.6.28, created on 2018-10-14 21:26:08
         compiled from email/plain/register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxcontent', 'email/plain/register.tpl', 1, false),array('modifier', 'default', 'email/plain/register.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_oxcontent(array('ident' => ((is_array($_tmp=@$this->_tpl_vars['contentplainident'])) ? $this->_run_mod_handler('default', true, $_tmp, 'oxregisterplainemail') : smarty_modifier_default($_tmp, 'oxregisterplainemail'))), $this);?>


<?php echo smarty_function_oxcontent(array('ident' => 'oxemailfooterplain'), $this);?>