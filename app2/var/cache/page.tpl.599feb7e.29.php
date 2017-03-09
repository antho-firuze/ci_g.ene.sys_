<?php 
/** Fenom template '/frontend/adminlte/include/page.tpl' compiled at 2017-03-09 13:14:45 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <div class="content-wrapper"><!-- Content Header (Page header) --><section class="content-header"><h1> <?php
/* /frontend/adminlte/include/page.tpl:5: {$title} */
 echo $var["title"]; ?> <small><?php
/* /frontend/adminlte/include/page.tpl:6: {$short_desc} */
 echo $var["short_desc"]; ?></small></h1>  </section><!-- Main content --><section class="content"> <?php
/* /frontend/adminlte/include/page.tpl:16: {$description} */
 echo $var["description"]; ?>  <!-- /.row -->  </section><!-- /.content --></div><script>   </script> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/adminlte/include/page.tpl',
	'base_name' => '/frontend/adminlte/include/page.tpl',
	'time' => 1487326530,
	'depends' => array (
  0 => 
  array (
    '/frontend/adminlte/include/page.tpl' => 1487326530,
  ),
),
	'macros' => array(),

        ));
