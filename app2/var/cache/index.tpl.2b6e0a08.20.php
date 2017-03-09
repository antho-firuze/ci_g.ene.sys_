<?php 
/** Fenom template 'backend/adminlte/index.tpl' compiled at 2017-03-08 16:40:20 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <?php
/* backend/adminlte/index.tpl:7: {var $template_url = $.php.base_url() ~ "templates/" ~ $theme_path} */
 $var["template_url"]=(call_user_func_array('base_url', array()).strval("templates/").strval($var["theme_path"])); ?>  <?php
/* backend/adminlte/index.tpl:9: {var $resource['dashboard1']} */
 ob_start(); ?> <link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:10: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:11: {$template_url} */
 echo $var["template_url"]; ?>font-awesome/css/font-awesome.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:12: {$template_url} */
 echo $var["template_url"]; ?>plugins/ionicons/css/ionicons.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:13: {$template_url} */
 echo $var["template_url"]; ?>dist/css/AdminLTE.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:14: {$template_url} */
 echo $var["template_url"]; ?>dist/css/skins/_all-skins.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:15: {$template_url} */
 echo $var["template_url"]; ?>css/custom.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:16: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-dialog/css/bootstrap-dialog.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:17: {$template_url} */
 echo $var["template_url"]; ?>plugins/iCheck/flat/blue.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:18: {$template_url} */
 echo $var["template_url"]; ?>plugins/morris/morris.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:19: {$template_url} */
 echo $var["template_url"]; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:20: {$template_url} */
 echo $var["template_url"]; ?>plugins/datepicker/datepicker3.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:21: {$template_url} */
 echo $var["template_url"]; ?>plugins/daterangepicker/daterangepicker-bs3.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:22: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:23: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:24: {$template_url} */
 echo $var["template_url"]; ?>plugins/autoComplete/jquery.auto-complete.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:25: {$template_url} */
 echo $var["template_url"]; ?>plugins/marquee/css/jquery.marquee.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:26: {$template_url} */
 echo $var["template_url"]; ?>plugins/animate/animate.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:27: {$template_url} */
 echo $var["template_url"]; ?>plugins/lobibox/css/lobibox.min.css"><script src="<?php
/* backend/adminlte/index.tpl:29: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:30: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQueryUI/jquery-ui.min.js"></script><script>$.widget.bridge("uibutton", $.ui.button);</script><script src="<?php
/* backend/adminlte/index.tpl:32: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/js/bootstrap.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:33: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:34: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:35: {$template_url} */
 echo $var["template_url"]; ?>plugins/raphael/raphael-min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:36: {$template_url} */
 echo $var["template_url"]; ?>plugins/morris/morris.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:37: {$template_url} */
 echo $var["template_url"]; ?>plugins/sparkline/jquery.sparkline.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:38: {$template_url} */
 echo $var["template_url"]; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:39: {$template_url} */
 echo $var["template_url"]; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script><script src="<?php
/* backend/adminlte/index.tpl:40: {$template_url} */
 echo $var["template_url"]; ?>plugins/knob/jquery.knob.js"></script><script src="<?php
/* backend/adminlte/index.tpl:41: {$template_url} */
 echo $var["template_url"]; ?>plugins/moment/min/moment.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:42: {$template_url} */
 echo $var["template_url"]; ?>plugins/daterangepicker/daterangepicker.js"></script><script src="<?php
/* backend/adminlte/index.tpl:43: {$template_url} */
 echo $var["template_url"]; ?>plugins/datepicker/bootstrap-datepicker.js"></script><script src="<?php
/* backend/adminlte/index.tpl:44: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:45: {$template_url} */
 echo $var["template_url"]; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:46: {$template_url} */
 echo $var["template_url"]; ?>plugins/fastclick/fastclick.js"></script><script src="<?php
/* backend/adminlte/index.tpl:47: {$template_url} */
 echo $var["template_url"]; ?>plugins/autoComplete/jquery.auto-complete.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:48: {$template_url} */
 echo $var["template_url"]; ?>dist/js/app.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:49: {$template_url} */
 echo $var["template_url"]; ?>plugins/idletimer/idle-timer.js"></script><script src="<?php
