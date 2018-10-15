<?php /* Smarty version 2.6.28, created on 2018-10-15 10:11:29
         compiled from widget/product/selectbox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxmultilang', 'widget/product/selectbox.tpl', 6, false),array('modifier', 'default', 'widget/product/selectbox.tpl', 26, false),)), $this); ?>
<?php $this->assign('oSelections', $this->_tpl_vars['oSelectionList']->getSelections()); ?>

<?php if ($this->_tpl_vars['oSelections']): ?>
    <div class="selectbox dropDown">
        <?php if (! $this->_tpl_vars['blHideLabel']): ?>
            <p class="variant-label"><strong><?php echo $this->_tpl_vars['oSelectionList']->getLabel(); ?>
<?php echo smarty_function_oxmultilang(array('ident' => 'COLON'), $this);?>
</strong></p>
        <?php endif; ?>
        <div class="dropdown-wrapper">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                <?php $this->assign('oActiveSelection', $this->_tpl_vars['oSelectionList']->getActiveSelection()); ?>
                <?php if ($this->_tpl_vars['oActiveSelection']): ?>
                    <span class="pull-left"><?php echo $this->_tpl_vars['oActiveSelection']->getName(); ?>
</span>
                <?php elseif (! $this->_tpl_vars['blHideDefault']): ?>
                    <span class="pull-left">
                        <?php if ($this->_tpl_vars['sFieldName'] == 'sel'): ?>
                            <?php echo smarty_function_oxmultilang(array('ident' => 'PLEASE_CHOOSE'), $this);?>

                        <?php else: ?>
                            <?php echo $this->_tpl_vars['oSelectionList']->getLabel(); ?>
 <?php echo smarty_function_oxmultilang(array('ident' => 'CHOOSE_VARIANT'), $this);?>

                        <?php endif; ?>
                    </span>
                <?php endif; ?>

                <i class="fa fa-angle-down pull-right"></i>
            </button>
            <?php if ($this->_tpl_vars['editable'] !== false): ?>
                <input type="hidden" name="<?php echo ((is_array($_tmp=@$this->_tpl_vars['sFieldName'])) ? $this->_run_mod_handler('default', true, $_tmp, 'varselid') : smarty_modifier_default($_tmp, 'varselid')); ?>
[<?php echo $this->_tpl_vars['iKey']; ?>
]" value="<?php if ($this->_tpl_vars['oActiveSelection']): ?><?php echo $this->_tpl_vars['oActiveSelection']->getValue(); ?>
<?php endif; ?>">
                <ul class="dropdown-menu <?php echo $this->_tpl_vars['sJsAction']; ?>
<?php if ($this->_tpl_vars['sFieldName'] != 'sel'): ?> vardrop<?php endif; ?>" role="menu">
                    <?php if ($this->_tpl_vars['oActiveSelection'] && ! $this->_tpl_vars['blHideDefault']): ?>
                        <li>
                            <a href="#" rel="">
                                <?php if ($this->_tpl_vars['sFieldName'] == 'sel'): ?>
                                    <?php echo smarty_function_oxmultilang(array('ident' => 'PLEASE_CHOOSE'), $this);?>

                                <?php else: ?>
                                    <?php echo smarty_function_oxmultilang(array('ident' => 'CHOOSE_VARIANT'), $this);?>

                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php $_from = $this->_tpl_vars['oSelections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oSelection']):
?>
                        <li class="<?php if ($this->_tpl_vars['oSelection']->isDisabled()): ?>disabled js-disabled<?php endif; ?>">
                            <a href="<?php echo $this->_tpl_vars['oSelection']->getLink(); ?>
" data-selection-id="<?php echo $this->_tpl_vars['oSelection']->getValue(); ?>
" class="<?php if ($this->_tpl_vars['oSelection']->isActive()): ?>active<?php endif; ?>"><?php echo $this->_tpl_vars['oSelection']->getName(); ?>
</a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>