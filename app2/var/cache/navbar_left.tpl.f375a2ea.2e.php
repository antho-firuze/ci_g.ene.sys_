<?php 
/** Fenom template 'backend/adminlte/include/navbar_left.tpl' compiled at 2017-03-08 16:40:21 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <aside class="main-sidebar"><!-- sidebar: style can be found in sidebar.less --><section class="sidebar"><!-- Sidebar user panel --><div class="user-panel"><div class="pull-left image"><img src="<?php
/* backend/adminlte/include/navbar_left.tpl:7: {$photo_url} */
 echo $var["photo_url"]; ?>" class="img-circle" alt="User Image"></div><div class="pull-left info"><p><?php
/* backend/adminlte/include/navbar_left.tpl:10: {$.session.name} */
 echo (isset($_SESSION["name"]) ? $_SESSION["name"] : null); ?></p><a href="#"><i class="fa fa-circle text-success"></i> Online</a></div></div><!-- search form -->  <!-- /.search form --><!-- sidebar menu: : style can be found in sidebar.less --><ul class="sidebar-menu"><li class="header">MENU</li> <?php
/* backend/adminlte/include/navbar_left.tpl:28: {var $idx = 1} */
 $var["idx"]=1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:29: {var $menu_id1 = 0} */
 $var["menu_id1"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:30: {var $menu_id2 = 0} */
 $var["menu_id2"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:31: {var $menu_id3 = 0} */
 $var["menu_id3"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:32: {var $close_menu1 = 0} */
 $var["close_menu1"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:33: {var $close_menu2 = 0} */
 $var["close_menu2"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:34: {var $close_menu3 = 0} */
 $var["close_menu3"]=0; ?> <?php  if(!empty($var["menus"]) && (is_array($var["menus"]) || $var["menus"] instanceof \Traversable)) {
  foreach($var["menus"] as $var["menu"]) { ?> <?php
/* backend/adminlte/include/navbar_left.tpl:36: {if ($menu_id1 != $menu->menu_id1 && !empty($menu->menu_id1))} */
 if(($var["menu_id1"] != $var["menu"]->menu_id1 && !empty($var["menu"]->menu_id1))) { ?> <?php
/* backend/adminlte/include/navbar_left.tpl:38: {if ($close_menu3)} */
 if(($var["close_menu3"])) { ?> </li></ul> <?php
/* backend/adminlte/include/navbar_left.tpl:40: {var $close_menu3 = 0} */
 $var["close_menu3"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:41: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:42: {if ($close_menu2)} */
 if(($var["close_menu2"])) { ?> </li></ul> <?php
/* backend/adminlte/include/navbar_left.tpl:44: {var $close_menu2 = 0} */
 $var["close_menu2"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:45: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:46: {if ($close_menu1)} */
 if(($var["close_menu1"])) { ?> </li> <?php
/* backend/adminlte/include/navbar_left.tpl:48: {var $close_menu1 = 0} */
 $var["close_menu1"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:49: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:51: {if ($idx == 1)} */
 if(($var["idx"] == 1)) { ?> <li class="treeview"><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:53: {$home_link} */
 echo $var["home_link"]; ?>"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li> <?php
/* backend/adminlte/include/navbar_left.tpl:55: {/if} */
 } ?> <li class="treeview"><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:58: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>systems/x_page?pageid=<?php
/* backend/adminlte/include/navbar_left.tpl:58: {$menu->menu_id1} */
 echo $var["menu"]->menu_id1; ?>" data-menu_id="<?php
/* backend/adminlte/include/navbar_left.tpl:58: {$menu->menu_id1} */
 echo $var["menu"]->menu_id1; ?>"><i class="fa <?php
/* backend/adminlte/include/navbar_left.tpl:58: {$menu->icon1 !: 'fa-circle'} */
 echo (isset($var["menu"]->icon1) ? $var["menu"]->icon1 : ('fa-circle')); ?>"></i><span><?php
/* backend/adminlte/include/navbar_left.tpl:59: {$menu->name1} */
 echo $var["menu"]->name1; ?></span> <?php
/* backend/adminlte/include/navbar_left.tpl:59: {if !empty($menu->menu_id2)} */
 if(!empty($var["menu"]->menu_id2)) { ?> <i class="fa fa-angle-left pull-right"></i><?php
/* backend/adminlte/include/navbar_left.tpl:59: {/if} */
 } ?> </a> <?php
/* backend/adminlte/include/navbar_left.tpl:62: {if ($menu_id2 != $menu->menu_id2 && !empty($menu->menu_id2)) } */
 if(($var["menu_id2"] != $var["menu"]->menu_id2 && !empty($var["menu"]->menu_id2))) { ?> <ul class="treeview-menu"><li class="<?php
/* backend/adminlte/include/navbar_left.tpl:64: {if ($menu->name2 == 'User')} */
 if(($var["menu"]->name2 == 'User')) { ?> active <?php
/* backend/adminlte/include/navbar_left.tpl:64: {/if} */
 } ?>"><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:65: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>systems/x_page?pageid=<?php
/* backend/adminlte/include/navbar_left.tpl:65: {$menu->menu_id2} */
 echo $var["menu"]->menu_id2; ?>" data-menu_id="<?php
/* backend/adminlte/include/navbar_left.tpl:65: {$menu->menu_id2} */
 echo $var["menu"]->menu_id2; ?>"><i class="fa <?php
/* backend/adminlte/include/navbar_left.tpl:65: {$menu->icon2 !: 'fa-circle-o'} */
 echo (isset($var["menu"]->icon2) ? $var["menu"]->icon2 : ('fa-circle-o')); ?>"></i> <?php
/* backend/adminlte/include/navbar_left.tpl:65: {$menu->name2} */
 echo $var["menu"]->name2; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:66: {if !empty($menu->menu_id3)} */
 if(!empty($var["menu"]->menu_id3)) { ?> <i class="fa fa-angle-left pull-right"></i><?php
/* backend/adminlte/include/navbar_left.tpl:66: {/if} */
 } ?> </a> <?php
/* backend/adminlte/include/navbar_left.tpl:69: {if ($menu_id3 != $menu->menu_id3 && !empty($menu->menu_id3)) } */
 if(($var["menu_id3"] != $var["menu"]->menu_id3 && !empty($var["menu"]->menu_id3))) { ?> <ul class="treeview-menu"><li><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:71: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>systems/x_page?pageid=<?php
/* backend/adminlte/include/navbar_left.tpl:71: {$menu->menu_id3} */
 echo $var["menu"]->menu_id3; ?>" data-menu_id="<?php
/* backend/adminlte/include/navbar_left.tpl:71: {$menu->menu_id3} */
 echo $var["menu"]->menu_id3; ?>"><i class="fa <?php
/* backend/adminlte/include/navbar_left.tpl:71: {$menu->icon2 !: 'fa-circle-o'} */
 echo (isset($var["menu"]->icon2) ? $var["menu"]->icon2 : ('fa-circle-o')); ?>"></i> <?php
/* backend/adminlte/include/navbar_left.tpl:71: {$menu->name3} */
 echo $var["menu"]->name3; ?></a> <?php
/* backend/adminlte/include/navbar_left.tpl:73: {var $close_menu3 = 1} */
 $var["close_menu3"]=1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:74: {var $menu_id3 = $menu->menu_id3} */
 $var["menu_id3"]=$var["menu"]->menu_id3; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:75: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:78: {var $close_menu2 = 1} */
 $var["close_menu2"]=1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:79: {var $menu_id2 = $menu->menu_id2} */
 $var["menu_id2"]=$var["menu"]->menu_id2; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:80: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:82: {var $close_menu1 = 1} */
 $var["close_menu1"]=1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:84: {elseif ($menu_id1 == $menu->menu_id1)} */
 } elseif(($var["menu_id1"] == $var["menu"]->menu_id1)) { ?> <?php
/* backend/adminlte/include/navbar_left.tpl:86: {if ($close_menu3)} */
 if(($var["close_menu3"])) { ?> </li></ul> <?php
/* backend/adminlte/include/navbar_left.tpl:88: {var $close_menu3 = 0} */
 $var["close_menu3"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:89: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:90: {if ($close_menu2)} */
 if(($var["close_menu2"])) { ?> </li> <?php
/* backend/adminlte/include/navbar_left.tpl:92: {var $close_menu2 = 0} */
 $var["close_menu2"]=0; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:93: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:95: {if ($menu_id2 != $menu->menu_id2 && !empty($menu->menu_id2)) } */
 if(($var["menu_id2"] != $var["menu"]->menu_id2 && !empty($var["menu"]->menu_id2))) { ?> <li><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:96: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>systems/x_page?pageid=<?php
/* backend/adminlte/include/navbar_left.tpl:96: {$menu->menu_id2} */
 echo $var["menu"]->menu_id2; ?>" data-menu_id="<?php
/* backend/adminlte/include/navbar_left.tpl:96: {$menu->menu_id2} */
 echo $var["menu"]->menu_id2; ?>"><i class="fa fa-circle-o"></i> <?php
/* backend/adminlte/include/navbar_left.tpl:96: {$menu->name2} */
 echo $var["menu"]->name2; ?></a> <?php
/* backend/adminlte/include/navbar_left.tpl:98: {var $close_menu2 = 1} */
 $var["close_menu2"]=1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:99: {var $menu_id2 = $menu->menu_id2} */
 $var["menu_id2"]=$var["menu"]->menu_id2; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:101: {elseif ($menu_id2 == $menu->menu_id2)} */
 } elseif(($var["menu_id2"] == $var["menu"]->menu_id2)) { ?> <li><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:102: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>systems/x_page?pageid=<?php
/* backend/adminlte/include/navbar_left.tpl:102: {$menu->menu_id3} */
 echo $var["menu"]->menu_id3; ?>" data-menu_id="<?php
/* backend/adminlte/include/navbar_left.tpl:102: {$menu->menu_id3} */
 echo $var["menu"]->menu_id3; ?>"><i class="fa fa-circle-o"></i> <?php
/* backend/adminlte/include/navbar_left.tpl:102: {$menu->name3} */
 echo $var["menu"]->name3; ?></a> <?php
/* backend/adminlte/include/navbar_left.tpl:104: {var $close_menu3 = 1} */
 $var["close_menu3"]=1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:105: {var $menu_id3 = $menu->menu_id3} */
 $var["menu_id3"]=$var["menu"]->menu_id3; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:106: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:107: {/if} */
 } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:109: {var $idx = $idx + 1} */
 $var["idx"]=$var["idx"] + 1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:110: {var $menu_id1 = $menu->menu_id1} */
 $var["menu_id1"]=$var["menu"]->menu_id1; ?> <?php
/* backend/adminlte/include/navbar_left.tpl:111: {/foreach} */
   } } ?> <?php
/* backend/adminlte/include/navbar_left.tpl:112: {if ($close_menu1)} */
 if(($var["close_menu1"])) { ?> </li></ul> <?php
/* backend/adminlte/include/navbar_left.tpl:114: {/if} */
 } ?> <li class="header">OTHERS</li><li><a href="#" id="go-change-pwd"><i class="fa fa-circle-o text-aqua"></i><span>Change Password</span></a></li><li><a href="#" id="go-lock-screen"><i class="fa fa-circle-o text-yellow"></i><span>Lock Screen</span></a></li><li><a href="<?php
/* backend/adminlte/include/navbar_left.tpl:118: {$logout_link} */
 echo $var["logout_link"]; ?>" id="go-sign-out"><i class="fa fa-circle-o text-red"></i><span>Sign Out</span></a></li></ul></section><!-- /.sidebar --></aside> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/include/navbar_left.tpl',
	'base_name' => 'backend/adminlte/include/navbar_left.tpl',
	'time' => 1488248445,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/include/navbar_left.tpl' => 1488248445,
  ),
),
	'macros' => array(),

        ));
