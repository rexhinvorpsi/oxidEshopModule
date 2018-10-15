<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:05
         compiled from widget/locator/attributes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxmultilang', 'widget/locator/attributes.tpl', 17, false),)), $this); ?>

    <?php if ($this->_tpl_vars['attributes']): ?>
        <div class="row">
            <form method="get" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfActionLink(); ?>
" name="_filterlist" id="filterList">
                <div class="hidden">
                    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

                    <?php echo $this->_tpl_vars['oViewConf']->getNavFormParams(); ?>

                    <input type="hidden" name="cl" value="<?php echo $this->_tpl_vars['oViewConf']->getActiveClassName(); ?>
">
                    <input type="hidden" name="tpl" value="<?php echo $this->_tpl_vars['oViewConf']->getActTplName(); ?>
">
                    <input type="hidden" name="oxloadid" value="<?php echo $this->_tpl_vars['oViewConf']->getActContentLoadId(); ?>
">
                    <input type="hidden" name="fnc" value="executefilter">
                    <input type="hidden" name="fname" value="">
                </div>

                <div class="list-filter">
                    <?php if ($this->_tpl_vars['oView']->getClassName() == 'alist'): ?>
                        <strong><?php echo smarty_function_oxmultilang(array('ident' => 'DD_LISTLOCATOR_FILTER_ATTRIBUTES'), $this);?>
</strong>
                    <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attr'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attr']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sAttrID'] => $this->_tpl_vars['oFilterAttr']):
        $this->_foreach['attr']['iteration']++;
?>
                            <?php $this->assign('sActiveValue', $this->_tpl_vars['oFilterAttr']->getActiveValue()); ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <strong><?php echo $this->_tpl_vars['oFilterAttr']->getTitle(); ?>
:</strong>
                                    <?php if ($this->_tpl_vars['sActiveValue']): ?>
                                        <?php echo $this->_tpl_vars['sActiveValue']; ?>

                                    <?php else: ?>
                                        <?php echo smarty_function_oxmultilang(array('ident' => 'PLEASE_CHOOSE'), $this);?>

                                    <?php endif; ?>
                                    <span class="caret"></span>
                                </button>
                                <input type="hidden" name="attrfilter[<?php echo $this->_tpl_vars['sAttrID']; ?>
]" value="<?php echo $this->_tpl_vars['sActiveValue']; ?>
">
                                <ul class="dropdown-menu" role="menu">
                                    <?php if ($this->_tpl_vars['sActiveValue']): ?>
                                        <li><a data-selection-id="" href="#"><?php echo smarty_function_oxmultilang(array('ident' => 'PLEASE_CHOOSE'), $this);?>
</a></li>
                                    <?php endif; ?>
                                    <?php $_from = $this->_tpl_vars['oFilterAttr']->getValues(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sValue']):
?>
                                        <li><a data-selection-id="<?php echo $this->_tpl_vars['sValue']; ?>
" href="#" <?php if ($this->_tpl_vars['sActiveValue'] == $this->_tpl_vars['sValue']): ?>class="selected"<?php endif; ?> ><?php echo $this->_tpl_vars['sValue']; ?>
</a></li>
                                    <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            </div>
                        <?php endforeach; endif; unset($_from); ?>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    <?php endif; ?>