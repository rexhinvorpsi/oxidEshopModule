<?php /* Smarty version 2.6.28, created on 2018-10-14 21:24:34
         compiled from page/details/inc/media.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'page/details/inc/media.tpl', 10, false),)), $this); ?>
<?php $this->assign('oConfig', $this->_tpl_vars['oViewConf']->getConfig()); ?>
<?php if ($this->_tpl_vars['oDetailsProduct']->oxarticles__oxfile->value): ?>
    <a id="productFile" href="<?php echo $this->_tpl_vars['oConfig']->getPictureUrl('media/'); ?>
<?php echo $this->_tpl_vars['oDetailsProduct']->oxarticles__oxfile->value; ?>
"><?php echo $this->_tpl_vars['oDetailsProduct']->oxarticles__oxfile->value; ?>
</a>
<?php endif; ?>

<?php if ($this->_tpl_vars['oView']->getMediaFiles()): ?>
    <?php $_from = $this->_tpl_vars['oView']->getMediaFiles(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mediaURLs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mediaURLs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oMediaUrl']):
        $this->_foreach['mediaURLs']['iteration']++;
?>
        <?php $this->assign('sUrl', $this->_tpl_vars['oMediaUrl']->oxmediaurls__oxurl->value); ?>
        <?php $this->assign('blIsYouTubeMedia', false); ?>
        <?php if (((is_array($_tmp=$this->_tpl_vars['sUrl'])) ? $this->_run_mod_handler('strpos', true, $_tmp, 'youtube.com') : strpos($_tmp, 'youtube.com')) || ((is_array($_tmp=$this->_tpl_vars['sUrl'])) ? $this->_run_mod_handler('strpos', true, $_tmp, 'youtu.be') : strpos($_tmp, 'youtu.be'))): ?>
            <?php $this->assign('blIsYouTubeMedia', true); ?>
        <?php endif; ?>

        <?php if (! ($this->_foreach['mediaURLs']['iteration'] <= 1)): ?>
            <hr/>
        <?php endif; ?>
        <div class="<?php if ($this->_tpl_vars['blIsYouTubeMedia']): ?>embed-responsive embed-responsive-4by3<?php endif; ?>">
            <?php echo $this->_tpl_vars['oMediaUrl']->getHtml(); ?>

        </div>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>