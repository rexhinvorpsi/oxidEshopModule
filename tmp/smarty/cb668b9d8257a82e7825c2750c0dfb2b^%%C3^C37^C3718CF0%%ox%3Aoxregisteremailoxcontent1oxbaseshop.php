<?php /* Smarty version 2.6.28, created on 2018-10-14 21:26:08
         compiled from ox:oxregisteremailoxcontent1oxbaseshop */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangsal', 'ox:oxregisteremailoxcontent1oxbaseshop', 1, false),)), $this); ?>
Hello, <?php echo ((is_array($_tmp=$this->_tpl_vars['user']->oxuser__oxsal->value)) ? $this->_run_mod_handler('oxmultilangsal', true, $_tmp) : smarty_modifier_oxmultilangsal($_tmp)); ?>
 <?php echo $this->_tpl_vars['user']->oxuser__oxfname->value; ?>
 <?php echo $this->_tpl_vars['user']->oxuser__oxlname->value; ?>
, <br />
<br />
<p>
thank you for your registration at <?php echo $this->_tpl_vars['shop']->oxshops__oxname->value; ?>
!</p>
From now on, you can log in with your email <strong><?php echo $this->_tpl_vars['user']->oxuser__oxusername->value; ?>
</strong>.<br />
<br />
Your <?php echo $this->_tpl_vars['shop']->oxshops__oxname->value; ?>
 team<br />