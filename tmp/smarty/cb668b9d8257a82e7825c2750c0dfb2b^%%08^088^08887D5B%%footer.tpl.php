<?php /* Smarty version 2.6.28, created on 2018-10-14 21:26:08
         compiled from email/html/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxmultilang', 'email/html/footer.tpl', 7, false),array('function', 'oxcontent', 'email/html/footer.tpl', 8, false),)), $this); ?>
                                    <table class="row footer">
                                        <tr bgcolor="#ebebeb">
                                            <td class="wrapper">
                                                <table class="six columns">
                                                    <tr>
                                                        <td class="left-text-pad">
                                                            <h5><?php echo smarty_function_oxmultilang(array('ident' => 'DD_FOOTER_CONTACT_INFO'), $this);?>
</h5>
                                                            <?php echo smarty_function_oxcontent(array('ident' => 'oxemailfooter'), $this);?>

                                                        </td>
                                                        <td class="expander"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <?php if ($this->_tpl_vars['oViewConf']->getViewThemeParam('sFacebookUrl') || $this->_tpl_vars['oViewConf']->getViewThemeParam('sGooglePlusUrl') || $this->_tpl_vars['oViewConf']->getViewThemeParam('sTwitterUrl') || $this->_tpl_vars['oViewConf']->getViewThemeParam('sYouTubeUrl') || $this->_tpl_vars['oViewConf']->getViewThemeParam('sBlogUrl')): ?>
                                                <td class="wrapper last">
                                                    <table class="six columns">
                                                        <tr>
                                                            <td class="right-text-pad">

                                                                <h5><?php echo smarty_function_oxmultilang(array('ident' => 'DD_FOOTER_FOLLOW_US'), $this);?>
</h5>

                                                                <?php if ($this->_tpl_vars['oViewConf']->getViewThemeParam('sFacebookUrl')): ?>
                                                                    <table class="tiny-button facebook">
                                                                        <tr>
                                                                            <td>
                                                                                <a href="<?php echo $this->_tpl_vars['oViewConf']->getViewThemeParam('sFacebookUrl'); ?>
" target="_blank">Facebook</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                <?php endif; ?>

                                                                <?php if ($this->_tpl_vars['oViewConf']->getViewThemeParam('sTwitterUrl')): ?>
                                                                    <table class="tiny-button twitter">
                                                                        <tr>
                                                                            <td>
                                                                                <a href="<?php echo $this->_tpl_vars['oViewConf']->getViewThemeParam('sTwitterUrl'); ?>
" target="_blank">Twitter</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                <?php endif; ?>

                                                                <?php if ($this->_tpl_vars['oViewConf']->getViewThemeParam('sGooglePlusUrl')): ?>
                                                                    <table class="tiny-button google-plus">
                                                                        <tr>
                                                                            <td>
                                                                                <a href="<?php echo $this->_tpl_vars['oViewConf']->getViewThemeParam('sGooglePlusUrl'); ?>
" target="_blank">Google+</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                <?php endif; ?>

                                                                <?php if ($this->_tpl_vars['oViewConf']->getViewThemeParam('sYouTubeUrl')): ?>
                                                                    <table class="tiny-button youtube">
                                                                        <tr>
                                                                            <td>
                                                                                <a href="<?php echo $this->_tpl_vars['oViewConf']->getViewThemeParam('sYouTubeUrl'); ?>
" target="_blank">YouTube</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                <?php endif; ?>

                                                            </td>
                                                            <td class="expander"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    </table>


                                    <table class="row">
                                        <tr>
                                            <td class="wrapper last">

                                                <table class="twelve columns">
                                                    <tr>
                                                        <td align="left">
                                                                                                                    </td>
                                                        <td class="expander"></td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>


                    </center>
                </td>
            </tr>
        </table>
    </body>
</html>