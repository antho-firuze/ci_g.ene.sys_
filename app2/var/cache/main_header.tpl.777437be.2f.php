<?php 
/** Fenom template 'frontend/adminlte/include/main_header.tpl' compiled at 2017-03-07 11:29:06 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <header class="main-header"><!-- Logo --><a href="<?php
/* frontend/adminlte/include/main_header.tpl:3: {$home_link} */
 echo $var["home_link"]; ?>" class="logo"><!-- mini logo for sidebar mini 50x50 pixels --><span class="logo-mini"><b><?php
/* frontend/adminlte/include/main_header.tpl:5: {$logo_text_mn} */
 echo $var["logo_text_mn"]; ?></b></span><!-- logo for regular state and mobile devices --><span class="logo-lg"><b><?php
/* frontend/adminlte/include/main_header.tpl:7: {$logo_text_lg} */
 echo $var["logo_text_lg"]; ?></b></span></a><!-- Header Navbar: style can be found in header.less --><nav class="navbar navbar-static-top" role="navigation"><!-- Sidebar toggle button--><a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><!-- search form -->  <!-- /.search form --><div class="navbar-custom-menu"><ul class="nav navbar-nav"><!-- Messages: style can be found in dropdown.less--> <?php
/* frontend/adminlte/include/main_header.tpl:34: {if (isset($message_navbar))} */
 if((isset($var["message_navbar"]))) { ?> <li class="dropdown messages-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i><span class="label label-success">4</span></a><ul class="dropdown-menu"><li class="header">You have 4 messages</li><li><!-- inner menu: contains the actual data --><ul class="menu"><li><!-- start message --><a href="#"><div class="pull-left"><img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"></div><h4> Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h4><p>Why not buy a new awesome theme?</p></a></li><!-- end message --></ul></li><li class="footer"><a href="#">See All Messages</a></li></ul></li> <?php
/* frontend/adminlte/include/main_header.tpl:63: {/if} */
 } ?> <!-- Notifications: style can be found in dropdown.less --> <?php
/* frontend/adminlte/include/main_header.tpl:65: {if (isset($notofication_navbar))} */
 if((isset($var["notofication_navbar"]))) { ?> <li class="dropdown notifications-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="label label-warning">10</span></a><ul class="dropdown-menu"><li class="header">You have 10 notifications</li><li><!-- inner menu: contains the actual data --><ul class="menu"><li><a href="#"><i class="fa fa-users text-aqua"></i> 5 new members joined today </a></li></ul></li><li class="footer"><a href="#">View all</a></li></ul></li> <?php
/* frontend/adminlte/include/main_header.tpl:86: {/if} */
 } ?> <!-- Tasks: style can be found in dropdown.less --> <?php
/* frontend/adminlte/include/main_header.tpl:88: {if (isset($tasks_navbar))} */
 if((isset($var["tasks_navbar"]))) { ?> <li class="dropdown tasks-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag-o"></i><span class="label label-danger">9</span></a><ul class="dropdown-menu"><li class="header">You have 9 tasks</li><li><!-- inner menu: contains the actual data --><ul class="menu"><li><!-- Task item --><a href="#"><h3> Design some buttons <small class="pull-right">20%</small></h3><div class="progress xs"><div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">20% Complete</span></div></div></a></li><!-- end task item --></ul></li><li class="footer"><a href="#">View all tasks</a></li></ul></li> <?php
/* frontend/adminlte/include/main_header.tpl:120: {/if} */
 } ?> <!-- Sign In/Login: style can be found in dropdown.less --><li><a target="_blank" href="<?php
/* frontend/adminlte/include/main_header.tpl:123: {$login_link} */
 echo $var["login_link"]; ?>"><i class="fa fa-lock"></i><span class="hidden-xs"> &nbsp;&nbsp;&nbsp; Login</span></a></li><!-- User Account: style can be found in dropdown.less -->  <!-- Control Sidebar Toggle Button -->  </ul></div></nav></header> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'frontend/adminlte/include/main_header.tpl',
	'base_name' => 'frontend/adminlte/include/main_header.tpl',
	'time' => 1486718837,
	'depends' => array (
  0 => 
  array (
    'frontend/adminlte/include/main_header.tpl' => 1486718837,
  ),
),
	'macros' => array(),

        ));
