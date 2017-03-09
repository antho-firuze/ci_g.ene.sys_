<?php 
/** Fenom template '/frontend/simplelte/include/main_header.tpl' compiled at 2017-03-09 13:51:09 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <header class="main-header"><!-- Logo --><a href="<?php
/* /frontend/simplelte/include/main_header.tpl:3: {$.const.HOME_LINK} */
 echo @constant('HOME_LINK'); ?>" class="logo"><!-- mini logo for sidebar mini 50x50 pixels --><span class="logo-mini"><b><?php
/* /frontend/simplelte/include/main_header.tpl:5: {$logo_text_mn} */
 echo $var["logo_text_mn"]; ?></b></span><!-- logo for regular state and mobile devices --><span class="logo-lg"><b>IPRODUCT</b></span></a><!-- Header Navbar: style can be found in header.less --></header> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/simplelte/include/main_header.tpl',
	'base_name' => '/frontend/simplelte/include/main_header.tpl',
	'time' => 1489040725,
	'depends' => array (
  0 => 
  array (
    '/frontend/simplelte/include/main_header.tpl' => 1489040725,
  ),
),
	'macros' => array(),

        ));
