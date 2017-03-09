<?php 
/** Fenom template 'backend/adminlte/pages/dashboard/widget/box-7_sales.js' compiled at 2017-03-08 16:40:22 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <script> var area = new Morris.Area({  element: 'revenue-chart', resize: true, data: [ {y: '2011 Q1', item1: 2666, item2: 2666}, {y: '2011 Q2', item1: 2778, item2: 2294}, {y: '2011 Q3', item1: 4912, item2: 1969}, {y: '2011 Q4', item1: 3767, item2: 3597}, {y: '2012 Q1', item1: 6810, item2: 1914}, {y: '2012 Q2', item1: 5670, item2: 4293}, {y: '2012 Q3', item1: 4820, item2: 3795}, {y: '2012 Q4', item1: 15073, item2: 5967}, {y: '2013 Q1', item1: 10687, item2: 4460}, {y: '2013 Q2', item1: 8432, item2: 5713} ], xkey: 'y', ykeys: ['item1', 'item2'], labels: ['Item 1', 'Item 2'], lineColors: ['#a0d0e0', '#3c8dbc'], hideHover: 'auto' }); var donut = new Morris.Donut({  element: 'sales-chart', resize: true, colors: ["#3c8dbc", "#f56954", "#00a65a"], data: [ {label: "Download Sales", value: 12}, {label: "In-Store Sales", value: 30}, {label: "Mail-Order Sales", value: 20} ], hideHover: 'auto' }); $('.box ul.nav a').on('shown.bs.tab', function () {  area.redraw(); donut.redraw(); }); </script>  <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/pages/dashboard/widget/box-7_sales.js',
	'base_name' => 'backend/adminlte/pages/dashboard/widget/box-7_sales.js',
	'time' => 1486615612,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/pages/dashboard/widget/box-7_sales.js' => 1486615612,
  ),
),
	'macros' => array(),

        ));
