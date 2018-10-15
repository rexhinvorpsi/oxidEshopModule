<?php /* Smarty version 2.6.28, created on 2018-10-14 21:26:09
         compiled from page/account/register_success.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'page/account/register_success.tpl', 2, false),array('function', 'oxmultilang', 'page/account/register_success.tpl', 3, false),array('insert', 'oxid_tracker', 'page/account/register_success.tpl', 17, false),)), $this); ?>
<?php ob_start(); ?>
    <?php $this->assign('template_title', ((is_array($_tmp='MESSAGE_WELCOME_REGISTERED_USER')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp))); ?>
    <h1 id="openAccHeader" class="page-header"><?php echo smarty_function_oxmultilang(array('ident' => 'MESSAGE_WELCOME_REGISTERED_USER'), $this);?>
</h1>
    <div class="box info">
      <?php if ($this->_tpl_vars['oView']->getRegistrationStatus() == 1): ?>
        <?php echo smarty_function_oxmultilang(array('ident' => 'MESSAGE_CONFIRMING_REGISTRATION'), $this);?>

      <?php elseif ($this->_tpl_vars['oView']->getRegistrationStatus() == 2): ?>
        <?php echo smarty_function_oxmultilang(array('ident' => 'MESSAGE_SENT_CONFIRMATION_EMAIL'), $this);?>

      <?php endif; ?>

      <?php if ($this->_tpl_vars['oView']->getRegistrationError() == 4): ?>
        <div>
          <?php echo smarty_function_oxmultilang(array('ident' => 'MESSAGE_NOT_ABLE_TO_SEND_EMAIL'), $this);?>

        </div>
      <?php endif; ?>
    </div>
    <?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'oxid_tracker', 'title' => $this->_tpl_vars['template_title'])), $this); ?>

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->append('oxidBlock_content', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['oView']->isActive('PsLogin')): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/popup.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/page.tpl", 'smarty_include_vars' => array('sidebar' => 'Left')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>