/* backend/adminlte/index.tpl:50: {$template_url} */
 echo $var["template_url"]; ?>plugins/validation/jquery.validate.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:51: {$template_url} */
 echo $var["template_url"]; ?>plugins/marquee/lib/jquery.marquee.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:52: {$template_url} */
 echo $var["template_url"]; ?>plugins/lobibox/js/notifications.min.js"></script><script> Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, {  soundPath:"<?php
/* backend/adminlte/index.tpl:55: {$template_url} */
 echo $var["template_url"]; ?>plugins/lobibox/sounds/", showClass:'rollIn', hideClass:'rollOut'   }); </script><script src="<?php
/* backend/adminlte/index.tpl:62: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.extend.func.js"></script><script src="<?php
/* backend/adminlte/index.tpl:63: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/bootstrap.helper.js"></script> <?php
/* backend/adminlte/index.tpl:64: {/var} */
 $var["resource"]['dashboard1']=ob_get_clean();; ?> <?php
/* backend/adminlte/index.tpl:65: {var $resource['dashboard2']} */
 ob_start(); ?> <link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:66: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:67: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:68: {$template_url} */
 echo $var["template_url"]; ?>font-awesome/css/font-awesome.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:69: {$template_url} */
 echo $var["template_url"]; ?>plugins/ionicons/css/ionicons.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:70: {$template_url} */
 echo $var["template_url"]; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:71: {$template_url} */
 echo $var["template_url"]; ?>dist/css/AdminLTE.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:72: {$template_url} */
 echo $var["template_url"]; ?>dist/css/skins/_all-skins.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:73: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQueryUI/jquery-ui.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:74: {$template_url} */
 echo $var["template_url"]; ?>plugins/autoComplete/jquery.auto-complete.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:75: {$template_url} */
 echo $var["template_url"]; ?>css/custom.css"><script src="<?php
/* backend/adminlte/index.tpl:77: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:78: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/js/bootstrap.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:79: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:80: {$template_url} */
 echo $var["template_url"]; ?>plugins/fastclick/fastclick.js"></script><script src="<?php
/* backend/adminlte/index.tpl:81: {$template_url} */
 echo $var["template_url"]; ?>plugins/autoComplete/jquery.auto-complete.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:82: {$template_url} */
 echo $var["template_url"]; ?>plugins/sparkline/jquery.sparkline.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:83: {$template_url} */
 echo $var["template_url"]; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:84: {$template_url} */
 echo $var["template_url"]; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script><script src="<?php
/* backend/adminlte/index.tpl:85: {$template_url} */
 echo $var["template_url"]; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:86: {$template_url} */
 echo $var["template_url"]; ?>plugins/chartjs/Chart.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:87: {$template_url} */
 echo $var["template_url"]; ?>dist/js/app.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:88: {$template_url} */
 echo $var["template_url"]; ?>dist/js/pages/dashboard2.js"></script><script src="<?php
/* backend/adminlte/index.tpl:89: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQueryUI/jquery-ui.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:90: {$template_url} */
 echo $var["template_url"]; ?>plugins/idletimer/idle-timer.js"></script><script src="<?php
/* backend/adminlte/index.tpl:91: {$template_url} */
 echo $var["template_url"]; ?>plugins/validation/jquery.validate.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:92: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.extend.func.js"></script><script src="<?php
/* backend/adminlte/index.tpl:93: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/bootstrap.helper.js"></script> <?php
/* backend/adminlte/index.tpl:94: {/var} */
 $var["resource"]['dashboard2']=ob_get_clean();; ?> <?php
/* backend/adminlte/index.tpl:95: {var $resource['crud']} */
 ob_start(); ?> <link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:96: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:97: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:98: {$template_url} */
 echo $var["template_url"]; ?>font-awesome/css/font-awesome.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:99: {$template_url} */
 echo $var["template_url"]; ?>plugins/ionicons/css/ionicons.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:100: {$template_url} */
 echo $var["template_url"]; ?>plugins/iCheck/flat/blue.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:101: {$template_url} */
 echo $var["template_url"]; ?>plugins/iCheck/flat/orange.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:102: {$template_url} */
 echo $var["template_url"]; ?>plugins/datatables/media/css/dataTables.bootstrap4.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:103: {$template_url} */
 echo $var["template_url"]; ?>plugins/datatables/extensions/select/css/select.dataTables.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:104: {$template_url} */
 echo $var["template_url"]; ?>dist/css/AdminLTE.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:105: {$template_url} */
 echo $var["template_url"]; ?>dist/css/skins/_all-skins.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:106: {$template_url} */
 echo $var["template_url"]; ?>plugins/autoComplete/jquery.auto-complete.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:107: {$template_url} */
 echo $var["template_url"]; ?>css/custom.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:108: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-dialog/css/bootstrap-dialog.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:109: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-combobox/css/bootstrap-combobox.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:110: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-combogrid/bootstrap-combogrid.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:111: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-select/css/bootstrap-select.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:112: {$template_url} */
 echo $var["template_url"]; ?>plugins/animate/animate.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:113: {$template_url} */
 echo $var["template_url"]; ?>plugins/lobibox/css/lobibox.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/index.tpl:114: {$template_url} */
 echo $var["template_url"]; ?>plugins/ajax-combobox/jquery.ajax-combobox.css"><script src="<?php
