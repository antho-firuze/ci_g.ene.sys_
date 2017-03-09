<?php 
/** Fenom template '/frontend/adminlte/index.tpl' compiled at 2017-03-09 13:14:45 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <!DOCTYPE html><html><head><meta name="robots" content="no-cache, no-cache"><meta http-equiv="Content-type" content="text/html; charset=utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title><?php
/* /frontend/adminlte/index.tpl:15: {$head_title} */
 echo $var["head_title"]; ?></title> <?php
/* /frontend/adminlte/index.tpl:17: {$.php.link_tag('favicon.ico', 'shortcut icon', 'image/ico')} */
 echo call_user_func_array('link_tag', array('favicon.ico', 'shortcut icon', 'image/ico')); ?> <?php
/* /frontend/adminlte/index.tpl:18: {$.php.link_tag($.const.TEMPLATE_URL~'bootstrap/css/bootstrap.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('bootstrap/css/bootstrap.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:19: {$.php.link_tag($.const.TEMPLATE_URL~'font-awesome/css/font-awesome.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('font-awesome/css/font-awesome.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:20: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/ionicons/css/ionicons.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/ionicons/css/ionicons.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:21: {$.php.link_tag($.const.TEMPLATE_URL~'dist/css/AdminLTE.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('dist/css/AdminLTE.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:22: {$.php.link_tag($.const.TEMPLATE_URL~'dist/css/skins/_all-skins.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('dist/css/skins/_all-skins.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:23: {$.php.link_tag($.const.TEMPLATE_URL~'css/custom.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('css/custom.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:24: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/pace/pace.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/pace/pace.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:25: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/iCheck/flat/blue.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/iCheck/flat/blue.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:26: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/bootstrap-dialog/css/bootstrap-dialog.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/bootstrap-dialog/css/bootstrap-dialog.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:27: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/morris/morris.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/morris/morris.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:28: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/jvectormap/jquery-jvectormap-1.2.2.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/jvectormap/jquery-jvectormap-1.2.2.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:29: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/datepicker/datepicker3.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/datepicker/datepicker3.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:30: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/daterangepicker/daterangepicker-bs3.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/daterangepicker/daterangepicker-bs3.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:31: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:32: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/autoComplete/jquery.auto-complete.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/autoComplete/jquery.auto-complete.css')))); ?> <?php
/* /frontend/adminlte/index.tpl:33: {$.php.link_tag($.const.TEMPLATE_URL~'plugins/marquee/css/jquery.marquee.min.css')} */
 echo call_user_func_array('link_tag', array((@constant('TEMPLATE_URL').strval('plugins/marquee/css/jquery.marquee.min.css')))); ?> <script src="<?php
/* /frontend/adminlte/index.tpl:35: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.func.js"></script><script>  <?php
/* /frontend/adminlte/index.tpl:38: {var $login_link = $.php.base_url()~$.const.LOGIN_LNK} */
 $var["login_link"]=(call_user_func_array('base_url', array()).strval(@constant('LOGIN_LNK'))); ?>     if (!get('skin')) store('skin', '<?php
/* /frontend/adminlte/index.tpl:45: {$skin_color} */
 echo $var["skin_color"]; ?>'); </script><script src="<?php
/* /frontend/adminlte/index.tpl:48: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:49: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jQueryUI/jquery-ui.min.js"></script><script>$.widget.bridge("uibutton", $.ui.button);</script><script src="<?php
/* /frontend/adminlte/index.tpl:51: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>bootstrap/js/bootstrap.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:52: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/pace/pace.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:53: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:54: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/raphael/raphael-min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:55: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/morris/morris.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:56: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/sparkline/jquery.sparkline.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:57: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:58: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:59: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/knob/jquery.knob.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:60: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/moment/min/moment.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:61: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/daterangepicker/daterangepicker.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:62: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/datepicker/bootstrap-datepicker.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:63: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:64: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:65: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/fastclick/fastclick.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:66: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/autoComplete/jquery.auto-complete.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:67: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>dist/js/app.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:68: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/validation/jquery.validate.min.js"></script><script src="<?php
/* /frontend/adminlte/index.tpl:69: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/marquee/lib/jquery.marquee.min.js"></script></head><body class="hold-transition sidebar-mini"><!-- Site wrapper --><div class="wrapper">  <?php
/* /frontend/adminlte/index.tpl:78: {include $.const.TEMPLATE_PATH ~ "include/main_header.tpl"} */
 $tpl->getStorage()->getTemplate((@constant('TEMPLATE_PATH').strval("include/main_header.tpl")))->display($var); ?> <!-- =============================================== --><!-- Left side column. contains the sidebar -->  <?php
/* /frontend/adminlte/index.tpl:84: {include $.const.TEMPLATE_PATH ~ "include/navbar_left.tpl"} */
 $tpl->getStorage()->getTemplate((@constant('TEMPLATE_PATH').strval("include/navbar_left.tpl")))->display($var); ?> <!-- =============================================== --><!-- Content Wrapper. Contains page content --> <?php
/* /frontend/adminlte/index.tpl:89: {include $content} */
 $tpl->getStorage()->getTemplate($var["content"])->display($var); ?>  <!-- /.content-wrapper -->  <?php
/* /frontend/adminlte/index.tpl:94: {include $.const.TEMPLATE_PATH ~ "include/main_footer.tpl"} */
 $tpl->getStorage()->getTemplate((@constant('TEMPLATE_PATH').strval("include/main_footer.tpl")))->display($var); ?> <!-- Control Sidebar -->  <?php
/* /frontend/adminlte/index.tpl:98: {include $.const.TEMPLATE_PATH ~ "include/navbar_right.tpl"} */
 $tpl->getStorage()->getTemplate((@constant('TEMPLATE_PATH').strval("include/navbar_right.tpl")))->display($var); ?> <!-- /.control-sidebar --><!-- Add the sidebar's background. This div must be placed immediately after the control sidebar --><div class="control-sidebar-bg"></div></div><!-- ./wrapper --><script type="text/javascript" src="<?php
/* /frontend/adminlte/index.tpl:107: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>js/custom.js"></script><script>$(document.body).addClass(get('sidebar')).addClass(get('skin'));</script></body></html><?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/adminlte/index.tpl',
	'base_name' => '/frontend/adminlte/index.tpl',
	'time' => 1489035075,
	'depends' => array (
  0 => 
  array (
    '/frontend/adminlte/index.tpl' => 1489035075,
  ),
),
	'macros' => array(),

        ));
