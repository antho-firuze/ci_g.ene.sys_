<?php 
/** Fenom template '/frontend/adminlte/include/navbar_left.tpl' compiled at 2017-03-09 13:14:45 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <aside class="main-sidebar"><!-- sidebar: style can be found in sidebar.less --><section class="sidebar"><!-- Sidebar user panel -->  <!-- search form -->  <!-- /.search form --><!-- sidebar menu: : style can be found in sidebar.less --><ul class="sidebar-menu"><li class="header">MENU | <?php
/* /frontend/adminlte/include/navbar_left.tpl:27: {$page_title} */
 echo $var["page_title"]; ?></li> <?php
/* /frontend/adminlte/include/navbar_left.tpl:28: {$menus} */
 echo $var["menus"]; ?> </ul></section><!-- /.sidebar --></aside> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/adminlte/include/navbar_left.tpl',
	'base_name' => '/frontend/adminlte/include/navbar_left.tpl',
	'time' => 1489024683,
	'depends' => array (
  0 => 
  array (
    '/frontend/adminlte/include/navbar_left.tpl' => 1489024683,
  ),
),
	'macros' => array(),

        ));
