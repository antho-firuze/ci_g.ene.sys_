<?php 
/** Fenom template '/frontend/simplelte/include/main_footer.tpl' compiled at 2017-03-09 13:51:09 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <footer class="main-footer"><div class="pull-right hidden-xs"><b>Version</b> 2.3.2 - Server [<strong><?php
/* /frontend/simplelte/include/main_footer.tpl:3: {$elapsed_time} */
 echo $var["elapsed_time"]; ?></strong>] - Client [<strong><?php
/* /frontend/simplelte/include/main_footer.tpl:3: {microtime(true)-$start_time} */
 echo microtime(true) - $var["start_time"]; ?></strong>] </div><div class="pull-left custom-text"> Jl. Mayor Oking Jayaatmaja No. 88, Cibinong, <br>Kabupaten Bogor, Jawa Barat - Indonesia <br>Phone : (62-21) 8753870 <br>Fax : (62-21) 8753871, 8755933 </div><br><br><br><br></footer> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/simplelte/include/main_footer.tpl',
	'base_name' => '/frontend/simplelte/include/main_footer.tpl',
	'time' => 1487057972,
	'depends' => array (
  0 => 
  array (
    '/frontend/simplelte/include/main_footer.tpl' => 1487057972,
  ),
),
	'macros' => array(),

        ));
