<?php /* Smarty version 2.6.28, created on 2018-10-14 20:49:45
         compiled from article_pictures.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'article_pictures.tpl', 2, false),array('function', 'oxmultilang', 'article_pictures.tpl', 58, false),array('function', 'oxinputhelp', 'article_pictures.tpl', 58, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='GENERAL_ADMIN_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
<!--
function DeletePic( iIndex )
{
    var oForm = document.getElementById("myedit");
    oForm.fnc.value="deletePicture";
    oForm.masterPicIndex.value=iIndex;

    oForm.submit();
}
function editThis( sID )
{
    var oTransfer = top.basefrm.edit.document.getElementById( "transfer" );
    oTransfer.oxid.value = sID;
    oTransfer.cl.value = top.basefrm.list.sDefClass;

    //forcing edit frame to reload after submit
    top.forceReloadingEditFrame();

    var oSearch = top.basefrm.list.document.getElementById( "search" );
    oSearch.oxid.value = sID;
    oSearch.actedit.value = 0;
    oSearch.submit();
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

    <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
    <input type="hidden" name="cl" value="article_pictures">
    <input type="hidden" name="editlanguage" value="<?php echo $this->_tpl_vars['editlanguage']; ?>
">
</form>

<form name="myedit" id="myedit" enctype="multipart/form-data" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->_tpl_vars['iMaxUploadFileSize']; ?>
">
<?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

<input type="hidden" name="cl" value="article_pictures">
<input type="hidden" name="fnc" value="">
<input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
<input type="hidden" name="editval[article__oxid]" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
<input type="hidden" name="voxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
<input type="hidden" name="oxparentid" value="<?php echo $this->_tpl_vars['oxparentid']; ?>
">
<input type="hidden" name="masterPicIndex" value="">

<?php if ($this->_tpl_vars['oViewConf']->isAltImageServerConfigured()): ?>
    <div class="warning"><?php echo smarty_function_oxmultilang(array('ident' => 'ALTERNATIVE_IMAGE_SERVER_NOTE'), $this);?>
 <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ALTERNATIVE_IMAGE_SERVER_NOTE'), $this);?>
</div>
<?php endif; ?>





    <table cellspacing="0" cellpadding="0" width="98%" border="0">
      <colgroup>
          <col width="1%" nowrap>
          <col width="99%">
      </colgroup>

      <tr>
        <td class="picPreviewCol" valign="top">
            <?php $this->assign('sThumbUrl', $this->_tpl_vars['edit']->getThumbnailUrl()); ?>

            <div class="picPreview"><?php if ($this->_tpl_vars['sThumbUrl']): ?><img src="<?php echo $this->_tpl_vars['sThumbUrl']; ?>
"><?php endif; ?></div>
            <div class="picDescr"><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_THUMB'), $this);?>
</div>
            <br>
            <div class="picPreview" width="100%" align="center"><img src="<?php echo $this->_tpl_vars['edit']->getIconUrl(); ?>
"></div>
            <div class="picDescr"><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_ICON'), $this);?>
</div>
        </td>

        <td class="picEditCol">

            <!-- ARTICLE MAIN PICTURES -->
            <table cellspacing="0" cellpadding="0" width="100%" border="0" class="listTable">
              
                  <colgroup>
                      <col width="2%">
                      <col width="1%" nowrap>
                      <col width="1%">
                      <col width="10%" nowrap>
                      <col width="95%">
                  </colgroup>
                  <tr>
                      <th colspan="5" valign="top">
                         <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_ARTICLE_PICTURES'), $this);?>
 (<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_FILE_UPLOAD'), $this);?>
 <?php echo $this->_tpl_vars['sMaxFormattedFileSize']; ?>
, <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_PICTURE_DIMENSIONS'), $this);?>
)
                         <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_PICTURES_PIC1'), $this);?>

                      </th>
                  </tr>

                 <?php if ($this->_tpl_vars['oxparentid']): ?>
                  <tr>
                    <td class="index" colspan="5">
                          <b><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_VARIANTE'), $this);?>
</b>
                          <a href="Javascript:editThis('<?php echo $this->_tpl_vars['parentarticle']->oxarticles__oxid->value; ?>
');" class="edittext"><b>"<?php echo $this->_tpl_vars['parentarticle']->oxarticles__oxartnum->value; ?>
 <?php echo $this->_tpl_vars['parentarticle']->oxarticles__oxtitle->value; ?>
"</b></a>
                    </td>
                  </tr>
                 <?php endif; ?>

                  <?php unset($this->_sections['picRow']);
$this->_sections['picRow']['name'] = 'picRow';
$this->_sections['picRow']['start'] = (int)1;
$this->_sections['picRow']['loop'] = is_array($_loop=$this->_tpl_vars['iPicCount']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['picRow']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['picRow']['show'] = true;
$this->_sections['picRow']['max'] = $this->_sections['picRow']['loop'];
if ($this->_sections['picRow']['start'] < 0)
    $this->_sections['picRow']['start'] = max($this->_sections['picRow']['step'] > 0 ? 0 : -1, $this->_sections['picRow']['loop'] + $this->_sections['picRow']['start']);
else
    $this->_sections['picRow']['start'] = min($this->_sections['picRow']['start'], $this->_sections['picRow']['step'] > 0 ? $this->_sections['picRow']['loop'] : $this->_sections['picRow']['loop']-1);
if ($this->_sections['picRow']['show']) {
    $this->_sections['picRow']['total'] = min(ceil(($this->_sections['picRow']['step'] > 0 ? $this->_sections['picRow']['loop'] - $this->_sections['picRow']['start'] : $this->_sections['picRow']['start']+1)/abs($this->_sections['picRow']['step'])), $this->_sections['picRow']['max']);
    if ($this->_sections['picRow']['total'] == 0)
        $this->_sections['picRow']['show'] = false;
} else
    $this->_sections['picRow']['total'] = 0;
if ($this->_sections['picRow']['show']):

            for ($this->_sections['picRow']['index'] = $this->_sections['picRow']['start'], $this->_sections['picRow']['iteration'] = 1;
                 $this->_sections['picRow']['iteration'] <= $this->_sections['picRow']['total'];
                 $this->_sections['picRow']['index'] += $this->_sections['picRow']['step'], $this->_sections['picRow']['iteration']++):
$this->_sections['picRow']['rownum'] = $this->_sections['picRow']['iteration'];
$this->_sections['picRow']['index_prev'] = $this->_sections['picRow']['index'] - $this->_sections['picRow']['step'];
$this->_sections['picRow']['index_next'] = $this->_sections['picRow']['index'] + $this->_sections['picRow']['step'];
$this->_sections['picRow']['first']      = ($this->_sections['picRow']['iteration'] == 1);
$this->_sections['picRow']['last']       = ($this->_sections['picRow']['iteration'] == $this->_sections['picRow']['total']);
?>
                  <?php $this->assign('iIndex', $this->_sections['picRow']['index']); ?>

                  <tr>
                    <td class="index">
                        #<?php echo $this->_tpl_vars['iIndex']; ?>

                    </td>
                    <td class="text">
                        <?php $this->assign('sPicFile', $this->_tpl_vars['edit']->getPictureFieldValue('oxpic',$this->_tpl_vars['iIndex'])); ?>
                        <?php $this->assign('blPicUplodaded', true); ?>

                        <?php if ($this->_tpl_vars['sPicFile'] == "nopic.jpg" || $this->_tpl_vars['sPicFile'] == ""): ?>
                        <?php $this->assign('blPicUplodaded', false); ?>
                        <span class="notActive">-------</span>
                        <?php else: ?>
                        <b><?php echo $this->_tpl_vars['sPicFile']; ?>
</b>
                        <?php endif; ?>

                    </td>
                    <td class="edittext">
                        <input class="editinput" name="myfile[M<?php echo $this->_tpl_vars['iIndex']; ?>
@oxarticles__oxpic<?php echo $this->_tpl_vars['iIndex']; ?>
]" type="file">
                    </td>
                    <td nowrap="nowrap">
                        <?php if ($this->_tpl_vars['blPicUplodaded'] && ! $this->_tpl_vars['readonly']): ?>
                        <a href="Javascript:DeletePic('<?php echo $this->_tpl_vars['iIndex']; ?>
');" class="deleteText"><span class="ico"></span><span class="float: left;>"><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_DELETE'), $this);?>
</span></a>
                        <?php endif; ?>
                    </td>
                    <td>

                        <?php if ($this->_tpl_vars['blPicUplodaded'] && ! $this->_tpl_vars['readonly']): ?>
                            <?php $this->assign('sPicUrl', $this->_tpl_vars['edit']->getPictureUrl($this->_tpl_vars['iIndex'])); ?>
                            <a href="<?php echo $this->_tpl_vars['sPicUrl']; ?>
" class="zoomText" target="_blank"><span class="ico"></span><span class="float: left;>"><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_PICTURES_PREVIEW'), $this);?>
</span></a>
                        <?php endif; ?>
                    </td>
                  </tr>

                  <?php endfor; endif; ?>
              
            </table>

            <!-- CUSTOM PICTURES -->
            <table cellspacing="0" cellpadding="0" width="100%" border="0" class="listTable">
              
                  <colgroup>
                      <col width="1%" nowrap>
                      <col width="1%" nowrap>
                      <col width="1%" nowrap>
                      <col width="98%">
                  </colgroup>
                  <tr>
                      <th colspan="5" valign="top">
                         <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_PICTURES_CUSTOM_PICTURES'), $this);?>

                      </th>
                  </tr>

                  <tr>
                    <td class="index" nowrap>
                        <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_THUMB'), $this);?>
 (<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_FILE_UPLOAD'), $this);?>
 <?php echo $this->_tpl_vars['sMaxFormattedFileSize']; ?>
, <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_PICTURE_DIMENSIONS'), $this);?>
)
                        <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_PICTURES_THUMB'), $this);?>

                    </td>
                    <td class="text">
                        <?php $this->assign('sThumbFile', $this->_tpl_vars['edit']->getPictureFieldValue('oxthumb')); ?>
                        <?php if ($this->_tpl_vars['sThumbFile'] == "nopic.jpg" || $this->_tpl_vars['sThumbFile'] == ""): ?>
                        -------
                        <?php else: ?>
                        <?php $this->assign('blThumbUplodaded', true); ?>
                        <b><?php echo $this->_tpl_vars['sThumbFile']; ?>
</b>
                        <?php endif; ?>
                    </td>
                    <td class="edittext">
                        <input class="editinput" name="myfile[TH@oxarticles__oxthumb]" type="file">
                    </td>
                    <td nowrap="nowrap">
                        <?php if ($this->_tpl_vars['blThumbUplodaded'] && ! $this->_tpl_vars['readonly']): ?>
                        <a href="Javascript:DeletePic('TH');" class="deleteText"><span class="ico"></span><span class="float: left;>"><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_DELETE'), $this);?>
</span></a>
                        <?php endif; ?>
                    </td>
                  </tr>

                  <tr>
                    <td class="index" nowrap>
                        <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_PICTURES_ICON'), $this);?>
 (<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_FILE_UPLOAD'), $this);?>
 <?php echo $this->_tpl_vars['sMaxFormattedFileSize']; ?>
, <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_PICTURE_DIMENSIONS'), $this);?>
)
                        <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_PICTURES_ICON'), $this);?>

                    </td>
                    <td class="text">
                        <?php $this->assign('sIconFile', $this->_tpl_vars['edit']->getPictureFieldValue('oxicon')); ?>
                        <?php if ("nopic_ico.jpg" == $this->_tpl_vars['sIconFile'] || "nopic.jpg" == $this->_tpl_vars['sIconFile'] || "" == $this->_tpl_vars['sIconFile']): ?>
                        -------
                        <?php else: ?>
                        <?php $this->assign('blIcoUplodaded', true); ?>
                        <b><?php echo $this->_tpl_vars['sIconFile']; ?>
</b>
                        <?php endif; ?>
                    </td>
                    <td class="edittext">
                        <input class="editinput" name="myfile[ICO@oxarticles__oxicon]" type="file">
                    </td>
                    <td nowrap="nowrap">
                        <?php if ($this->_tpl_vars['blIcoUplodaded'] && ! $this->_tpl_vars['readonly']): ?>
                        <a href="Javascript:DeletePic('ICO');" class="deleteText"><span class="ico"></span><span class="float: left;>"><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_DELETE'), $this);?>
</span></a>
                        <?php endif; ?>
                    </td>
                  </tr>
              

            </table>

            <input type="submit" class="edittext" name="save" value="<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_PICTURES_SAVE'), $this);?>
" onClick="Javascript:document.myedit.fnc.value='save'"><br>


        </td>
      </tr>
   </table>


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