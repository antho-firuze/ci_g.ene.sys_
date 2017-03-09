<?php 
/** Fenom template '/frontend/adminlte/include/main_footer.tpl' compiled at 2017-03-09 13:14:45 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <footer class="main-footer"><div class="pull-right hidden-xs"><b>Version</b> 2.3.2 - Server [<strong><?php
/* /frontend/adminlte/include/main_footer.tpl:3: {$elapsed_time} */
 echo $var["elapsed_time"]; ?></strong>] - Client [<strong><?php
/* /frontend/adminlte/include/main_footer.tpl:3: {microtime(true)-$start_time} */
 echo microtime(true) - $var["start_time"]; ?></strong>] </div><strong>Genesys @2016 - Copyright to it's <a href="http://almsaeedstudio.com">Owner</a>.</strong> All rights reserved. </footer> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/adminlte/include/main_footer.tpl',
	'base_name' => '/frontend/adminlte/include/main_footer.tpl',
	'time' => 1486615629,
	'depends' => array (
  0 => 
  array (
    '/frontend/adminlte/include/main_footer.tpl' => 1486615629,
  ),
),
	'macros' => array(),

        ));
