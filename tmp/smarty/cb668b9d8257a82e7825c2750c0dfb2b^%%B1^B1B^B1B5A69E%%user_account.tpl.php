<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:14
         compiled from form/fieldset/user_account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxmultilang', 'form/fieldset/user_account.tpl', 3, false),)), $this); ?>
<div class="form-group<?php if ($this->_tpl_vars['aErrors']['oxuser__oxusername']): ?> oxInValid<?php endif; ?>">
    
        <label class="control-label col-lg-3 req" for="userLoginName"><?php echo smarty_function_oxmultilang(array('ident' => 'EMAIL_ADDRESS'), $this);?>
</label>
        <div class="col-lg-9">
            <input id="userLoginName" class="form-control js-oxValidate js-oxValidate_notEmpty js-oxValidate_email" type="email" name="lgn_usr" value="<?php echo $this->_tpl_vars['oView']->getActiveUsername(); ?>
" required="required">
            <div class="help-block"></div>
        </div>
    
</div>
<div class="form-group<?php if ($this->_tpl_vars['aErrors']['oxuser__oxpassword']): ?> oxInValid<?php endif; ?>">
    
        <label class="control-label col-lg-3 req" for="userPassword"><?php echo smarty_function_oxmultilang(array('ident' => 'PASSWORD'), $this);?>
</label>
        <input type="hidden" id="passwordLength" value="<?php echo $this->_tpl_vars['oViewConf']->getPasswordLength(); ?>
">
        <div class="col-lg-9">
            <input id="userPassword" class="form-control textbox js-oxValidate js-oxValidate_notEmpty js-oxValidate_length js-oxValidate_match" type="password" name="lgn_pwd" value="<?php echo $this->_tpl_vars['lgn_pwd']; ?>
" required="required">
            <div class="help-block"></div>
        </div>
    
</div>
<div class="form-group<?php if ($this->_tpl_vars['aErrors']['oxuser__oxpassword']): ?> oxInValid<?php endif; ?>">
    
        <label class="control-label col-lg-3 req"><?php echo smarty_function_oxmultilang(array('ident' => 'CONFIRM_PASSWORD'), $this);?>
</label>
        <div class="col-lg-9">
            <input id="userPasswordConfirm" class="form-control textbox js-oxValidate js-oxValidate_notEmpty js-oxValidate_length js-oxValidate_match" type="password" name="lgn_pwd2" value="<?php echo $this->_tpl_vars['lgn_pwd2']; ?>
" required="required">
            <div class="help-block"></div>
        </div>
    
</div>
<div class="form-group">
    
        <div class="col-lg-9 col-lg-offset-3">
            <input type="hidden" name="blnewssubscribed" value="0">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="blnewssubscribed" value="1" <?php if ($this->_tpl_vars['oView']->isNewsSubscribed()): ?>checked<?php endif; ?>> <?php echo smarty_function_oxmultilang(array('ident' => 'NEWSLETTER_SUBSCRIPTION'), $this);?>

                </label>
            </div>
            <span class="help-block"><?php echo smarty_function_oxmultilang(array('ident' => 'MESSAGE_NEWSLETTER_SUBSCRIPTION'), $this);?>
</span>
        </div>
    
</div>