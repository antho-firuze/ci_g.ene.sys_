<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-body">
			</div>
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}";
	{* Default init for for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		title:"{$title}", 
		title_desc:"{$title_desc}", 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"{$title}", link:"" },
		]
	}));

	var a=[];
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	var col_l = formContent.find('div.col-left');
	var col_r = formContent.find('div.col-right');
	col_l.append(BSHelper.Combobox({ label:"Price List", idname:"pricelist_version", url:"{$.php.base_url('sales/m_pricelist_version')}?filter=t1.is_active='1',is_sopricelist='1'&ob=validfrom desc", required: true, remote: true }));
	a.push( subCol(4, BSHelper.Combobox({ label:"Size", idname:"swg_size_id", url:"{$.php.base_url('sales/e_swg_size')}?ob=id", required: true, remote: true })) );
	a.push( subCol(4, BSHelper.Combobox({ label:"Class", idname:"swg_class_id", url:"{$.php.base_url('sales/e_swg_class')}", required: true, remote: true })) );
	a.push( subCol(4, BSHelper.Combobox({ label:"Series", idname:"swg_series_id", url:"{$.php.base_url('sales/e_swg_series')}", required: true, remote: true })) );
	col_l.append(subRow(a));
	a = [];
	a.push( subCol(3, BSHelper.Input({ type:"number", step:"any", label:"D1", idname:"d1", required: true, placeholder:"0", readonly: true })) );
	a.push( subCol(3, BSHelper.Input({ type:"number", step:"any", label:"D2", idname:"d2", required: true, placeholder:"0", readonly: true  })) );
	a.push( subCol(3, BSHelper.Input({ type:"number", step:"any", label:"D3", idname:"d3", required: true, placeholder:"0", readonly: true  })) );
	a.push( subCol(3, BSHelper.Input({ type:"number", step:"any", label:"D4", idname:"d4", required: true, placeholder:"0", readonly: true  })) );
	col_l.append(subRow(a));
	col_l.append(BSHelper.Input({ type:"number", label:"Quantity", idname:"qty", required: true, placeholder:"numeric", value:1 }));
	col_r.append(BSHelper.Combobox({ label:"Material IR", idname:"ir_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=t1.pricelist_id=0,t1.pricelist_version_id=0", required: false, remote: true }));
	col_r.append(BSHelper.Input({ type:"hidden", idname:"ir_price" }));
	col_r.append(BSHelper.Combobox({ label:"Material OR", idname:"or_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=t1.pricelist_id=0,t1.pricelist_version_id=0", required: false, remote: true }));
	col_r.append(BSHelper.Input({ type:"hidden", idname:"or_price" }));
	col_r.append(BSHelper.Combobox({ label:"Material HOOP", idname:"hoop_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=t1.pricelist_id=0,t1.pricelist_version_id=0", required: false, remote: true }));
	col_r.append(BSHelper.Input({ type:"hidden", idname:"hoop_price" }));
	col_r.append(BSHelper.Combobox({ label:"Material FILLER", idname:"filler_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=t1.pricelist_id=0,t1.pricelist_version_id=0", required: true, remote: true }));
	col_r.append(BSHelper.Input({ type:"hidden", idname:"filler_price" }));
	col_r.append(BSHelper.Combobox({ label:"Branch", idname:"branch_id", url:"{$.php.base_url('sales/a_user_org')}", required: true, remote: true }));
	col_r.append(BSHelper.Input({ type:"hidden", idname:"swg_margin" }));
	a = [];
	a.push( BSHelper.Button({ type:"submit", label:"Submit", cls:"btn-primary" }) );
	{* a.push( '&nbsp;' ); *}
	{* a.push( BSHelper.FormButton({ type:"button", label:"Testing", cls:"btn-primary", idname:"btn_testing" }) ); *}
	formContent.append( a );
	$('div.box-body').append(formContent);
	
	function filter_material(){
		$("#ir_item_id")
			.shollu_cb({ queryParams: { "filter":"t1.pricelist_id="+pricelist_id+",t1.pricelist_version_id="+pricelist_version_id+",is_swg_ir='1'" }})
			.shollu_cb('setValue', '');
		$("#or_item_id")
			.shollu_cb({ queryParams: { "filter":"t1.pricelist_id="+pricelist_id+",t1.pricelist_version_id="+pricelist_version_id+",is_swg_or='1'" }})
			.shollu_cb('setValue', '');
		$("#hoop_item_id")
			.shollu_cb({ queryParams: { "filter":"t1.pricelist_id="+pricelist_id+",t1.pricelist_version_id="+pricelist_version_id+",is_swg_hoop='1'" }})
			.shollu_cb('setValue', '');
		$("#filler_item_id")
			.shollu_cb({ queryParams: { "filter":"t1.pricelist_id="+pricelist_id+",t1.pricelist_version_id="+pricelist_version_id+",is_swg_filler='1'" }})
			.shollu_cb('setValue', '');
	}
	
	function populate_dimension(){
		var size_id, class_id, series_id = 0;
		size_id 	= (size_id = $("#swg_size_id").shollu_cb('getValue', 'id')) ? size_id : 0;
		class_id 	= (class_id = $("#swg_class_id").shollu_cb('getValue', 'id')) ? class_id : 0;
		series_id = (series_id = $("#swg_series_id").shollu_cb('getValue', 'id')) ? series_id : 0;
		var term = { "filter":"swg_size_id="+size_id+",swg_class_id="+class_id+", swg_series_id="+series_id };
		
		if (size_id==0){
			dimension_disabled(false);
			return false;
		}
		
		dimension_disabled(true);
		$.getJSON("{$.php.base_url('sales/e_pl_swg_dimension')}", term, function(data){ 
			if (Object.keys(data.data.rows).length > 0){
				var row = data.data.rows[0];
				populate_dimension_d(row.d1, row.d2, row.d3, row.d4);
			} else {
				populate_dimension_d(0, 0, 0, 0);
			}
		});
	}
	
	function populate_dimension_d(d1, d2, d3, d4){
		$('#d1').val(d1);
		$('#d2').val(d2);
		$('#d3').val(d3);
		$('#d4').val(d4);
	}
	
	function dimension_disabled(status){
		$('#d1').attr('readonly', status);
		$('#d2').attr('readonly', status);
		$('#d3').attr('readonly', status);
		$('#d4').attr('readonly', status);
	}
	
	{* INITILIZATION *}
	var pricelist_id, pricelist_version_id = 0;
	$("#pricelist_version").shollu_cb({ 
		textField: 'name_version',
		onSelect: function(rowData){
			pricelist_id = rowData.pricelist_id;
			pricelist_version_id = rowData.id;
			filter_material();
			{* $("#pricelist_version").shollu_cb('disabled', true); *}
		}
	});	
	$("#swg_size_id").shollu_cb({ 
		addition: { "id":0, "name":"Non Standard" },
		onSelect: function(rowData){ populate_dimension(); }
	});
	$("#swg_class_id").shollu_cb({ onSelect: function(rowData){ populate_dimension(); }	});
	$("#swg_series_id").shollu_cb({ onSelect: function(rowData){ populate_dimension(); } });
	$("#ir_item_id").shollu_cb({ textField: 'code_name',
		onSelect: function(rowData){
			$("#ir_price").val($("#ir_item_id").shollu_cb('getValue','price'));
		}
	});
	$("#or_item_id").shollu_cb({ textField: 'code_name',
		onSelect: function(rowData){
			$("#or_price").val($("#or_item_id").shollu_cb('getValue','price'));
		}
	});
	$("#hoop_item_id").shollu_cb({ textField: 'code_name',
		onSelect: function(rowData){
			$("#hoop_price").val($("#hoop_item_id").shollu_cb('getValue','price'));
		}
	});
	$("#filler_item_id").shollu_cb({ textField: 'code_name',
		onSelect: function(rowData){
			$("#filler_price").val($("#filler_item_id").shollu_cb('getValue','price'));
		}
	});
	$("#branch_id").shollu_cb({ textField: 'code_name',
		onSelect: function(rowData){
			$("#swg_margin").val($("#branch_id").shollu_cb('getValue', 'swg_margin'));
		}
	});
	
	$('#btn_testing').on('click', function(){
		$('#d1').val(999);
		{* console.log($("#swg_size_id").shollu_cb('getValue', 'id')); *}
	});
	
	{* Form submit action *}
	formContent.validator().on('submit', function (e) {
		{* e.stopPropagation; *}
		if (e.isDefaultPrevented()) { return false;	} 
		
		formContent.find("[type='submit']").prop( "disabled", true );
		
		$.ajax({ url: $url_module, method: "POST", async: true, dataType: 'json',
			data: formContent.serializeJSON(),
			success: function(data) {
				{* console.log(data.data); *}
				var curr = 'IDR';
				var qty = $('#qty').val();
				var sell_price = 1250;
				var sell_price_total = sell_price * qty;
				var $content = subRow(), a = [];
				a.push( "<center><h2>Selling Price ("+curr+"): </h2></center>" );
				a.push( "<center><h2><span>"+accounting.formatMoney(sell_price, '', 2, ".", ",")+"/PCS</span></h2></center>" );
				a.push( "<br>" );
				if (qty > 1){
					a.push( "<center><h2><span>"+accounting.formatMoney(sell_price_total, '', 2, ".", ",")+" @"+qty+" PCS</span></h2></center>" );
					a.push( "<br>" );
				}
				$content.append( subCol(12, a ) );
				BootstrapDialog.show({ type:BootstrapDialog.TYPE_PRIMARY, title:'Result !', message:$content });
				formContent.find("[type='submit']").prop( "disabled", false );
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				formContent.find("[type='submit']").prop( "disabled", false );
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});
		
		return false;
	});
	
	{* SET DEFAULT VALUE *}
	{* $("#pricelist_id").shollu_cb('setValue', 1); *}
			{* $.ajax({ url: '',method: "GET",dataType: 'json', *}
				{* data: '{"skin": "'+$(this).data('skin')+'"}' *}
			{* }); *}
</script>