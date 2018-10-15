<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:15
         compiled from form/fieldset/salutation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', 'form/fieldset/salutation.tpl', 2, false),array('function', 'oxmultilang', 'form/fieldset/salutation.tpl', 2, false),)), $this); ?>
<select name="<?php echo $this->_tpl_vars['name']; ?>
" <?php if ($this->_tpl_vars['class']): ?>class="<?php echo $this->_tpl_vars['class']; ?>
"<?php endif; ?> <?php if ($this->_tpl_vars['id']): ?>id="<?php echo $this->_tpl_vars['id']; ?>
"<?php endif; ?>>
    <option value="MRS" <?php if (((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'mrs' || ((is_array($_tmp=$this->_tpl_vars['value2'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'mrs'): ?>SELECTED<?php endif; ?>><?php echo smarty_function_oxmultilang(array('ident' => 'MRS'), $this);?>
</option>
    <option value="MR"  <?php if (((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'mr' || ((is_array($_tmp=$this->_tpl_vars['value2'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'mr'): ?>SELECTED<?php endif; ?>><?php echo smarty_function_oxmultilang(array('ident' => 'MR'), $this);?>
</option>
</select>