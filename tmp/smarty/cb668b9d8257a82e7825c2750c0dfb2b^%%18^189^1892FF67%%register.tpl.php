<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:14
         compiled from form/register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxscript', 'form/register.tpl', 1, false),array('function', 'oxmultilang', 'form/register.tpl', 15, false),array('block', 'oxifcontent', 'form/register.tpl', 26, false),)), $this); ?>
<?php echo smarty_function_oxscript(array('include' => "js/libs/jqBootstrapValidation.min.js",'priority' => 10), $this);?>

<?php echo smarty_function_oxscript(array('add' => "$('input,select,textarea').not('[type=submit]').jqBootstrapValidation();"), $this);?>

<form class="form-horizontal" action="<?php echo $this->_tpl_vars['oViewConf']->getSslSelfLink(); ?>
" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        <?php $this->assign('aErrors', $this->_tpl_vars['oView']->getFieldValidationErrors()); ?>
        <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

        <?php echo $this->_tpl_vars['oViewConf']->getNavFormParams(); ?>

        <input type="hidden" name="fnc" value="registeruser">
        <input type="hidden" name="cl" value="register">
        <input type="hidden" name="lgn_cook" value="0">
        <input type="hidden" id="reloadAddress" name="reloadaddress" value="">
        <input type="hidden" name="option" value="3">
    </div>

    <h3 class="blockHead"><?php echo smarty_function_oxmultilang(array('ident' => 'ACCOUNT_INFORMATION'), $this);?>
</h3>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/fieldset/user_account.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if ($this->_tpl_vars['oView']->isActive('PsLogin')): ?>
        <div class="form-group">
            <label class="control-label col-lg-3"><?php echo smarty_function_oxmultilang(array('ident' => 'TERMS_AND_CONDITIONS'), $this);?>
</label>
            <div class="col-lg-9">
                <input type="hidden" name="ord_agb" value="0">
                <div class="checkbox">
                    <label>
                        <input id="orderConfirmAgbBottom" type="checkbox" class="checkbox" name="ord_agb" value="1">
                        <?php $this->_tag_stack[] = array('oxifcontent', array('ident' => 'oxagb','object' => 'oCont')); $_block_repeat=true;smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                            <?php echo smarty_function_oxmultilang(array('ident' => 'FORM_REGISTER_IAGREETOTERMS1'), $this);?>

                                <a href="#" data-toggle="modal" data-target="#popup1"><?php echo smarty_function_oxmultilang(array('ident' => 'TERMS_AND_CONDITIONS'), $this);?>
</a>
                            <?php echo smarty_function_oxmultilang(array('ident' => 'FORM_REGISTER_IAGREETOTERMS3'), $this);?>
,&nbsp;
                        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                        <?php $this->_tag_stack[] = array('oxifcontent', array('ident' => 'oxrightofwithdrawal','object' => 'oCont')); $_block_repeat=true;smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                            <?php echo smarty_function_oxmultilang(array('ident' => 'FORM_REGISTER_IAGREETORIGHTOFWITHDRAWAL1'), $this);?>

                                <a href="#" data-toggle="modal" data-target="#popup2"><?php echo $this->_tpl_vars['oCont']->oxcontents__oxtitle->value; ?>
</a>
                            <?php echo smarty_function_oxmultilang(array('ident' => 'FORM_REGISTER_IAGREETORIGHTOFWITHDRAWAL3'), $this);?>

                        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    </label>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <h3 class="blockHead"><?php echo smarty_function_oxmultilang(array('ident' => 'BILLING_ADDRESS'), $this);?>
</h3>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/fieldset/user_billing.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</form>
<?php if ($this->_tpl_vars['oView']->isActive('PsLogin')): ?>
    <?php $this->_tag_stack[] = array('oxifcontent', array('ident' => 'oxagb','object' => 'oContent')); $_block_repeat=true;smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <div class="modal fade" id="popup1" tabindex="-1" role="dialog" aria-labelledby="popup1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <span class="h4 modal-title" id="popup1Label"><?php echo $this->_tpl_vars['oContent']->oxcontents__oxtitle->value; ?>
</span>
                    </div>
                    <div class="modal-body"><?php echo $this->_tpl_vars['oContent']->oxcontents__oxcontent->value; ?>
</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo smarty_function_oxmultilang(array('ident' => 'DD_CLOSE_MODAL'), $this);?>
</button>
                    </div>
                </div>
            </div>
        </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    <?php $this->_tag_stack[] = array('oxifcontent', array('ident' => 'oxrightofwithdrawal','object' => 'oContent')); $_block_repeat=true;smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <div class="modal fade" id="popup2" tabindex="-1" role="dialog" aria-labelledby="popup2Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <span class="h4 modal-title" id="popup2Label"><?php echo $this->_tpl_vars['oContent']->oxcontents__oxtitle->value; ?>
</span>
                    </div>
                    <div class="modal-body"><?php echo $this->_tpl_vars['oContent']->oxcontents__oxcontent->value; ?>
</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo smarty_function_oxmultilang(array('ident' => 'DD_CLOSE_MODAL'), $this);?>
</button>
                    </div>
                </div>
            </div>
        </div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxifcontent($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php endif; ?>