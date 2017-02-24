<style>
.profile-product-img {
  margin: 0 auto;
  width: 100%;
  padding: 3px;
  border: 3px solid #d2d6de;
}
.img-center {
	display: block;
  max-width: 100%; 
  height: auto; 
	margin-left: auto;
	margin-right: auto;
	margin: 0 auto;
}
</style>
  <div class="content-wrapper">
		<div class="arrow-down img-center"></div>
	
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {* <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> *}
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-success">
            <!-- <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
            </div> -->
            <div class="box-body">
              This product does not exist !
							{foreach $certificates as $c}
								<div> {$c->file_name} </div>
							{/foreach}
            </div>
            <!-- /.box-body -->
          </div>
        </section>
      </div>
      <!-- /.row -->
   </section>
    <!-- /.content -->
  </div>
  
  
<script>
	$(".connectedSortable").sortable({
		placeholder: "sort-highlight",
		connectWith: ".connectedSortable",
		handle: ".box-header, .nav-tabs",
		forcePlaceholderSize: true,
		zIndex: 999999
	});
	
	$(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

	{* var conhead = $('.content-header');
	var info_list = $('<ul id="info_marquee" class="info-marquee marquee" />');
	$.ajax({ url: setInfo_url, method: "GET", async: true, dataType: 'json',
		data: { "org_id": 0, "validf": format_ymd() },
		success: function(data) {
			$.each(data.data.rows, function(k, v){
				console.log(v.description);
				$('<li />').html(v.description).appendTo(info_list);
			});
			conhead.prepend(info_list);
			$('#info_marquee').marquee({ yScroll: "bottom" });
		},
		error: function(data) {
			console.log(data.responseText);
			if (data.status==500){
				var message = data.statusText;
			} else {
				var error = JSON.parse(data.responseText);
				var message = error.message;
			}
			$('<li />').html(message).appendTo(info_list);
			conhead.prepend(info_list);
			$('#info_marquee').marquee();
		}
	}); *}
	
	var part = '{$no_part}';
	var stand = '-';
	switch(part.substring(0,1)) {
    case 'A':
			stand = 'ANSI';
			{var $stand = 'ANSI'}
			break;
    case 'D':
			stand = 'DIN';
			{var $stand = 'DIN'}
			break;
    case 'J':
			stand = 'JIS';
			{var $stand = 'JIS'}
			break;
    case 'C':
			stand = 'CUSTOM';
			{var $stand = 'CUSTOM'}
			break;
	}
	
	$('#standard').html(stand);
</script>
