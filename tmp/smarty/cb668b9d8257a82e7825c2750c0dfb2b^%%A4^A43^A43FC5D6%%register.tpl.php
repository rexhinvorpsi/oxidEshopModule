<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:14
         compiled from page/account/register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxid_include_widget', 'page/account/register.tpl', 3, false),array('function', 'oxmultilang', 'page/account/register.tpl', 13, false),array('modifier', 'oxmultilangassign', 'page/account/register.tpl', 8, false),array('insert', 'oxid_tracker', 'page/account/register.tpl', 16, false),)), $this); ?>
<?php ob_start(); ?>
    <?php if ($this->_tpl_vars['oView']->isEnabledPrivateSales()): ?>
        <?php echo smarty_function_oxid_include_widget(array('cl' => 'oxwCookieNote','_parent' => $this->_tpl_vars['oView']->getClassName(),'nocookie' => 1), $this);?>

    <?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->append('oxidBlock_pageBody', ob_get_contents());ob_end_clean(); ?>

<?php ob_start(); ?>
    <?php $this->assign('template_title', ((is_array($_tmp='OPEN_ACCOUNT')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp))); ?>
    <?php if ($this->_tpl_vars['oView']->isActive('PsLogin')): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "message/errors.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

    <h1 id="openAccHeader" class="page-header"><?php echo smarty_function_oxmultilang(array('ident' => 'OPEN_ACCOUNT'), $this);?>
</h1>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/register.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/page.tpl", 'smarty_include_vars' => array('sidebar' => 'Right')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>