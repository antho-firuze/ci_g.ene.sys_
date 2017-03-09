<?php 
/** Fenom template 'frontend/simplelte/index.tpl' compiled at 2017-03-09 13:48:39 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><title><?php
/* frontend/simplelte/index.tpl:14: {$head_title} */
 echo $var["head_title"]; ?></title><script type="text/javascript" src="<?php
/* frontend/simplelte/index.tpl:15: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.func.js"></script><script>  var base_url = '<?php
/* frontend/simplelte/index.tpl:18: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>'; </script><link rel="shortcut icon" href="favicon.ico"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:23: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:24: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/pace/pace.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:25: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>font-awesome/css/font-awesome.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:26: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>dist/css/AdminLTE.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:27: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>dist/css/skins/_all-skins.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:28: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jQueryUI/jquery-ui.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:29: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/marquee/css/jquery.marquee.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:30: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/Malihu-Scrollbar/jquery.mCustomScrollbar.min.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:31: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/Magnific-Popup/magnific-popup.css"><link rel="stylesheet" href="<?php
/* frontend/simplelte/index.tpl:32: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>css/custom.css"><script src="<?php
/* frontend/simplelte/index.tpl:34: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:35: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>bootstrap/js/bootstrap.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:36: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/pace/pace.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:37: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/fastclick/fastclick.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:38: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>dist/js/app.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:39: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:40: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/jQueryUI/jquery-ui.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:41: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/marquee/lib/jquery.marquee.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:42: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/Malihu-Scrollbar/jquery.mCustomScrollbar.min.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:43: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>plugins/Magnific-Popup/jquery.magnific-popup.min.js"></script><script type="text/javascript" src="<?php
/* frontend/simplelte/index.tpl:44: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/bootstrap.helper.js"></script><script src="<?php
/* frontend/simplelte/index.tpl:45: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>js/product_info.js"></script></head><body class="hold-transition skin-red fixed sidebar-mini"><!-- Site wrapper --><div class="wrapper">  <?php
/* frontend/simplelte/index.tpl:54: {include $theme_path ~ "include/main_header.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/main_header.tpl")))->display($var); ?> <!-- =============================================== --><!-- Left side column. contains the sidebar -->   <!-- =============================================== --><!-- Content Wrapper. Contains page content --> <?php
/* frontend/simplelte/index.tpl:65: {include $content} */
 $tpl->getStorage()->getTemplate($var["content"])->display($var); ?>  <!-- /.content-wrapper -->  <?php
/* frontend/simplelte/index.tpl:70: {include $theme_path ~ "include/main_footer.tpl"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("include/main_footer.tpl")))->display($var); ?> <!-- Control Sidebar -->   <!-- /.control-sidebar --><!-- Add the sidebar's background. This div must be placed immediately after the control sidebar --><div class="control-sidebar-bg"></div></div><!-- ./wrapper --><script src="<?php
/* frontend/simplelte/index.tpl:83: {$.const.TEMPLATE_URL} */
 echo @constant('TEMPLATE_URL'); ?>js/custom.js"></script></body></html><?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'frontend/simplelte/index.tpl',
	'base_name' => 'frontend/simplelte/index.tpl',
	'time' => 1489040671,
	'depends' => array (
  0 => 
  array (
    'frontend/simplelte/index.tpl' => 1489040671,
  ),
),
	'macros' => array(),

        ));
