<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:15
         compiled from message/inputvalidation.tpl */ ?>
<?php $this->assign('sShopVersion', $this->_tpl_vars['oView']->getShopVersion()); ?>

<?php $_from = $this->_tpl_vars['aErrors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oError']):
?>
    <div class="alert alert-danger"><?php echo $this->_tpl_vars['oError']->getMessage(); ?>
</div>
<?php endforeach; endif; unset($_from); ?>