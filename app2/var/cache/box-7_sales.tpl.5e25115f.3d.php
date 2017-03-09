<?php 
/** Fenom template 'backend/adminlte/pages/dashboard/widget/box-7_sales.tpl' compiled at 2017-03-08 16:40:22 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <!-- Custom tabs (Charts with tabs)--><div class="nav-tabs-custom"><!-- Tabs within a box --><ul class="nav nav-tabs pull-right"><li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li><li><a href="#sales-chart" data-toggle="tab">Donut</a></li><li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li></ul><div class="tab-content no-padding"><!-- Morris chart - Sales --><div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div><div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div></div></div><!-- /.nav-tabs-custom --> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/pages/dashboard/widget/box-7_sales.tpl',
	'base_name' => 'backend/adminlte/pages/dashboard/widget/box-7_sales.tpl',
	'time' => 1486615612,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/pages/dashboard/widget/box-7_sales.tpl' => 1486615612,
  ),
),
	'macros' => array(),

        ));
