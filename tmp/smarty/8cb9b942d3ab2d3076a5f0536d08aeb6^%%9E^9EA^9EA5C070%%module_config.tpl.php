<?php /* Smarty version 2.6.28, created on 2018-10-17 00:02:46
         compiled from module_config.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'module_config.tpl', 1, false),array('modifier', 'escape', 'module_config.tpl', 79, false),array('function', 'cycle', 'module_config.tpl', 41, false),array('function', 'oxmultilang', 'module_config.tpl', 47, false),array('function', 'oxinputhelp', 'module_config.tpl', 90, false),array('function', 'oxscript', 'module_config.tpl', 108, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='GENERAL_ADMIN_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)),'box' => 'box')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
<!--
function _groupExp(el) {
    var _cur = el.parentNode;

    if (_cur.className == "exp") _cur.className = "";
      else _cur.className = "exp";
}
//-->
</script>

<?php if ($this->_tpl_vars['readonly']): ?>
    <?php $this->assign('readonly', 'readonly disabled'); ?>
<?php else: ?>
    <?php $this->assign('readonly', ""); ?>
<?php endif; ?>



<form name="transfer" id="transfer" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

    <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oModule']->getInfo('id'); ?>
">
    <input type="hidden" name="cl" value="module_config">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="actshop" value="<?php echo $this->_tpl_vars['oViewConf']->getActiveShopId(); ?>
">
    <input type="hidden" name="updatenav" value="">
    <input type="hidden" name="editlanguage" value="<?php echo $this->_tpl_vars['editlanguage']; ?>
">
</form>

<form name="module_configuration" id="moduleConfiguration" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
<?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

<input type="hidden" name="cl" value="module_config">
<input type="hidden" name="fnc" value="save">
<input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oModule']->getInfo('id'); ?>
">
<input type="hidden" name="editval[oxshops__oxid]" value="<?php echo $this->_tpl_vars['oxid']; ?>
">



<?php echo smarty_function_cycle(array('assign' => '_clear_','values' => ",2"), $this);?>


    <?php $_from = $this->_tpl_vars['var_grouping']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['var_group'] => $this->_tpl_vars['var_list']):
?>
        
        <div class="groupExp">
            <div class="">
                <a href="#" onclick="_groupExp(this);return false;" class="rc"><b><?php echo smarty_function_oxmultilang(array('ident' => "SHOP_MODULE_GROUP_".($this->_tpl_vars['var_group'])), $this);?>
</b></a>
                <?php $_from = $this->_tpl_vars['var_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_var'] => $this->_tpl_vars['var_type']):
?>
                    
                    <dl>
                        <dt>
                            
                            
                            <?php if ($this->_tpl_vars['var_type'] == 'bool'): ?>
                                
                                <input type=hidden name="confbools[<?php echo $this->_tpl_vars['module_var']; ?>
]" value=false>
                                <input type=checkbox name="confbools[<?php echo $this->_tpl_vars['module_var']; ?>
]" value=true  <?php if (( $this->_tpl_vars['confbools'][$this->_tpl_vars['module_var']] )): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['readonly']; ?>
>
                                
                            <?php elseif ($this->_tpl_vars['var_type'] == 'str'): ?>
                                
                                <input type=text  class="txt" style="width: 250px;" name="confstrs[<?php echo $this->_tpl_vars['module_var']; ?>
]" value="<?php echo $this->_tpl_vars['confstrs'][$this->_tpl_vars['module_var']]; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                                
                            <?php elseif ($this->_tpl_vars['var_type'] == 'num'): ?>
                                
                                <input type=text  class="txt" style="width: 50px;" name="confnum[<?php echo $this->_tpl_vars['module_var']; ?>
]" value="<?php echo $this->_tpl_vars['confnum'][$this->_tpl_vars['module_var']]; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                                
                            <?php elseif ($this->_tpl_vars['var_type'] == 'arr'): ?>
                                
                                <textarea class="txtfield" name="confarrs[<?php echo $this->_tpl_vars['module_var']; ?>
]" <?php echo $this->_tpl_vars['readonly']; ?>
><?php echo $this->_tpl_vars['confarrs'][$this->_tpl_vars['module_var']]; ?>
</textarea>
                                
                            <?php elseif ($this->_tpl_vars['var_type'] == 'aarr'): ?>
                                
                                <textarea class="txtfield" style="width: 430px;" name="confaarrs[<?php echo $this->_tpl_vars['module_var']; ?>
]" wrap="off" <?php echo $this->_tpl_vars['readonly']; ?>
><?php echo $this->_tpl_vars['confaarrs'][$this->_tpl_vars['module_var']]; ?>
</textarea>
                                
                            <?php elseif ($this->_tpl_vars['var_type'] == 'select'): ?>
                                
                                <select class="select" name="confselects[<?php echo $this->_tpl_vars['module_var']; ?>
]" <?php echo $this->_tpl_vars['readonly']; ?>
>
                                    <?php $_from = $this->_tpl_vars['var_constraints'][$this->_tpl_vars['module_var']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_field']):
?>
                                        <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['_field'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"  <?php if (( $this->_tpl_vars['confselects'][$this->_tpl_vars['module_var']] == $this->_tpl_vars['_field'] )): ?>selected<?php endif; ?>><?php echo smarty_function_oxmultilang(array('ident' => "SHOP_MODULE_".($this->_tpl_vars['module_var'])."_".($this->_tpl_vars['_field'])), $this);?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                                
                            <?php elseif ($this->_tpl_vars['var_type'] == 'password'): ?>
                                
                                <input class="password_input" type="password" style="width: 250px;" name="confpassword[<?php echo $this->_tpl_vars['module_var']; ?>
]" data-empty="<?php if ($this->_tpl_vars['confpassword'][$this->_tpl_vars['module_var']]): ?>false<?php else: ?>true<?php endif; ?>" data-errorMessage="<?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_PASSWORDS_DO_NOT_MATCH'), $this);?>
" <?php echo $this->_tpl_vars['readonly']; ?>
 title="<?php echo smarty_function_oxmultilang(array('ident' => 'MODULE_REPEAT_PASSWORD'), $this);?>
">
                                
                            <?php endif; ?>
                            
                            
                            <?php echo smarty_function_oxinputhelp(array('ident' => "HELP_SHOP_MODULE_".($this->_tpl_vars['module_var'])), $this);?>

                        </dt>
                        <dd>
                            <?php echo smarty_function_oxmultilang(array('ident' => "SHOP_MODULE_".($this->_tpl_vars['module_var'])), $this);?>

                        </dd>
                        <div class="spacer"></div>
                    </dl>
                    
                <?php endforeach; endif; unset($_from); ?>
             </div>
         </div>
         
    <?php endforeach; endif; unset($_from); ?>
<br>
<?php if ($this->_tpl_vars['var_grouping']): ?>
    <input type="submit" class="confinput" name="save" value="<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_SAVE'), $this);?>
" onClick="Javascript:document.module_configuration.fnc.value='save'" <?php echo $this->_tpl_vars['readonly']; ?>
>
<?php endif; ?>

<?php echo smarty_function_oxscript(array('include' => "js/libs/jquery.min.js"), $this);?>

<?php echo smarty_function_oxscript(array('include' => "js/libs/jquery-ui.min.js"), $this);?>

<?php echo smarty_function_oxscript(array('include' => "js/widgets/oxmoduleconfiguration.js"), $this);?>


<?php echo smarty_function_oxscript(array('add' => "$('#moduleConfiguration').oxModuleConfiguration();",'priority' => 10), $this);?>

<?php echo smarty_function_oxscript(array('add' => "$.noConflict();",'priority' => 10), $this);?>





</form>
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