/* backend/adminlte/index.tpl:116: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:117: {$template_url} */
 echo $var["template_url"]; ?>plugins/idletimer/idle-timer.js"></script><script src="<?php
/* backend/adminlte/index.tpl:118: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:119: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/js/bootstrap.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:120: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:121: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script><script src="<?php
/* backend/adminlte/index.tpl:122: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-combogrid/bootstrap-combogrid.js"></script><script src="<?php
/* backend/adminlte/index.tpl:123: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>  <script src="<?php
/* backend/adminlte/index.tpl:125: {$template_url} */
 echo $var["template_url"]; ?>plugins/iCheck/icheck.js"></script><script src="<?php
/* backend/adminlte/index.tpl:126: {$template_url} */
 echo $var["template_url"]; ?>plugins/datatables/media/js/jquery.dataTables.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:127: {$template_url} */
 echo $var["template_url"]; ?>plugins/datatables/media/js/dataTables.bootstrap4.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:128: {$template_url} */
 echo $var["template_url"]; ?>plugins/datatables/extensions/select/js/dataTables.select.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:129: {$template_url} */
 echo $var["template_url"]; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:130: {$template_url} */
 echo $var["template_url"]; ?>plugins/fastclick/fastclick.js"></script><script src="<?php
/* backend/adminlte/index.tpl:131: {$template_url} */
 echo $var["template_url"]; ?>plugins/autoComplete/jquery.auto-complete.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:132: {$template_url} */
 echo $var["template_url"]; ?>dist/js/app.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:133: {$template_url} */
 echo $var["template_url"]; ?>plugins/validation/jquery.validate.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:134: {$template_url} */
 echo $var["template_url"]; ?>plugins/lobibox/js/notifications.min.js"></script><script src="<?php
/* backend/adminlte/index.tpl:135: {$template_url} */
 echo $var["template_url"]; ?>plugins/ajax-combobox/jquery.ajax-combobox.js"></script><script> Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, {  soundPath:"<?php
/* backend/adminlte/index.tpl:138: {$template_url} */
 echo $var["template_url"]; ?>plugins/lobibox/sounds/", showClass:'rollIn', hideClass:'rollOut'   }); </script><script src="<?php
/* backend/adminlte/index.tpl:145: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.extend.func.js"></script><script src="<?php
/* backend/adminlte/index.tpl:146: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/bootstrap.helper.js"></script><script src="<?php
/* backend/adminlte/index.tpl:147: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/datatables.helper.js"></script> <?php
/* backend/adminlte/index.tpl:148: {/var} */
 $var["resource"]['crud']=ob_get_clean();; ?> <!DOCTYPE html><html><head><link rel="shortcut icon" href="<?php
/* backend/adminlte/index.tpl:152: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>favicon.ico"><script type="text/javascript" src="<?php
/* backend/adminlte/index.tpl:153: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.func.js"></script><script type="text/javascript" src="<?php
/* backend/adminlte/index.tpl:154: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/form_crud.js"></script><script>  <?php
/* backend/adminlte/index.tpl:157: {var $head_title = $head_title !: $.const.APP_TITLE_B} */
 $var["head_title"]=(isset($var["head_title"]) ? $var["head_title"] : (@constant('APP_TITLE_B'))); ?> <?php
/* backend/adminlte/index.tpl:158: {var $page_title = $.const.TITLE_B} */
 $var["page_title"]=@constant('TITLE_B'); ?> <?php
