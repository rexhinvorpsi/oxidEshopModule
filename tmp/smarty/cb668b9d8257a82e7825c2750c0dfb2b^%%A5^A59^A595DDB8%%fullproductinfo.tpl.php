<?php /* Smarty version 2.6.28, created on 2018-10-14 21:24:31
         compiled from page/details/inc/fullproductinfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxmultilang', 'page/details/inc/fullproductinfo.tpl', 14, false),)), $this); ?>
<div id="detailsMain">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page/details/inc/productmain.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<div id="detailsRelated" class="detailsRelated clear">
    <div class="relatedInfo<?php if (! $this->_tpl_vars['oView']->getSimilarProducts() && ! $this->_tpl_vars['oView']->getCrossSelling() && ! $this->_tpl_vars['oView']->getAccessoires()): ?> relatedInfoFull<?php endif; ?>">
        <div class="row">
            <div class="col-xs-12">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page/details/inc/tabs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                <?php if ($this->_tpl_vars['oView']->isReviewActive()): ?>
                    <div class="spacer"></div>
                    <div class="widgetBox reviews">
                        <div class="h2 page-header"><?php echo smarty_function_oxmultilang(array('ident' => 'WRITE_PRODUCT_REVIEW'), $this);?>
</div>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "widget/reviews/reviews.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <hr>
    </div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page/details/inc/related_products.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>