<?php 
/** Fenom template '/frontend/adminlte/pages/404.tpl' compiled at 2017-03-09 13:14:52 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <!-- Content Wrapper. Contains page content --><div class="content-wrapper"><!-- Content Header (Page header) --><section class="content-header"><h1> 404 Error Page </h1><ol class="breadcrumb"><li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li><li class="active">404 error</li></ol></section><!-- Main content --><section class="content"><div class="error-page"><h2 class="headline text-yellow"> 404</h2><div class="error-content"><h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3><p> We could not find the page you were looking for. Meanwhile, you may <a href="<?php
/* /frontend/adminlte/pages/404.tpl:24: {$.const.HOME_LINK} */
 echo @constant('HOME_LINK'); ?>">return to dashboard</a> or try using the search form. </p> <?php
/* /frontend/adminlte/pages/404.tpl:27: {$message} */
 echo $var["message"]; ?> </div><!-- /.error-content --></div><!-- /.error-page --></section><!-- /.content --></div><!-- /.content-wrapper --> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/adminlte/pages/404.tpl',
	'base_name' => '/frontend/adminlte/pages/404.tpl',
	'time' => 1489025225,
	'depends' => array (
  0 => 
  array (
    '/frontend/adminlte/pages/404.tpl' => 1489025225,
  ),
),
	'macros' => array(),

        ));
