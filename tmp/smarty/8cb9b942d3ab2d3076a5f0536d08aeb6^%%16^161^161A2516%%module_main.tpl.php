<?php /* Smarty version 2.6.28, created on 2018-10-15 11:13:50
         compiled from module_main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'module_main.tpl', 1, false),array('modifier', 'default', 'module_main.tpl', 34, false),array('function', 'oxscript', 'module_main.tpl', 4, false),array('function', 'oxmultilang', 'module_main.tpl', 33, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='GENERAL_ADMIN_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)),'box' => 'box')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['updatenav']): ?>
    <?php echo smarty_function_oxscript(array('add' => "top.oxid.admin.reloadNavigation('".($this->_tpl_vars['shopid'])."');",'priority' => 10), $this);?>

<?php endif; ?>

<form name="transfer" id="transfer" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

    <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
    <input type="hidden" name="cl" value="module_main">
    <input type="hidden" name="editlanguage" value="<?php echo $this->_tpl_vars['editlanguage']; ?>
">
</form>

<?php echo smarty_function_oxscript(array('include' => "js/libs/jquery.min.js"), $this);?>

<?php echo smarty_function_oxscript(array('include' => "js/libs/jquery-ui.min.js"), $this);?>


<?php if ($this->_tpl_vars['oModule']): ?>
    <table cellspacing="10" width="98%">
        <tr>
            <td width="245" valign="top">
                <?php if ($this->_tpl_vars['oModule']->getInfo('thumbnail')): ?>
                    <img src="<?php echo $this->_tpl_vars['oViewConf']->getBaseDir(); ?>
/modules/<?php echo $this->_tpl_vars['oModule']->getModulePath(); ?>
/<?php echo $this->_tpl_vars['oModule']->getInfo('thumbnail'); ?>
" hspace="20" vspace="10"></td>
                <?php else: ?>
                    <img src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
bg/module.png" hspace="20" vspace="10">
                <?php endif; ?>
            </td>
            <td width="" valign="top">
                <h1 style="color:#000;font-size:25px;"><?php echo $this->_tpl_vars['oModule']->getTitle(); ?>
</h1>
                <p><?php echo $this->_tpl_vars['oModule']->getDescription(); ?>
</p>
                <hr>

                <dl class="moduleDesc clear">
                    <dt><?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_VERSION'), $this);?>
</dt>
                    <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['oModule']->getInfo('version'))) ? $this->_run_mod_handler('default', true, $_tmp, '-') : smarty_modifier_default($_tmp, '-')); ?>
</dd>

                    <dt><?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_AUTHOR'), $this);?>
</dt>
                    <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['oModule']->getInfo('author'))) ? $this->_run_mod_handler('default', true, $_tmp, '-') : smarty_modifier_default($_tmp, '-')); ?>
</dd>

                    <dt><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_EMAIL'), $this);?>
</dt>
                    <dd>
                        <?php if ($this->_tpl_vars['oModule']->getInfo('email')): ?>
                            <a href="mailto:<?php echo $this->_tpl_vars['oModule']->getInfo('email'); ?>
"><?php echo $this->_tpl_vars['oModule']->getInfo('email'); ?>
</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </dd>

                    <dt><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_URL'), $this);?>
</dt>
                    <dd>
                        <?php if ($this->_tpl_vars['oModule']->getInfo('url')): ?>
                            <a href="<?php echo $this->_tpl_vars['oModule']->getInfo('url'); ?>
" target="_blank"><?php echo $this->_tpl_vars['oModule']->getInfo('url'); ?>
</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </dd>
                </dl>
            </td>

            <td width="25" style="border-right: 1px solid #ddd;">

            </td>
            <td width="260" valign="top">
                <?php if (! $this->_tpl_vars['oModule']->hasMetadata() && ! $this->_tpl_vars['oModule']->isRegistered()): ?>
                <div class="info">
                    <?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_ENABLEACTIVATIONTEXT'), $this);?>

                </div>
                <?php endif; ?>
                <?php if (! $this->_tpl_vars['_sError']): ?>
                    <?php if ($this->_tpl_vars['oModule']->hasMetadata() || $this->_tpl_vars['oModule']->isRegistered()): ?>
                        <form name="myedit" id="myedit" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
                            <div>
                                <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

                                <input type="hidden" name="cl" value="module_main">
                                <input type="hidden" name="updatelist" value="1">
                                <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oModule']->getId(); ?>
">

                                <?php if (! $this->_tpl_vars['oView']->isDemoShop()): ?>
                                    <?php if ($this->_tpl_vars['oModule']->hasMetadata()): ?>
                                        <?php if ($this->_tpl_vars['oModule']->isActive()): ?>
                                            <input type="hidden" name="fnc" value="deactivateModule">
                                            <div align="center">
                                                <input type="submit" id="module_deactivate" class="saveButton" value="<?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_DEACTIVATE'), $this);?>
">
                                            </div>
                                        <?php else: ?>
                                            <input type="hidden" name="fnc" value="activateModule">

                                            <div align="center">
                                                <input type="submit" id="module_activate" class="saveButton" value="<?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_ACTIVATE'), $this);?>
">
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_ACTIVATION_NOT_POSSIBLE_IN_DEMOMODE'), $this);?>

                                <?php endif; ?>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>
<?php endif; ?>

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