/* backend/adminlte/index.tpl:159: {var $logo_text_mn = $.const.WEB_LOGO_TEXT_MN_B} */
 $var["logo_text_mn"]=@constant('WEB_LOGO_TEXT_MN_B'); ?> <?php
/* backend/adminlte/index.tpl:160: {var $logo_text_lg = $.const.WEB_LOGO_TEXT_LG_B} */
 $var["logo_text_lg"]=@constant('WEB_LOGO_TEXT_LG_B'); ?> <?php
/* backend/adminlte/index.tpl:162: {var $photo_url = $.php.base_url()~$.php.urldecode($.session.photo_url)} */
 $var["photo_url"]=(call_user_func_array('base_url', array()).strval(call_user_func_array('urldecode', array((isset($_SESSION["photo_url"]) ? $_SESSION["photo_url"] : null))))); ?> <?php
/* backend/adminlte/index.tpl:163: {var $home_link = $.php.base_url()~$.const.HOME_B_LNK} */
 $var["home_link"]=(call_user_func_array('base_url', array()).strval(@constant('HOME_B_LNK'))); ?> <?php
/* backend/adminlte/index.tpl:164: {var $login_link = $.php.base_url()~$.const.LOGIN_LNK} */
 $var["login_link"]=(call_user_func_array('base_url', array()).strval(@constant('LOGIN_LNK'))); ?> <?php
/* backend/adminlte/index.tpl:165: {var $logout_link = $.php.base_url()~$.const.LOGOUT_LNK} */
 $var["logout_link"]=(call_user_func_array('base_url', array()).strval(@constant('LOGOUT_LNK'))); ?> <?php
/* backend/adminlte/index.tpl:166: {var $profile_link = $.php.base_url()~$.const.PROFILE_LNK} */
 $var["profile_link"]=(call_user_func_array('base_url', array()).strval(@constant('PROFILE_LNK'))); ?> <?php
/* backend/adminlte/index.tpl:167: {var $skin = $.session.skin !: 'skin-purple'} */
 $var["skin"]=(((isset($_SESSION["skin"]) ? $_SESSION["skin"] : null) !== null) ? (isset($_SESSION["skin"]) ? $_SESSION["skin"] : null) : ('skin-purple')); ?> <?php
/* backend/adminlte/index.tpl:168: {var $sidebar = $.session.sidebar !: ''} */
 $var["sidebar"]=(((isset($_SESSION["sidebar"]) ? $_SESSION["sidebar"] : null) !== null) ? (isset($_SESSION["sidebar"]) ? $_SESSION["sidebar"] : null) : ('')); ?> var base_url = '<?php
/* backend/adminlte/index.tpl:169: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>'; var template_url = '<?php
/* backend/adminlte/index.tpl:170: {$template_url} */
 echo $var["template_url"]; ?>'; var Unlock_url = '<?php
/* backend/adminlte/index.tpl:171: {$.php.base_url()~$.const.UNLOCK_LNK} */
 echo (call_user_func_array('base_url', array()).strval(@constant('UNLOCK_LNK'))); ?>'; var Config_url = '<?php
/* backend/adminlte/index.tpl:172: {$.php.base_url()~$.const.CONFIG_LNK} */
 echo (call_user_func_array('base_url', array()).strval(@constant('CONFIG_LNK'))); ?>'; var SrcMenu_url = '<?php
/* backend/adminlte/index.tpl:173: {$.php.base_url()~$.const.SRCMENU_LNK} */
 echo (call_user_func_array('base_url', array()).strval(@constant('SRCMENU_LNK'))); ?>'; var ChgPwd_url = '<?php
/* backend/adminlte/index.tpl:174: {$.php.base_url()~$.const.CHGPWD_LNK} */
 echo (call_user_func_array('base_url', array()).strval(@constant('CHGPWD_LNK'))); ?>'; var InfoLst_url = '<?php
/* backend/adminlte/index.tpl:175: {$.php.base_url()~$.const.INFOLST_LNK} */
 echo (call_user_func_array('base_url', array()).strval(@constant('INFOLST_LNK'))); ?>'; var username = '<?php
/* backend/adminlte/index.tpl:176: {$.session.name} */
 echo (isset($_SESSION["name"]) ? $_SESSION["name"] : null); ?>'; store('skin', '<?php
