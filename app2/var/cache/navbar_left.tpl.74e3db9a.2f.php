<?php 
/** Fenom template 'frontend/adminlte/include/navbar_left.tpl' compiled at 2017-03-07 11:29:06 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <aside class="main-sidebar"><!-- sidebar: style can be found in sidebar.less --><section class="sidebar"><!-- Sidebar user panel -->  <!-- search form -->  <!-- /.search form --><!-- sidebar menu: : style can be found in sidebar.less --><ul class="sidebar-menu"><li class="header">MENU</li> <?php
/* frontend/adminlte/include/navbar_left.tpl:28: {var $idx = 1} */
 $var["idx"]=1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:29: {var $menu_id1 = 0} */
 $var["menu_id1"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:30: {var $menu_id2 = 0} */
 $var["menu_id2"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:31: {var $menu_id3 = 0} */
 $var["menu_id3"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:32: {var $close_menu1 = 0} */
 $var["close_menu1"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:33: {var $close_menu2 = 0} */
 $var["close_menu2"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:34: {var $close_menu3 = 0} */
 $var["close_menu3"]=0; ?> <?php  if(!empty($var["menus"]) && (is_array($var["menus"]) || $var["menus"] instanceof \Traversable)) {
  foreach($var["menus"] as $var["menu"]) { ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:36: {if ($menu_id1 != $menu->menu_id1 && !empty($menu->menu_id1))} */
 if(($var["menu_id1"] != $var["menu"]->menu_id1 && !empty($var["menu"]->menu_id1))) { ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:38: {if ($close_menu3)} */
 if(($var["close_menu3"])) { ?> </li></ul> <?php
/* frontend/adminlte/include/navbar_left.tpl:40: {var $close_menu3 = 0} */
 $var["close_menu3"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:41: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:42: {if ($close_menu2)} */
 if(($var["close_menu2"])) { ?> </li></ul> <?php
/* frontend/adminlte/include/navbar_left.tpl:44: {var $close_menu2 = 0} */
 $var["close_menu2"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:45: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:46: {if ($close_menu1)} */
 if(($var["close_menu1"])) { ?> </li> <?php
/* frontend/adminlte/include/navbar_left.tpl:48: {var $close_menu1 = 0} */
 $var["close_menu1"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:49: {/if} */
 } ?>  <li class="treeview <?php
/* frontend/adminlte/include/navbar_left.tpl:56: {if ($idx == 1)} */
 if(($var["idx"] == 1)) { ?>active<?php
/* frontend/adminlte/include/navbar_left.tpl:56: {/if} */
 } ?>"><a href="<?php
/* frontend/adminlte/include/navbar_left.tpl:57: {$.php.base_url('page/')~$menu->page_id1} */
 echo (call_user_func_array('base_url', array('page/')).strval($var["menu"]->page_id1)); ?>"><i class="fa <?php
/* frontend/adminlte/include/navbar_left.tpl:57: {$menu->icon1 !: 'fa-circle'} */
 echo (isset($var["menu"]->icon1) ? $var["menu"]->icon1 : ('fa-circle')); ?>"></i><span><?php
/* frontend/adminlte/include/navbar_left.tpl:58: {$menu->name1} */
 echo $var["menu"]->name1; ?></span> <?php
/* frontend/adminlte/include/navbar_left.tpl:58: {if !empty($menu->menu_id2)} */
 if(!empty($var["menu"]->menu_id2)) { ?> <i class="fa fa-angle-left pull-right"></i><?php
/* frontend/adminlte/include/navbar_left.tpl:58: {/if} */
 } ?> </a> <?php
/* frontend/adminlte/include/navbar_left.tpl:61: {if ($menu_id2 != $menu->menu_id2 && !empty($menu->menu_id2)) } */
 if(($var["menu_id2"] != $var["menu"]->menu_id2 && !empty($var["menu"]->menu_id2))) { ?> <ul class="treeview-menu"><li><a href="<?php
/* frontend/adminlte/include/navbar_left.tpl:64: {$.php.base_url('page/')~$menu->page_id2} */
 echo (call_user_func_array('base_url', array('page/')).strval($var["menu"]->page_id2)); ?>"><i class="fa <?php
/* frontend/adminlte/include/navbar_left.tpl:64: {$menu->icon2 !: 'fa-circle-o'} */
 echo (isset($var["menu"]->icon2) ? $var["menu"]->icon2 : ('fa-circle-o')); ?>"></i> <?php
/* frontend/adminlte/include/navbar_left.tpl:64: {$menu->name2} */
 echo $var["menu"]->name2; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:65: {if !empty($menu->menu_id3)} */
 if(!empty($var["menu"]->menu_id3)) { ?> <i class="fa fa-angle-left pull-right"></i><?php
/* frontend/adminlte/include/navbar_left.tpl:65: {/if} */
 } ?> </a> <?php
/* frontend/adminlte/include/navbar_left.tpl:68: {if ($menu_id3 != $menu->menu_id3 && !empty($menu->menu_id3)) } */
 if(($var["menu_id3"] != $var["menu"]->menu_id3 && !empty($var["menu"]->menu_id3))) { ?> <ul class="treeview-menu"><li><a href="<?php
/* frontend/adminlte/include/navbar_left.tpl:70: {$.php.base_url('page/')~$menu->page_id3} */
 echo (call_user_func_array('base_url', array('page/')).strval($var["menu"]->page_id3)); ?>"><i class="fa <?php
/* frontend/adminlte/include/navbar_left.tpl:70: {$menu->icon2 !: 'fa-circle-o'} */
 echo (isset($var["menu"]->icon2) ? $var["menu"]->icon2 : ('fa-circle-o')); ?>"></i> <?php
/* frontend/adminlte/include/navbar_left.tpl:70: {$menu->name3} */
 echo $var["menu"]->name3; ?></a> <?php
/* frontend/adminlte/include/navbar_left.tpl:72: {var $close_menu3 = 1} */
 $var["close_menu3"]=1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:73: {var $menu_id3 = $menu->menu_id3} */
 $var["menu_id3"]=$var["menu"]->menu_id3; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:74: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:77: {var $close_menu2 = 1} */
 $var["close_menu2"]=1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:78: {var $menu_id2 = $menu->menu_id2} */
 $var["menu_id2"]=$var["menu"]->menu_id2; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:79: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:81: {var $close_menu1 = 1} */
 $var["close_menu1"]=1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:83: {elseif ($menu_id1 == $menu->menu_id1)} */
 } elseif(($var["menu_id1"] == $var["menu"]->menu_id1)) { ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:85: {if ($close_menu3)} */
 if(($var["close_menu3"])) { ?> </li></ul> <?php
/* frontend/adminlte/include/navbar_left.tpl:87: {var $close_menu3 = 0} */
 $var["close_menu3"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:88: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:89: {if ($close_menu2)} */
 if(($var["close_menu2"])) { ?> </li> <?php
/* frontend/adminlte/include/navbar_left.tpl:91: {var $close_menu2 = 0} */
 $var["close_menu2"]=0; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:92: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:94: {if ($menu_id2 != $menu->menu_id2 && !empty($menu->menu_id2)) } */
 if(($var["menu_id2"] != $var["menu"]->menu_id2 && !empty($var["menu"]->menu_id2))) { ?> <li><a href="<?php
/* frontend/adminlte/include/navbar_left.tpl:95: {$.php.base_url('page/')~$menu->page_id2} */
 echo (call_user_func_array('base_url', array('page/')).strval($var["menu"]->page_id2)); ?>"><i class="fa fa-circle-o"></i> <?php
/* frontend/adminlte/include/navbar_left.tpl:95: {$menu->name2} */
 echo $var["menu"]->name2; ?></a> <?php
/* frontend/adminlte/include/navbar_left.tpl:97: {var $close_menu2 = 1} */
 $var["close_menu2"]=1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:98: {var $menu_id2 = $menu->menu_id2} */
 $var["menu_id2"]=$var["menu"]->menu_id2; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:100: {elseif ($menu_id2 == $menu->menu_id2)} */
 } elseif(($var["menu_id2"] == $var["menu"]->menu_id2)) { ?> <li><a href="<?php
/* frontend/adminlte/include/navbar_left.tpl:101: {$.php.base_url('page/')~$menu->page_id3} */
 echo (call_user_func_array('base_url', array('page/')).strval($var["menu"]->page_id3)); ?>"><i class="fa fa-circle-o"></i> <?php
/* frontend/adminlte/include/navbar_left.tpl:101: {$menu->name3} */
 echo $var["menu"]->name3; ?></a> <?php
/* frontend/adminlte/include/navbar_left.tpl:103: {var $close_menu3 = 1} */
 $var["close_menu3"]=1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:104: {var $menu_id3 = $menu->menu_id3} */
 $var["menu_id3"]=$var["menu"]->menu_id3; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:105: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:106: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:108: {var $idx = $idx + 1} */
 $var["idx"]=$var["idx"] + 1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:109: {var $menu_id1 = $menu->menu_id1} */
 $var["menu_id1"]=$var["menu"]->menu_id1; ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:110: {/foreach} */
   } } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:111: {if ($close_menu2)} */
 if(($var["close_menu2"])) { ?> </li></ul> <?php
/* frontend/adminlte/include/navbar_left.tpl:113: {/if} */
 } ?> <?php
/* frontend/adminlte/include/navbar_left.tpl:114: {if ($close_menu1)} */
 if(($var["close_menu1"])) { ?> </li> <?php
/* frontend/adminlte/include/navbar_left.tpl:116: {/if} */
 } ?> <li class="header">OTHERS</li>  <li><a href="<?php
/* frontend/adminlte/include/navbar_left.tpl:119: {$login_link} */
 echo $var["login_link"]; ?>" id="go-sign-out"><i class="fa fa-circle-o text-red"></i><span>Login</span></a></li>  </ul></section><!-- /.sidebar --></aside> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'frontend/adminlte/include/navbar_left.tpl',
	'base_name' => 'frontend/adminlte/include/navbar_left.tpl',
	'time' => 1487817872,
	'depends' => array (
  0 => 
  array (
    'frontend/adminlte/include/navbar_left.tpl' => 1487817872,
  ),
),
	'macros' => array(),

        ));
