<?php /* Smarty version 2.6.28, created on 2018-10-14 21:25:16
         compiled from widget/sidebar/tags.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxgetseourl', 'widget/sidebar/tags.tpl', 32, false),array('function', 'oxmultilang', 'widget/sidebar/tags.tpl', 32, false),array('modifier', 'cat', 'widget/sidebar/tags.tpl', 32, false),)), $this); ?>

    <?php $this->assign('oTagsManager', $this->_tpl_vars['oView']->getTagCloudManager()); ?>

    <?php if ($this->_tpl_vars['oView']->getTagCloudManager()): ?>

        <?php if ($this->_tpl_vars['oView']->displayInBox()): ?>
                        <div id="tagBox" class="box tagCloud">
                <div class="content">
        <?php else: ?>
            <div class="categoryTagsBox">
                <div class="categoryTags">
        <?php endif; ?>
        <?php $_from = $this->_tpl_vars['oTagsManager']->getCloudArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sTagTitle'] => $this->_tpl_vars['oTag']):
?>
            <?php $this->assign('iTagSize', $this->_tpl_vars['oTagsManager']->getTagSize($this->_tpl_vars['sTagTitle'])); ?>
            <?php $this->assign('sTagPriority', "label-default"); ?>
            <?php if ($this->_tpl_vars['iTagSize'] < 100): ?>
                <?php $this->assign('sTagPriority', "label-primary"); ?>
            <?php elseif ($this->_tpl_vars['iTagSize'] < 200): ?>
                <?php $this->assign('sTagPriority', "label-info"); ?>
            <?php elseif ($this->_tpl_vars['iTagSize'] < 300): ?>
                <?php $this->assign('sTagPriority', "label-warning"); ?>
            <?php elseif ($this->_tpl_vars['iTagSize'] < 400): ?>
                <?php $this->assign('sTagPriority', "label-danger"); ?>
            <?php endif; ?>
            <a class="label <?php echo $this->_tpl_vars['sTagPriority']; ?>
 tagitem_<?php echo $this->_tpl_vars['oTagsManager']->getTagSize($this->_tpl_vars['sTagTitle']); ?>
" href="<?php echo $this->_tpl_vars['oTag']->getLink(); ?>
"><?php echo $this->_tpl_vars['oTag']->getTitle(); ?>
</a>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['oView']->isMoreTagsVisible()): ?>
            
                <p class="text-right">
                    <a href="<?php echo smarty_function_oxgetseourl(array('ident' => ((is_array($_tmp=$this->_tpl_vars['oViewConf']->getSelfLink())) ? $this->_run_mod_handler('cat', true, $_tmp, "cl=tags") : smarty_modifier_cat($_tmp, "cl=tags"))), $this);?>
" class="btn btn-primary btn-sm"><?php echo smarty_function_oxmultilang(array('ident' => 'MORE'), $this);?>
</a>
                </p>
            
        <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