/* backend/adminlte/index.tpl:178: {$skin} */
 echo $var["skin"]; ?>'); store('sidebar', '<?php
/* backend/adminlte/index.tpl:179: {$sidebar} */
 echo $var["sidebar"]; ?>'); store('screen_timeout', '<?php
/* backend/adminlte/index.tpl:180: {$.session.screen_timeout !: 60000} */
 echo (((isset($_SESSION["screen_timeout"]) ? $_SESSION["screen_timeout"] : null) !== null) ? (isset($_SESSION["screen_timeout"]) ? $_SESSION["screen_timeout"] : null) : (60000)); ?>'); <?php
/* backend/adminlte/index.tpl:182: {var $dashboard = $dashboard !: []} */
 $var["dashboard"]=(isset($var["dashboard"]) ? $var["dashboard"] : (array())); ?> <?php
/* backend/adminlte/index.tpl:183: {var $content_box_3 = $content_box_3 !: []} */
 $var["content_box_3"]=(isset($var["content_box_3"]) ? $var["content_box_3"] : (array())); ?> <?php
/* backend/adminlte/index.tpl:184: {var $include_box_3 = $include_box_3 !: []} */
 $var["include_box_3"]=(isset($var["include_box_3"]) ? $var["include_box_3"] : (array())); ?> <?php
/* backend/adminlte/index.tpl:185: {var $content_box_5 = $content_box_5 !: []} */
 $var["content_box_5"]=(isset($var["content_box_5"]) ? $var["content_box_5"] : (array())); ?> <?php
/* backend/adminlte/index.tpl:186: {var $include_box_5 = $include_box_5 !: []} */
 $var["include_box_5"]=(isset($var["include_box_5"]) ? $var["include_box_5"] : (array())); ?> <?php
/* backend/adminlte/index.tpl:187: {var $content_box_7 = $content_box_7 !: []} */
 $var["content_box_7"]=(isset($var["content_box_7"]) ? $var["content_box_7"] : (array())); ?> <?php
/* backend/adminlte/index.tpl:188: {var $include_box_7 = $include_box_7 !: []} */
 $var["include_box_7"]=(isset($var["include_box_7"]) ? $var["include_box_7"] : (array())); ?> <?php  if(!empty($var["dashboard"]) && (is_array($var["dashboard"]) || $var["dashboard"] instanceof \Traversable)) {
  foreach($var["dashboard"] as $var["board"]) { ?> <?php
/* backend/adminlte/index.tpl:190: {if ($board->type=='BOX-3')} */
 if(($var["board"]->type == 'BOX-3')) { ?> <?php
/* backend/adminlte/index.tpl:191: {var $content_box_3[] = "{$board->url}"} */
 $var["content_box_3"][]=($var["board"]->url).""; ?> <?php
/* backend/adminlte/index.tpl:192: {if (! empty($board->include_files))} */
 if((!empty($var["board"]->include_files))) { ?> <?php
/* backend/adminlte/index.tpl:193: {var $include_box_3[] = "{$board->include_files}"} */
 $var["include_box_3"][]=($var["board"]->include_files).""; ?> <?php
/* backend/adminlte/index.tpl:194: {/if} */
 } ?> <?php
/* backend/adminlte/index.tpl:195: {elseif ($board->type=='BOX-5')} */
 } elseif(($var["board"]->type == 'BOX-5')) { ?> <?php
/* backend/adminlte/index.tpl:196: {var $content_box_5[] = "{$board->url}"} */
 $var["content_box_5"][]=($var["board"]->url).""; ?> <?php
/* backend/adminlte/index.tpl:197: {if (! empty($board->include_files))} */
 if((!empty($var["board"]->include_files))) { ?> <?php
/* backend/adminlte/index.tpl:198: {var $include_box_5[] = "{$board->include_files}"} */
 $var["include_box_5"][]=($var["board"]->include_files).""; ?> <?php
/* backend/adminlte/index.tpl:199: {/if} */
 } ?> <?php
/* backend/adminlte/index.tpl:200: {elseif ($board->type=='BOX-7')} */
 } elseif(($var["board"]->type == 'BOX-7')) { ?> <?php
/* backend/adminlte/index.tpl:201: {var $content_box_7[] = "{$board->url}"} */
 $var["content_box_7"][]=($var["board"]->url).""; ?> <?php
/* backend/adminlte/index.tpl:202: {if (! empty($board->include_files))} */
 if((!empty($var["board"]->include_files))) { ?> <?php
/* backend/adminlte/index.tpl:203: {var $include_box_7[] = "{$board->include_files}"} */
 $var["include_box_7"][]=($var["board"]->include_files).""; ?> <?php
/* backend/adminlte/index.tpl:204: {/if} */
 } ?> <?php
/* backend/adminlte/index.tpl:205: {/if} */
 } ?> <?php
/* backend/adminlte/index.tpl:206: {/foreach} */
   } } ?> </script><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><title><?php
