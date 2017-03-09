<?php 
/** Fenom template 'backend/adminlte/pages/dashboard/dashboard1.tpl' compiled at 2017-03-08 16:40:21 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <div class="content-wrapper"><!-- Content Header (Page header) --><section class="content-header"><h1> Dashboard <small>Control panel</small></h1><ol class="breadcrumb"><li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li><li class="active">Dashboard</li></ol></section><!-- Main content --><section class="content"><!-- Small boxes (Stat box) --><div class="row"> <?php  if(!empty($var["content_box_3"]) && (is_array($var["content_box_3"]) || $var["content_box_3"] instanceof \Traversable)) {
  foreach($var["content_box_3"] as $var["board"]) { ?> <?php
/* backend/adminlte/pages/dashboard/dashboard1.tpl:19: {include $theme_path ~ "pages/{$board}"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("pages/".($var["board"])."")))->display($var); ?> <?php
/* backend/adminlte/pages/dashboard/dashboard1.tpl:20: {/foreach} */
   } } ?> </div><!-- /.row --><!-- Main row --><div class="row"><!-- Left col --><section class="col-lg-7 connectedSortable"> <?php  if(!empty($var["content_box_7"]) && (is_array($var["content_box_7"]) || $var["content_box_7"] instanceof \Traversable)) {
  foreach($var["content_box_7"] as $var["board"]) { ?> <?php
/* backend/adminlte/pages/dashboard/dashboard1.tpl:28: {include $theme_path ~ "pages/{$board}"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("pages/".($var["board"])."")))->display($var); ?> <?php
/* backend/adminlte/pages/dashboard/dashboard1.tpl:29: {/foreach} */
   } } ?> </section><!-- /.Left col --><!-- right col (We are only adding the ID to make the widgets sortable)--><section class="col-lg-5 connectedSortable"> <?php  if(!empty($var["content_box_5"]) && (is_array($var["content_box_5"]) || $var["content_box_5"] instanceof \Traversable)) {
  foreach($var["content_box_5"] as $var["board"]) { ?> <?php
/* backend/adminlte/pages/dashboard/dashboard1.tpl:35: {include $theme_path ~ "pages/{$board}"} */
 $tpl->getStorage()->getTemplate(($var["theme_path"].strval("pages/".($var["board"])."")))->display($var); ?> <?php
/* backend/adminlte/pages/dashboard/dashboard1.tpl:36: {/foreach} */
   } } ?> </section><!-- right col --></div><!-- /.row (main row) --></section><!-- /.content --></div><script> $(".connectedSortable").sortable({  placeholder: "sort-highlight", connectWith: ".connectedSortable", handle: ".box-header, .nav-tabs", forcePlaceholderSize: true, zIndex: 999999 }); $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move"); var conhead = $('.content-header'); var info_list = $('<ul id="info_marquee" class="info-marquee marquee" />'); $.ajax({ url: InfoLst_url, method: "GET", async: true, dataType: 'json', success: function(data) {  $.each(data.data.rows, function(k, v){   if (v.description) {  $('<li />').html(v.description).appendTo(info_list); conhead.prepend(info_list); $('#info_marquee').marquee({ yScroll: "bottom" }); } }); }, error: function(data) {  if (data.status==500){  var message = data.statusText; } else {  var error = JSON.parse(data.responseText); var message = error.message; } console.log('[Error: info_list]: '+message); } }); </script> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/pages/dashboard/dashboard1.tpl',
	'base_name' => 'backend/adminlte/pages/dashboard/dashboard1.tpl',
	'time' => 1487301792,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/pages/dashboard/dashboard1.tpl' => 1487301792,
  ),
),
	'macros' => array(),

        ));
