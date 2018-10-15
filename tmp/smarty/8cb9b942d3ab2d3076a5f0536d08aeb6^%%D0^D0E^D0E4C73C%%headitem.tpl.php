<?php /* Smarty version 2.6.28, created on 2018-10-14 23:18:13
         compiled from popups/headitem.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/reset-fonts/reset-fonts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/base/base-min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/assets/skins/sam/skin.css">

    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/utilities/utilities.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/container/container-min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/menu/menu-min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/button/button-min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/datasource/datasource-min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/datatable/datatable-min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/build/json/json-min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
aoc.css">
    <!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
aoc_ie8.css"><![endif]-->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['oViewConf']->getResourceUrl(); ?>
yui/oxid-aoc.js"></script>

    <?php if ($this->_tpl_vars['readonly']): ?>
        <?php $this->assign('readonly', 'readonly disabled'); ?>
    <?php else: ?>
        <?php $this->assign('readonly', ""); ?>
    <?php endif; ?>

</head>
<body class="yui-skin-sam">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_error.tpl", 'smarty_include_vars' => array('Errorlist' => $this->_tpl_vars['Errors']['default'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>