/* backend/adminlte/index.tpl:213: {$head_title} */
 echo $var["head_title"]; ?></title> <?php
/* backend/adminlte/index.tpl:215: {$resource[$category]} */
 echo $var["resource"][$var["category"]]; ?> </head><body class="hold-transition <?php
/* backend/adminlte/index.tpl:218: {$skin} */
 echo $var["skin"]; ?> fixed sidebar-mini <?php
/* backend/adminlte/index.tpl:218: {$sidebar} */
 echo $var["sidebar"]; ?>"><!-- Site wrapper --><div class="wrapper">  <?php
/* backend/adminlte/index.tpl:224: {include $theme_path ~ "include/main_header.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/main_header.tpl")))->display($var); ?> <!-- =============================================== --><!-- Left side column. contains the sidebar -->  <?php
/* backend/adminlte/index.tpl:230: {include $theme_path ~ "include/navbar_left.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/navbar_left.tpl")))->display($var); ?> <!-- =============================================== --><!-- Content Wrapper. Contains page content --> <?php
/* backend/adminlte/index.tpl:235: {include $content} */
 $tpl->getStorage()->getTemplate($var["content"])->display($var); ?> <!-- /.content-wrapper -->  <?php
/* backend/adminlte/index.tpl:239: {include $theme_path ~ "include/main_footer.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/main_footer.tpl")))->display($var); ?> <!-- Control Sidebar -->  <?php
/* backend/adminlte/index.tpl:243: {include $theme_path ~ "include/navbar_right.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/navbar_right.tpl")))->display($var); ?> <!-- /.control-sidebar --><!-- Add the sidebar's background. This div must be placed immediately after the control sidebar --><div class="control-sidebar-bg"></div></div><!-- ./wrapper --> <?php
/* backend/adminlte/index.tpl:253: {include $theme_path ~ "include/lockscreen.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/lockscreen.tpl")))->display($var); ?> <?php
/* backend/adminlte/index.tpl:255: {if (count($content_box_5) > 0 || count($content_box_7) > 0)} */
 if((count($var["content_box_5"]) > 0 || count($var["content_box_7"]) > 0)) { ?> <?php  if(!empty($var["include_box_5"]) && (is_array($var["include_box_5"]) || $var["include_box_5"] instanceof \Traversable)) {
  foreach($var["include_box_5"] as $var["inc"]) { ?> <?php
/* backend/adminlte/index.tpl:257: {include $theme_path ~ "pages/{$inc}"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("pages/".($var["inc"])."")))->display($var); ?> <?php
/* backend/adminlte/index.tpl:258: {/foreach} */
   } } ?> <?php  if(!empty($var["include_box_7"]) && (is_array($var["include_box_7"]) || $var["include_box_7"] instanceof \Traversable)) {
  foreach($var["include_box_7"] as $var["inc"]) { ?> <?php
/* backend/adminlte/index.tpl:260: {include $theme_path ~ "pages/{$inc}"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("pages/".($var["inc"])."")))->display($var); ?> <?php
/* backend/adminlte/index.tpl:261: {/foreach} */
   } } ?> <?php
/* backend/adminlte/index.tpl:262: {/if} */
 } ?> <script src="<?php
/* backend/adminlte/index.tpl:263: {$template_url} */
 echo $var["template_url"]; ?>js/custom.js"></script><script src="<?php
/* backend/adminlte/index.tpl:264: {$template_url} */
 echo $var["template_url"]; ?>js/xform.js"></script></body></html><?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/index.tpl',
	'base_name' => 'backend/adminlte/index.tpl',
	'time' => 1488183389,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/index.tpl' => 1488183389,
  ),
),
	'macros' => array(),

        ));
