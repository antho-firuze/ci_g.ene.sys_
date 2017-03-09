<?php 
/** Fenom template '/frontend/adminlte/pages/product_info.tpl' compiled at 2017-03-09 13:15:07 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?><style> .profile-product-img {  margin: 0 auto; width: 200px; padding: 3px; border: 3px solid #d2d6de; } </style><div class="content-wrapper"><!-- Content Header (Page header) --><section class="content-header"><h1> Product Info <small></small></h1>  </section><!-- Main content --><section class="content"><!-- Small boxes (Stat box) --><div class="row"><section class="col-lg-4 connectedSortable"><div class="box box-success"><div class="box-header with-border"><h3 class="box-title">Picture</h3></div><div class="box-body"><img class="profile-product-img img-responsive" src="<?php
/* /frontend/adminlte/pages/product_info.tpl:32: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>upload/images/<?php
/* /frontend/adminlte/pages/product_info.tpl:32: {$img} */
 echo $var["img"]; ?>" alt="Product picture"></div><!-- /.box-body --></div></section><section class="col-lg-8 connectedSortable"><div class="box box-success"><div class="box-header with-border"><h3 class="box-title">Manufacture</h3></div><div class="box-body"><h1><a href="http://www.trigraha.com" target="#">PT. Jeil Fajar Indonesia</a><span class="label label-default">Original</span></h1></div><!-- /.box-body --></div></section></div><!-- /.row --><!-- Main row --><div class="row"><!-- Left col --><section class="col-lg-6 connectedSortable"><div class="box box-success"><div class="box-header with-border"><h3 class="box-title">General Informations</h3></div><div class="box-body"><dl class="dl-horizontal"><dt>Part No</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:61: {$no_part} */
 echo $var["no_part"]; ?></dd><dt>Slip No</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:63: {$no_slip} */
 echo $var["no_slip"]; ?></dd><dt>Manufacturing Date</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:65: {$date_printed} */
 echo $var["date_printed"]; ?></dd><!-- <dt>No. PO Customer</dt> --><!-- <dd>-</dd> --><!-- <dt>No. Sales Order</dt> --><!-- <dd><?php
/* /frontend/adminlte/pages/product_info.tpl:69: {$no_so} */
 echo $var["no_so"]; ?></dd> --></dl></div><!-- /.box-body --></div></section><!-- /.Left col --><!-- right col (We are only adding the ID to make the widgets sortable)--><section class="col-lg-6 connectedSortable"><div class="box box-success"><div class="box-header with-border"><h3 class="box-title">Materials & Certification</h3></div><div class="box-body"><dl class="dl-horizontal"><dt>Standard</dt><dd id="standard">-</dd><dt>Size</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:87: {$size} */
 echo $var["size"]; ?></dd><dt>Inner Ring</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:89: {$inner_ring} */
 echo $var["inner_ring"]; ?> / -</dd><dt>Outer Ring</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:91: {$outer_ring} */
 echo $var["outer_ring"]; ?> / -</dd><dt>Hoop</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:93: {$hoop} */
 echo $var["hoop"]; ?> / -</dd><dt>Filler</dt><dd><?php
/* /frontend/adminlte/pages/product_info.tpl:95: {$filler} */
 echo $var["filler"]; ?> / -</dd></dl></div><!-- /.box-body --></div></section><!-- right col --></div><!-- /.row (main row) --></section><!-- /.content --></div><script> $(".connectedSortable").sortable({  placeholder: "sort-highlight", connectWith: ".connectedSortable", handle: ".box-header, .nav-tabs", forcePlaceholderSize: true, zIndex: 999999 }); $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move"); var conhead = $('.content-header'); var info_list = $('<ul id="info_marquee" class="info-marquee marquee" />'); $.ajax({ url: InfoLst_url, method: "GET", async: true, dataType: 'json', data: { "org_id": 0, "validf": format_ymd() }, success: function(data) {  $.each(data.data.rows, function(k, v){  console.log(v.description); $('<li />').html(v.description).appendTo(info_list); }); conhead.prepend(info_list); $('#info_marquee').marquee({ yScroll: "bottom" }); }, error: function(data) {  console.log(data.responseText); if (data.status==500){  var message = data.statusText; } else {  var error = JSON.parse(data.responseText); var message = error.message; } $('<li />').html(message).appendTo(info_list); conhead.prepend(info_list); $('#info_marquee').marquee(); } }); var part = '<?php
/* /frontend/adminlte/pages/product_info.tpl:147: {$no_part} */
 echo $var["no_part"]; ?>'; var stand = '-'; switch(part.substring(0,1)) {  case 'A': stand = 'ANSI'; <?php
/* /frontend/adminlte/pages/product_info.tpl:152: {var $stand = 'ANSI'} */
 $var["stand"]='ANSI'; ?> break; case 'D': stand = 'DIN'; <?php
/* /frontend/adminlte/pages/product_info.tpl:156: {var $stand = 'DIN'} */
 $var["stand"]='DIN'; ?> break; case 'J': stand = 'JIS'; <?php
/* /frontend/adminlte/pages/product_info.tpl:160: {var $stand = 'JIS'} */
 $var["stand"]='JIS'; ?> break; case 'C': stand = 'CUSTOM'; <?php
/* /frontend/adminlte/pages/product_info.tpl:164: {var $stand = 'CUSTOM'} */
 $var["stand"]='CUSTOM'; ?> break; } $('#standard').html(stand); </script> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => '/frontend/adminlte/pages/product_info.tpl',
	'base_name' => '/frontend/adminlte/pages/product_info.tpl',
	'time' => 1487299876,
	'depends' => array (
  0 => 
  array (
    '/frontend/adminlte/pages/product_info.tpl' => 1487299876,
  ),
),
	'macros' => array(),

        ));
