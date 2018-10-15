<?php /* Smarty version 2.6.28, created on 2018-10-14 20:59:07
         compiled from article_extend.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'article_extend.tpl', 1, false),array('modifier', 'oxtruncate', 'article_extend.tpl', 270, false),array('modifier', 'oxformdate', 'article_extend.tpl', 379, false),array('function', 'oxmultilang', 'article_extend.tpl', 72, false),array('function', 'oxinputhelp', 'article_extend.tpl', 93, false),array('block', 'oxhasrights', 'article_extend.tpl', 362, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='GENERAL_ADMIN_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['readonly']): ?>
    <?php $this->assign('readonly', 'readonly disabled'); ?>
<?php else: ?>
    <?php $this->assign('readonly', ""); ?>
<?php endif; ?>


<script type="text/javascript">
<!--
window.onload = function ()
{
    <?php if ($this->_tpl_vars['updatelist'] == 1): ?>
        top.oxid.admin.updateList('<?php echo $this->_tpl_vars['oxid']; ?>
');
    <?php endif; ?>
    top.reloadEditFrame();
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
function processUnitInput( oSelect, sInputId )
{
    document.getElementById( sInputId ).disabled = oSelect.value ? true : false;
}
//-->
</script>

<form name="transfer" id="transfer" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

    <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
    <input type="hidden" name="cl" value="article_extend">
    <input type="hidden" name="editlanguage" value="<?php echo $this->_tpl_vars['editlanguage']; ?>
">
</form>

<form name="myedit" id="myedit" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" enctype="multipart/form-data" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->_tpl_vars['iMaxUploadFileSize']; ?>
">
<?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

<input type="hidden" name="cl" value="article_extend">
<input type="hidden" name="fnc" value="">
<input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
<input type="hidden" name="voxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
<input type="hidden" name="oxparentid" value="<?php echo $this->_tpl_vars['oxparentid']; ?>
">
<input type="hidden" name="editval[article__oxid]" value="<?php echo $this->_tpl_vars['oxid']; ?>
">



  <table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
    <tr height="10">
      <td></td><td></td>
    </tr>
    <tr>
      <td width="15"></td>
      <td valign="top" class="edittext">

        <table cellspacing="0" cellpadding="0" border="0">
          
              <?php if ($this->_tpl_vars['errorsavingtprice']): ?>
                <tr>
                  <td colspan="2">
                    <?php if ($this->_tpl_vars['errorsavingtprice'] == 1): ?>
                    <div class="errorbox"><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_ERRORSAVINGTPRICE'), $this);?>
</div>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['oxparentid']): ?>
              <tr>
                <td class="edittext" width="120">
                  <b><?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_VARIANTE'), $this);?>
</b>
                </td>
                <td class="edittext">
                  <a href="Javascript:editThis('<?php echo $this->_tpl_vars['parentarticle']->oxarticles__oxid->value; ?>
');" class="edittext"><b><?php echo $this->_tpl_vars['parentarticle']->oxarticles__oxartnum->value; ?>
 <?php echo $this->_tpl_vars['parentarticle']->oxarticles__oxtitle->value; ?>
</b></a>
                </td>
              </tr>
              <?php endif; ?>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_WEIGHT'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="10" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxweight->fldmax_length; ?>
" name="editval[oxarticles__oxweight]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxweight->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_WEIGHT_UNIT'), $this);?>

                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_WEIGHT'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_MASS'), $this);?>

                </td>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_LENGTH'), $this);?>
&nbsp;<input type="text" class="editinput" size="3" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxlength->fldmax_length; ?>
" name="editval[oxarticles__oxlength]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxlength->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_DIMENSIONS_UNIT'), $this);?>

                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_WIDTH'), $this);?>
&nbsp;<input type="text" class="editinput" size="3" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxlength->fldmax_width; ?>
" name="editval[oxarticles__oxwidth]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxwidth->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_DIMENSIONS_UNIT'), $this);?>

                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_HEIGHT'), $this);?>
&nbsp;<input type="text" class="editinput" size="3" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxlength->fldmax_height; ?>
" name="editval[oxarticles__oxheight]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxheight->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_DIMENSIONS_UNIT'), $this);?>

                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_MASS'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UNITQUANTITY'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="10" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxunitquantity->fldmax_length; ?>
" name="editval[oxarticles__oxunitquantity]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxunitquantity->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  &nbsp;&nbsp;&nbsp;&nbsp; <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UNITNAME'), $this);?>
:
                    <?php if ($this->_tpl_vars['oView']->getUnitsArray()): ?>
                        <select name="editval[oxarticles__oxunitname]" onChange="JavaScript:processUnitInput( this, 'unitinput' )">
                            <option value="">-</option>
                            <?php $_from = $this->_tpl_vars['oView']->getUnitsArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sKey'] => $this->_tpl_vars['sUnit']):
?>
                                <?php $this->assign('sUnitSelected', ""); ?>
                                <?php if ($this->_tpl_vars['edit']->oxarticles__oxunitname->value == $this->_tpl_vars['sKey']): ?>
                                    <?php $this->assign('blUseSelection', true); ?>
                                    <?php $this->assign('sUnitSelected', 'selected'); ?>
                                <?php endif; ?>
                                <option value="<?php echo $this->_tpl_vars['sKey']; ?>
" <?php echo $this->_tpl_vars['sUnitSelected']; ?>
><?php echo $this->_tpl_vars['sUnit']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select> /
                    <?php endif; ?>
                  <input type="text" id="unitinput" class="editinput" size="10" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxunitname->fldmax_length; ?>
" name="editval[oxarticles__oxunitname]" value="<?php if (! $this->_tpl_vars['blUseSelection']): ?><?php echo $this->_tpl_vars['edit']->oxarticles__oxunitname->value; ?>
<?php endif; ?>" <?php if ($this->_tpl_vars['blUseSelection']): ?>disabled="true"<?php endif; ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "help.tpl", 'smarty_include_vars' => array('helpid' => 'article_unit')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_UNITQUANTITY'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_EXTURL'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="40" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxexturl->fldmax_length; ?>
" name="editval[oxarticles__oxexturl]" value="http://<?php echo $this->_tpl_vars['edit']->oxarticles__oxexturl->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_EXTURL'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_URLDESC'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="40" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxurldesc->fldmax_length; ?>
" name="editval[oxarticles__oxurldesc]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxurldesc->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_URLDESC'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_BPRICE'), $this);?>
 (<?php echo $this->_tpl_vars['oActCur']->sign; ?>
)
                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="8" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxbprice->fldmax_length; ?>
" name="editval[oxarticles__oxbprice]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxbprice->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>&nbsp;&nbsp;<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_TPRICE'), $this);?>
 <input type="text" class="editinput" size="8" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxtprice->fldmax_length; ?>
" name="editval[oxarticles__oxtprice]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxtprice->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_BPRICE'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_FILE'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="25" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxfile->fldmax_length; ?>
" name="editval[oxarticles__oxfile]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxfile->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_FILE'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_FILEUPLOAD'), $this);?>
 (<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_FILE_UPLOAD'), $this);?>
 <?php echo $this->_tpl_vars['sMaxFormattedFileSize']; ?>
, <?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_MAX_PICTURE_DIMENSIONS'), $this);?>
)
                </td>
                <td class="edittext">
                  <input class="editinput" name="myfile[FL@oxarticles__oxfile]" type="file" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_FILEUPLOAD'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_TEMPLATE'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="25" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxtemplate->fldmax_length; ?>
" name="editval[oxarticles__oxtemplate]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxtemplate->value; ?>
" <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "help.tpl", 'smarty_include_vars' => array('helpid' => 'article_template')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_TEMPLATE'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_QUESTIONEMAIL'), $this);?>

                </td>
                <td class="edittext">
                  <input type="text" class="editinput" size="25" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxquestionemail->fldmax_length; ?>
" name="editval[oxarticles__oxquestionemail]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxquestionemail->value; ?>
" <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_QUESTIONEMAIL'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext" width="120">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_ISSEARCH'), $this);?>

                </td>
                <td class="edittext">
                  <input class="edittext" type="hidden" name="editval[oxarticles__oxissearch]" value='0'>
                  <input class="edittext" type="checkbox" name="editval[oxarticles__oxissearch]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxissearch->value == 1): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_ISSEARCH'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext" width="140">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_ISCONFIGURABLE'), $this);?>

                </td>
                <td class="edittext">
                  <input type="hidden" name="editval[oxarticles__oxisconfigurable]" value='0'>
                  <input class="edittext" type="checkbox" name="editval[oxarticles__oxisconfigurable]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxisconfigurable->value == 1): ?>checked<?php endif; ?>>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_ISCONFIGURABLE'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext" width="120">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_NONMATERIAL'), $this);?>

                </td>
                <td class="edittext">
                  <input class="edittext" type="hidden" name="editval[oxarticles__oxnonmaterial]" value='0'>
                  <input class="edittext" type="checkbox" name="editval[oxarticles__oxnonmaterial]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxnonmaterial->value == 1): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['readonly']; ?>
 <?php if ($this->_tpl_vars['oxparentid']): ?>readonly disabled<?php endif; ?>>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_NONMATERIAL'), $this);?>

                </td>
              </tr>


              <tr>
                <td class="edittext" width="120">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_FREESHIPPING'), $this);?>

                </td>
                <td class="edittext">
                  <input class="edittext" type="hidden" name="editval[oxarticles__oxfreeshipping]" value='0'>
                  <input class="edittext" type="checkbox" name="editval[oxarticles__oxfreeshipping]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxfreeshipping->value == 1): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['readonly']; ?>
 <?php if ($this->_tpl_vars['oxparentid']): ?>readonly disabled<?php endif; ?>>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_FREESHIPPING'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_BLFIXEDPRICE'), $this);?>

                </td>
                <td class="edittext">
                  <input class="edittext" type="checkbox" name="editval[oxarticles__oxblfixedprice]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxblfixedprice->value == 1): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['readonly']; ?>
>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_BLFIXEDPRICE'), $this);?>

                </td>
              </tr>
              <tr>
                <td class="edittext" width="140">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_SKIPDISCOUNTS'), $this);?>

                </td>
                <td class="edittext">
                  <input type="hidden" name="editval[oxarticles__oxskipdiscounts]" value='0'>
                  <input class="edittext" type="checkbox" name="editval[oxarticles__oxskipdiscounts]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxskipdiscounts->value == 1): ?>checked<?php endif; ?>>
                  <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_SKIPDISCOUNTS'), $this);?>

                </td>
              </tr>
              <tr>
                  <td class="edittext" width="140">
                      <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_SHOWCUSTOMAGREEMENT'), $this);?>

                  </td>
                  <td class="edittext">
                      <input type="hidden" name="editval[oxarticles__oxshowcustomagreement]" value='0'>
                      <input class="edittext" type="checkbox" name="editval[oxarticles__oxshowcustomagreement]" value='1' <?php if ($this->_tpl_vars['edit']->oxarticles__oxshowcustomagreement->value == 1): ?>checked<?php endif; ?> <?php if ($this->_tpl_vars['oxparentid']): ?>disabled<?php endif; ?>>
                      <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_SHOWCUSTOMAGREEMENT'), $this);?>

                  </td>
              </tr>
              <tr>
                <td class="edittext">
                  <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_ARTEXTRA'), $this);?>

                </td>
                <td class="edittext">
                  <?php echo $this->_tpl_vars['bundle_artnum']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['bundle_title'])) ? $this->_run_mod_handler('oxtruncate', true, $_tmp, 21, "...", true) : smarty_modifier_oxtruncate($_tmp, 21, "...", true)); ?>

                  <input <?php echo $this->_tpl_vars['readonly']; ?>
 type="button" value="<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_ASSIGNARTICLES'), $this);?>
" class="edittext" onclick="JavaScript:showDialog('&cl=article_extend&aoc=2&oxid=<?php echo $this->_tpl_vars['oxid']; ?>
');">
                </td>
              </tr>
          
          <tr>
            <td class="edittext"></td>
            <td class="edittext">
              <input type="submit" class="edittext" name="save" value="<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_SAVE'), $this);?>
" onClick="Javascript:document.myedit.fnc.value='save'"" ><br>
            </td>
          </tr>
          <tr>
            <td class="edittext" colspan="2"><br>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "language_edit.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br>
            </td>
          </tr>
        </table>

      </td>

      <!-- Anfang rechte Seite -->

      <td valign="top" class="edittext" align="left" width="55%" style="table-layout:fixed">

        <input <?php echo $this->_tpl_vars['readonly']; ?>
 type="button" value="<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_ASSIGNCATEGORIES'), $this);?>
" class="edittext" onclick="JavaScript:showDialog('&cl=article_extend&aoc=1&oxid=<?php echo $this->_tpl_vars['oxid']; ?>
');">


          <br><br>
          <fieldset title="<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_MEDIAURLS'), $this);?>
" style="padding-left: 5px;">
          <legend><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_MEDIAURLS'), $this);?>
</legend><br>

            <table cellspacing="0" cellpadding="0" border="0">
            
                <?php $_from = $this->_tpl_vars['aMediaUrls']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oMediaUrl']):
?>
                    <tr>
                    <?php if ($this->_tpl_vars['oddclass'] == 2): ?>
                        <?php $this->assign('oddclass', ""); ?>
                    <?php else: ?>
                        <?php $this->assign('oddclass', '2'); ?>
                    <?php endif; ?>
                        <td class=listitem<?php echo $this->_tpl_vars['oddclass']; ?>
>
                        &nbsp;<a href="<?php echo $this->_tpl_vars['oMediaUrl']->getLink(); ?>
" target="_blank">&raquo;&raquo;</a>&nbsp;
                        </td>
                        <td class=listitem<?php echo $this->_tpl_vars['oddclass']; ?>
>
                        &nbsp;<a href="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
&cl=article_extend&amp;mediaid=<?php echo $this->_tpl_vars['oMediaUrl']->oxmediaurls__oxid->value; ?>
&amp;fnc=deletemedia&amp;oxid=<?php echo $this->_tpl_vars['oxid']; ?>
&amp;editlanguage=<?php echo $this->_tpl_vars['editlanguage']; ?>
" onClick='return confirm("<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_YOUWANTTODELETE'), $this);?>
")'><img src="<?php echo $this->_tpl_vars['oViewConf']->getImageUrl(); ?>
/delete_button.gif" border=0></a>&nbsp;
                        </td>
                        <td class="listitem<?php echo $this->_tpl_vars['oddclass']; ?>
" width=250>
                        <input style="width:100%" class="edittext" type="text" name="aMediaUrls[<?php echo $this->_tpl_vars['oMediaUrl']->oxmediaurls__oxid->value; ?>
][oxmediaurls__oxdesc]" value="<?php echo $this->_tpl_vars['oMediaUrl']->oxmediaurls__oxdesc->value; ?>
">
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['aMediaUrls']->count()): ?>
                    <tr>
                      <td colspan="3" align="right">
                        <input class="edittext" type="button" onclick="this.form.fnc.value='updateMedia';this.form.submit();" <?php echo $this->_tpl_vars['readonly']; ?>
 value="<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEMEDIA'), $this);?>
">
                        <br><br>
                      </td>
                    </tr>
                <?php endif; ?>

                    <tr>
                      <td colspan="3">
                        <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_DESCRIPTION'), $this);?>
:<br>
                        <input style="width:100%" type="text" name="mediaDesc" class="edittext" <?php echo $this->_tpl_vars['readonly']; ?>
>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="3">
                        <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_ENTERURL'), $this);?>
:<br>
                        <input style="width:100%" type="text" name="mediaUrl" class="edittext" <?php echo $this->_tpl_vars['readonly']; ?>
>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="3">
                        <?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPLOADFILE'), $this);?>
:<br>
                        <input style="width:100%" type="file" name="mediaFile" class="edittext" <?php echo $this->_tpl_vars['readonly']; ?>
>
                      </td>
                    </tr>
                
            </table>

        </fieldset>

        <br><br>
        <fieldset title="<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICES'), $this);?>
" style="padding-left: 5px;">
            <legend><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICES'), $this);?>
<?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_UPDATEPRICE'), $this);?>
</legend><br>

            <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <?php $this->_tag_stack[] = array('oxhasrights', array('object' => $this->_tpl_vars['edit'],'field' => 'oxupdateprice','readonly' => $this->_tpl_vars['readonly'])); $_block_repeat=true;smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                        <td><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICE'), $this);?>
 (<?php echo $this->_tpl_vars['oActCur']->sign; ?>
):&nbsp;</td><td><input type="text" class="editinput" size="4" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdateprice->fldmax_length; ?>
" name="editval[oxarticles__oxupdateprice]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdateprice->value; ?>
"></td>
                    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    <?php $this->_tag_stack[] = array('oxhasrights', array('object' => $this->_tpl_vars['edit'],'field' => 'oxupdatepricea','readonly' => $this->_tpl_vars['readonly'])); $_block_repeat=true;smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                        <td>&nbsp;<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICEA'), $this);?>
&nbsp;</td><td><input type="text" class="editinput" size="4" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdatepricea->fldmax_length; ?>
" name="editval[oxarticles__oxupdatepricea]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdatepricea->value; ?>
"></td>
                    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    <?php $this->_tag_stack[] = array('oxhasrights', array('object' => $this->_tpl_vars['edit'],'field' => 'oxupdatepriceb','readonly' => $this->_tpl_vars['readonly'])); $_block_repeat=true;smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                        <td>&nbsp;<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICEB'), $this);?>
&nbsp;</td><td><input type="text" class="editinput" size="4" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdatepriceb->fldmax_length; ?>
" name="editval[oxarticles__oxupdatepriceb]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdatepriceb->value; ?>
"></td>
                    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    <?php $this->_tag_stack[] = array('oxhasrights', array('object' => $this->_tpl_vars['edit'],'field' => 'oxupdatepricec','readonly' => $this->_tpl_vars['readonly'])); $_block_repeat=true;smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                        <td>&nbsp;<?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICEC'), $this);?>
&nbsp;</td><td><input type="text" class="editinput" size="4" maxlength="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdatepricec->fldmax_length; ?>
" name="editval[oxarticles__oxupdatepricec]" value="<?php echo $this->_tpl_vars['edit']->oxarticles__oxupdatepricec->value; ?>
"></td>
                    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                </tr>
                <?php $this->_tag_stack[] = array('oxhasrights', array('object' => $this->_tpl_vars['edit'],'field' => 'oxupdatepricetime','readonly' => $this->_tpl_vars['readonly'])); $_block_repeat=true;smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                <tr>
                    <td><?php echo smarty_function_oxmultilang(array('ident' => 'ARTICLE_EXTEND_UPDATEPRICETIME'), $this);?>
&nbsp;</td>
                    <td colspan="7">
                        <input type="text" class="editinput" size="20" maxlength="20" name="editval[oxarticles__oxupdatepricetime]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['edit']->oxarticles__oxupdatepricetime->value)) ? $this->_run_mod_handler('oxformdate', true, $_tmp) : smarty_modifier_oxformdate($_tmp)); ?>
">
                    </td>
                </tr>
                <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
            </table>

            <?php echo smarty_function_oxinputhelp(array('ident' => 'HELP_ARTICLE_EXTEND_UPDATEPRICES'), $this);?>


       </fieldset>

      </td>
      <!-- Ende rechte Seite -->
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