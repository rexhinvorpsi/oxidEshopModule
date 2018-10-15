<?php /* Smarty version 2.6.28, created on 2018-10-14 21:49:18
         compiled from list_order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'oxmultilangassign', 'list_order.tpl', 1, false),array('modifier', 'cat', 'list_order.tpl', 7, false),array('modifier', 'oxformdate', 'list_order.tpl', 80, false),array('modifier', 'oxaddslashes', 'list_order.tpl', 154, false),array('function', 'oxmultilang', 'list_order.tpl', 66, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "headitem.tpl", 'smarty_include_vars' => array('title' => ((is_array($_tmp='SHOWLIST_TITLE')) ? $this->_run_mod_handler('oxmultilangassign', true, $_tmp) : smarty_modifier_oxmultilangassign($_tmp)),'box' => ' ')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $this->assign('where', $this->_tpl_vars['oView']->getListFilter()); ?>
<?php $this->assign('whereparam', ""); ?>
<?php $_from = $this->_tpl_vars['where']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sTable'] => $this->_tpl_vars['aField']):
?>
  <?php $_from = $this->_tpl_vars['aField']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sField'] => $this->_tpl_vars['sFilter']):
?>
    <?php $this->assign('whereparam', ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['whereparam'])) ? $this->_run_mod_handler('cat', true, $_tmp, "where[") : smarty_modifier_cat($_tmp, "where[")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sTable']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sTable'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "][") : smarty_modifier_cat($_tmp, "][")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sField']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sField'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "]=") : smarty_modifier_cat($_tmp, "]=")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['sFilter']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['sFilter'])))) ? $this->_run_mod_handler('cat', true, $_tmp, "&amp;") : smarty_modifier_cat($_tmp, "&amp;"))); ?>
  <?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
<?php $this->assign('viewListSize', $this->_tpl_vars['oView']->getViewListSize()); ?>
<?php $this->assign('whereparam', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['whereparam'])) ? $this->_run_mod_handler('cat', true, $_tmp, "viewListSize=") : smarty_modifier_cat($_tmp, "viewListSize=")))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['viewListSize']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['viewListSize']))); ?>

<script type="text/javascript">
<!--
function editThis( sID )
{
    <?php $this->assign('shMen', 1); ?>

    <?php $_from = $this->_tpl_vars['menustructure']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menuholder']):
?>
      <?php if ($this->_tpl_vars['shMen'] && $this->_tpl_vars['menuholder']->nodeType == XML_ELEMENT_NODE && $this->_tpl_vars['menuholder']->childNodes->length): ?>

        <?php $this->assign('shMen', 0); ?>
        <?php $this->assign('mn', 1); ?>

        <?php $_from = $this->_tpl_vars['menuholder']->childNodes; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menuitem']):
?>
          <?php if ($this->_tpl_vars['menuitem']->nodeType == XML_ELEMENT_NODE && $this->_tpl_vars['menuitem']->childNodes->length): ?>
            <?php if ($this->_tpl_vars['menuitem']->getAttribute('id') == 'mxorders'): ?>

              <?php $_from = $this->_tpl_vars['menuitem']->childNodes; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['submenuitem']):
?>
                <?php if ($this->_tpl_vars['submenuitem']->nodeType == XML_ELEMENT_NODE && $this->_tpl_vars['submenuitem']->getAttribute('cl') == 'admin_order'): ?>

                    if ( top && top.navigation && top.navigation.adminnav ) {
                        var _sbli = top.navigation.adminnav.document.getElementById( 'nav-1-<?php echo $this->_tpl_vars['mn']; ?>
-1' );
                        var _sba = _sbli.getElementsByTagName( 'a' );
                        top.navigation.adminnav._navAct( _sba[0] );
                    }

                <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?>

            <?php endif; ?>
            <?php $this->assign('mn', $this->_tpl_vars['mn']+1); ?>

          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    var oTransfer = document.getElementById("transfer");
    oTransfer.oxid.value=sID;
    oTransfer.cl.value='admin_order';
    oTransfer.submit();
}
//-->
</script>

<form name="transfer" id="transfer" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

    <input type="hidden" name="oxid" value="<?php echo $this->_tpl_vars['oxid']; ?>
">
    <input type="hidden" name="cl" value="list_order">
    <input type="hidden" name="updatelist" value="1">
</form>

<?php if ($this->_tpl_vars['noresult']): ?>
    <span class="listitem">
        <b><?php echo smarty_function_oxmultilang(array('ident' => 'SHOWLIST_NORESULTS'), $this);?>
</b><br><br>
    </span>
<?php endif; ?>

<div id="liste">

<form name="showlist" id="showlist" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfLink(); ?>
" method="post">
    <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

    <input type="hidden" name="cl" value="list_order">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
    
        <td class="listfilter first">
            <div class="r1"><div class="b1">
            <input class="listedit" type="text" size="15" maxlength="128" name="where[oxorder][oxorderdate]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['where']['oxorder']['oxorderdate'])) ? $this->_run_mod_handler('oxformdate', true, $_tmp) : smarty_modifier_oxformdate($_tmp)); ?>
">
            </div></div>
        </td>
        <td class="listfilter">
            <div class="r1"><div class="b1">
            <input class="listedit" type="text" size="15" maxlength="128" name="where[oxorderarticles][oxartnum]" value="<?php echo $this->_tpl_vars['where']['oxorderarticles']['oxartnum']; ?>
">
            </div></div>
        </td>
        <td class="listfilter">
            <div class="r1"><div class="b1">&nbsp;</div></div>
        </td>
        <td class="listfilter">
            <div class="r1"><div class="b1">
            <input class="listedit" type="text" size="15" maxlength="128" name="where[oxorderarticles][oxtitle]" value="<?php echo $this->_tpl_vars['where']['oxorderarticles']['oxtitle']; ?>
 <?php echo $this->_tpl_vars['where']['oxorderarticles']['oxselvariant']; ?>
">
            </div></div>
        </td>
        <td class="listfilter" colspan="2">
            <div class="r1">
              <div class="b1">
              <div class="find">
              <select name="viewListSize" class="editinput" onChange="JavaScript:top.oxid.admin.changeListSize()">
                <option value="50" <?php if ($this->_tpl_vars['viewListSize'] == 50): ?>SELECTED<?php endif; ?>>50</option>
                <option value="100" <?php if ($this->_tpl_vars['viewListSize'] == 100): ?>SELECTED<?php endif; ?>>100</option>
                <option value="200" <?php if ($this->_tpl_vars['viewListSize'] == 200): ?>SELECTED<?php endif; ?>>200</option>
              </select>
              <input class="listedit" type="submit" name="submitit" value="<?php echo smarty_function_oxmultilang(array('ident' => 'GENERAL_SEARCH'), $this);?>
">
            </div>
            </div>
          </div>
        </td>
    
</tr>
<tr>
    
        <td class="listheader first"><a href="javascript:top.oxid.admin.setSorting( document.forms.showlist, '', 'oxorderdate', 'desc');document.forms.showlist.submit();" class="listheader"><?php echo smarty_function_oxmultilang(array('ident' => 'snporderlistoxorderdate'), $this);?>
</a></td>
        <td class="listheader"><a href="javascript:top.oxid.admin.setSorting( document.forms.showlist, 'oxorderarticles', 'oxartnum', 'asc');document.forms.showlist.submit();" class="listheader"><?php echo smarty_function_oxmultilang(array('ident' => 'snporderlistoxartnum'), $this);?>
</a></td>
        <td class="listheader"><a href="javascript:top.oxid.admin.setSorting( document.forms.showlist, '', 'oxorderamount', 'asc');document.forms.showlist.submit();" class="listheader"><?php echo smarty_function_oxmultilang(array('ident' => 'snporderlistsum'), $this);?>
</a></td>
        <td class="listheader"><a href="javascript:top.oxid.admin.setSorting( document.forms.showlist, 'oxorderarticles', 'oxtitle', 'asc');document.forms.showlist.submit();" class="listheader"><?php echo smarty_function_oxmultilang(array('ident' => 'snporderlistoxtitle'), $this);?>
</a></td>
        <td class="listheader"><a href="javascript:top.oxid.admin.setSorting( document.forms.showlist, '', 'oxprice', 'asc');document.forms.showlist.submit();" class="listheader"><?php echo smarty_function_oxmultilang(array('ident' => 'SHOWLIST_SUM'), $this);?>
</a></td>
    
</tr>

<?php $this->assign('blWhite', ""); ?>
<?php $this->assign('_cnt', 0); ?>
<?php $_from = $this->_tpl_vars['mylist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oOrder']):
?>
    <?php $this->assign('_cnt', $this->_tpl_vars['_cnt']+1); ?>
    <tr id="row.<?php echo $this->_tpl_vars['_cnt']; ?>
">
        
            <td class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><a href="Javascript:editThis( '<?php echo $this->_tpl_vars['oOrder']->oxorder__oxorderid->value; ?>
');" class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oOrder']->oxorder__oxorderdate)) ? $this->_run_mod_handler('oxformdate', true, $_tmp) : smarty_modifier_oxformdate($_tmp)); ?>
</a></td>
            <td class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><a href="Javascript:editThis( '<?php echo $this->_tpl_vars['oOrder']->oxorder__oxorderid->value; ?>
');" class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><?php echo $this->_tpl_vars['oOrder']->oxorder__oxartnum->value; ?>
</a></td>
            <td class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><a href="Javascript:editThis( '<?php echo $this->_tpl_vars['oOrder']->oxorder__oxorderid->value; ?>
');" class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><?php echo $this->_tpl_vars['oOrder']->oxorder__oxorderamount->value; ?>
</a></td>
            <td class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><a href="Javascript:editThis( '<?php echo $this->_tpl_vars['oOrder']->oxorder__oxorderid->value; ?>
');" class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><?php echo $this->_tpl_vars['oOrder']->oxorder__oxtitle->getRawValue(); ?>
</a></td>
            <td class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><a href="Javascript:editThis( '<?php echo $this->_tpl_vars['oOrder']->oxorder__oxorderid->value; ?>
');" class="listitem<?php echo $this->_tpl_vars['blWhite']; ?>
"><?php echo $this->_tpl_vars['oOrder']->oxorder__oxprice->value; ?>
</a></td>
        
    </tr>
<?php if ($this->_tpl_vars['blWhite'] == '2'): ?>
    <?php $this->assign('blWhite', ""); ?>
<?php else: ?>
    <?php $this->assign('blWhite', '2'); ?>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagenavisnippet.tpl", 'smarty_include_vars' => array('colspan' => '8')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</table>
</form>
<?php if ($this->_tpl_vars['sumresult']): ?>
<span class="listitem">
<b><?php echo smarty_function_oxmultilang(array('ident' => 'SHOWLIST_SUM'), $this);?>
:</b> <?php echo $this->_tpl_vars['sumresult']; ?>
<br>
</span>
<?php endif; ?>
</div>

<script type="text/javascript">
if (parent.parent)
{   parent.parent.sShopTitle   = "<?php echo ((is_array($_tmp=$this->_tpl_vars['actshopobj']->oxshops__oxname->getRawValue())) ? $this->_run_mod_handler('oxaddslashes', true, $_tmp) : smarty_modifier_oxaddslashes($_tmp)); ?>
";
    parent.parent.sMenuItem    = "<?php echo smarty_function_oxmultilang(array('ident' => 'ORDER_LIST_MENUITEM'), $this);?>
";
    parent.parent.sMenuSubItem = "<?php echo smarty_function_oxmultilang(array('ident' => 'snporderlistheader'), $this);?>
";
    parent.parent.sWorkArea    = "<?php echo $this->_tpl_vars['_act']; ?>
";
    parent.parent.setTitle();
}
</script>
</body>
</html>