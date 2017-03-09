<?php 
/** Fenom template 'backend/adminlte/include/main_header.tpl' compiled at 2017-03-08 16:40:21 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <header class="main-header"><!-- Logo --><a href="<?php
/* backend/adminlte/include/main_header.tpl:3: {$home_link} */
 echo $var["home_link"]; ?>" class="logo"><!-- mini logo for sidebar mini 50x50 pixels --><span class="logo-mini"><b><?php
/* backend/adminlte/include/main_header.tpl:5: {$logo_text_mn} */
 echo $var["logo_text_mn"]; ?></b></span><!-- logo for regular state and mobile devices --><span class="logo-lg"><b><?php
/* backend/adminlte/include/main_header.tpl:7: {$logo_text_lg} */
 echo $var["logo_text_lg"]; ?></b></span></a><!-- Header Navbar: style can be found in header.less --><nav class="navbar navbar-static-top" role="navigation"><!-- Sidebar toggle button--><a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><!-- search form -->  <div class="navbar-form navbar-left sidebar-form"><div class="input-group"><input type="text" id="searching-menu" name="q" class="form-control" autocomplete="off" placeholder="Searching Menu..."><span class="input-group-btn"><button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button></span></div></div>  <!-- /.search form --><div class="navbar-custom-menu"><ul class="nav navbar-nav"><!-- Messages: style can be found in dropdown.less--> <?php
/* backend/adminlte/include/main_header.tpl:36: {if (isset($message_navbar))} */
 if((isset($var["message_navbar"]))) { ?> <li class="dropdown messages-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i><span class="label label-success">4</span></a><ul class="dropdown-menu"><li class="header">You have 4 messages</li><li><!-- inner menu: contains the actual data --><ul class="menu"><li><!-- start message --><a href="#"><div class="pull-left"><img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"></div><h4> Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h4><p>Why not buy a new awesome theme?</p></a></li><!-- end message --></ul></li><li class="footer"><a href="#">See All Messages</a></li></ul></li> <?php
/* backend/adminlte/include/main_header.tpl:65: {/if} */
 } ?> <!-- Notifications: style can be found in dropdown.less --> <?php
/* backend/adminlte/include/main_header.tpl:67: {if (isset($notofication_navbar))} */
 if((isset($var["notofication_navbar"]))) { ?> <li class="dropdown notifications-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="label label-warning">10</span></a><ul class="dropdown-menu"><li class="header">You have 10 notifications</li><li><!-- inner menu: contains the actual data --><ul class="menu"><li><a href="#"><i class="fa fa-users text-aqua"></i> 5 new members joined today </a></li></ul></li><li class="footer"><a href="#">View all</a></li></ul></li> <?php
/* backend/adminlte/include/main_header.tpl:88: {/if} */
 } ?> <!-- Tasks: style can be found in dropdown.less --> <?php
/* backend/adminlte/include/main_header.tpl:90: {if (isset($tasks_navbar))} */
 if((isset($var["tasks_navbar"]))) { ?> <li class="dropdown tasks-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag-o"></i><span class="label label-danger">9</span></a><ul class="dropdown-menu"><li class="header">You have 9 tasks</li><li><!-- inner menu: contains the actual data --><ul class="menu"><li><!-- Task item --><a href="#"><h3> Design some buttons <small class="pull-right">20%</small></h3><div class="progress xs"><div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">20% Complete</span></div></div></a></li><!-- end task item --></ul></li><li class="footer"><a href="#">View all tasks</a></li></ul></li> <?php
/* backend/adminlte/include/main_header.tpl:122: {/if} */
 } ?> <!-- User Account: style can be found in dropdown.less --><li class="dropdown user user-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php
/* backend/adminlte/include/main_header.tpl:126: {$photo_url} */
 echo $var["photo_url"]; ?>" class="user-image" alt="User Image"><span class="hidden-xs"><?php
/* backend/adminlte/include/main_header.tpl:127: {$.session.name} */
 echo (isset($_SESSION["name"]) ? $_SESSION["name"] : null); ?></span></a><ul class="dropdown-menu"><!-- User image --><li class="user-header"><img src="<?php
/* backend/adminlte/include/main_header.tpl:132: {$photo_url} */
 echo $var["photo_url"]; ?>" class="img-circle" alt="User Image"><p> <?php
/* backend/adminlte/include/main_header.tpl:135: {$.session.name} */
 echo (isset($_SESSION["name"]) ? $_SESSION["name"] : null); ?> - <?php
/* backend/adminlte/include/main_header.tpl:135: {$.session.email} */
 echo (isset($_SESSION["email"]) ? $_SESSION["email"] : null); ?> <small><?php
/* backend/adminlte/include/main_header.tpl:136: {$.session.description} */
 echo (isset($_SESSION["description"]) ? $_SESSION["description"] : null); ?></small></p></li><!-- Menu Body --><li class="user-body"><div class="row"><div class="col-xs-4 text-left"> Client: </div><div class="col-xs-8 text-left"><a href="#"><?php
/* backend/adminlte/include/main_header.tpl:146: {$.session.client_name} */
 echo (isset($_SESSION["client_name"]) ? $_SESSION["client_name"] : null); ?></a></div></div><div class="row"><div class="col-xs-4 text-left"> Organization: </div><div class="col-xs-8 text-left"><a href="#"><?php
/* backend/adminlte/include/main_header.tpl:154: {$.session.org_name} */
 echo (isset($_SESSION["org_name"]) ? $_SESSION["org_name"] : null); ?></a></div></div><div class="row"><div class="col-xs-4 text-left"> Role: </div><div class="col-xs-8 text-left"><a href="#"><?php
/* backend/adminlte/include/main_header.tpl:162: {$.session.role_name} */
 echo (isset($_SESSION["role_name"]) ? $_SESSION["role_name"] : null); ?></a></div></div><!-- /.row --></li><!-- Menu Footer--><li class="user-footer"><div class="pull-left"><a href="<?php
/* backend/adminlte/include/main_header.tpl:170: {$profile_link} */
 echo $var["profile_link"]; ?>" class="btn btn-default btn-flat">Profile</a></div><div class="pull-right"><a href="<?php
/* backend/adminlte/include/main_header.tpl:173: {$logout_link} */
 echo $var["logout_link"]; ?>" class="btn btn-default btn-flat">Sign out</a></div></li></ul></li><!-- Control Sidebar Toggle Button --><li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li></ul></div></nav></header><?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/include/main_header.tpl',
	'base_name' => 'backend/adminlte/include/main_header.tpl',
	'time' => 1487553826,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/include/main_header.tpl' => 1487553826,
  ),
),
	'macros' => array(),

        ));
