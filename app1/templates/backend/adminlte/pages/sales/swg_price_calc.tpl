   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {$window_title}
        <small>{$description}</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        {* <div class="box-header with-border">
          <h3 class="box-title">Title</h3>
        </div> *}
				<div class="box-body">
					<!-- /.box-body -->
					{* <div class="box-footer"></div> *}
					<!-- /.box-footer-->
				</div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
	var formContent = $('<form "autocomplete"="off"><div class="row"><div class="col-left col-md-6"></div><div class="col-right col-md-6"></div></div></form>');
	var col_l = formContent.find('div.col-left');
	var col_r = formContent.find('div.col-right');
	col_l.append(BSHelper.FormCombobox({ label:"Price List", idname:"pricelist_id", url:"{$.php.base_url('sales/m_pricelist')}?filter=is_sopricelist=1", required: true, isCombogrid: true, placeholder:"typed or choose" }));
	var a=[];
	a.push ( subCol(4, BSHelper.FormCombobox({ label:"Size", idname:"swg_size_id", url:"{$.php.base_url('sales/e_swg_size')}?ob=id", required: true, isCombogrid: true, placeholder:"typed or choose" })) );
	a.push ( subCol(4, BSHelper.FormCombobox({ label:"Class", idname:"swg_class_id", url:"{$.php.base_url('sales/e_swg_class')}", required: true, isCombogrid: true, placeholder:"typed or choose" })) );
	a.push ( subCol(4, BSHelper.FormCombobox({ label:"Series", idname:"swg_series_id", url:"{$.php.base_url('sales/e_swg_series')}", required: true, isCombogrid: true, placeholder:"typed or choose" })) );
	col_l.append(subRow(a));
	a = [];
	a.push ( subCol(3, BSHelper.FormInput({ type:"text", label:"D1", idname:"d1", required: true, placeholder:"0", disabled: true })) );
	a.push ( subCol(3, BSHelper.FormInput({ type:"text", label:"D2", idname:"d2", required: true, placeholder:"0", disabled: true  })) );
	a.push ( subCol(3, BSHelper.FormInput({ type:"text", label:"D3", idname:"d3", required: true, placeholder:"0", disabled: true  })) );
	a.push ( subCol(3, BSHelper.FormInput({ type:"text", label:"D4", idname:"d4", required: true, placeholder:"0", disabled: true  })) );
	col_l.append(subRow(a));
	col_l.append(BSHelper.FormInput({ type:"text", label:"Quantity", idname:"qty", required: true, placeholder:"numeric", value:1 }));
	col_r.append(BSHelper.FormCombobox({ label:"Material IR", idname:"ir_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=pricelist_id=0,pricelist_version_id=0", required: true, isCombogrid: true, placeholder:"typed or choose" }));
	col_r.append(BSHelper.FormCombobox({ label:"Material OR", idname:"or_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=pricelist_id=0,pricelist_version_id=0", required: true, isCombogrid: true, placeholder:"typed or choose" }));
	col_r.append(BSHelper.FormCombobox({ label:"Material HOOP", idname:"hoop_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=pricelist_id=0,pricelist_version_id=0", required: true, isCombogrid: true, placeholder:"typed or choose" }));
	col_r.append(BSHelper.FormCombobox({ label:"Material FILLER", idname:"filler_item_id", url:"{$.php.base_url('sales/m_pricelist_item')}?&filter=pricelist_id=0,pricelist_version_id=0", required: true, isCombogrid: true, placeholder:"typed or choose" }));
	col_r.append(BSHelper.FormCombobox({ label:"Branch", idname:"branch_id", url:"{$.php.base_url('systems/a_org')}", required: true, isCombogrid: true, placeholder:"typed or choose" }));
	$('div.box-body').append(formContent);
	
	function filter_material(){
		$("#ir_item_id")
			.combogrid('queryParams', { "filter":"pricelist_id="+pricelist_id+",pricelist_version_id="+pricelist_version_id+",is_swg_ir=1" })
			.combogrid('setValue', '');
		$("#or_item_id")
			.combogrid('queryParams', { "filter":"pricelist_id="+pricelist_id+",pricelist_version_id="+pricelist_version_id+",is_swg_or=1" })
			.combogrid('setValue', '');
		$("#hoop_item_id")
			.combogrid('queryParams', { "filter":"pricelist_id="+pricelist_id+",pricelist_version_id="+pricelist_version_id+",is_swg_hoop=1" })
			.combogrid('setValue', '');
		$("#filler_item_id")
			.combogrid('queryParams', { "filter":"pricelist_id="+pricelist_id+",pricelist_version_id="+pricelist_version_id+",is_swg_filler=1" })
			.combogrid('setValue', '');
	}
	
	function populate_dimension(){
		var size_id, class_id, series_id = 0;
		size_id 	= (size_id = $("#swg_size_id").combogrid('getValue')) ? size_id : 0;
		class_id 	= (class_id = $("#swg_class_id").combogrid('getValue')) ? class_id : 0;
		series_id = (series_id = $("#swg_series_id").combogrid('getValue')) ? series_id : 0;
		var term = { "filter":"swg_size_id="+size_id+",swg_class_id="+class_id+", swg_series_id="+series_id };
		$.getJSON("{$.php.base_url('sales/e_pl_swg_dimension')}", term, function(data){ 
			if (data.data) {
				console.log(data.data);
			} 
		});
	}
	
	{* INITILIZATION *}
	var pricelist_id, pricelist_version_id = 0;
	$("#pricelist_id").combogrid({ 
		textField: 'name_version',
		source: function(term, response){
			$.getJSON($("#pricelist_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			pricelist_id = rowData.id;
			pricelist_version_id = rowData.version_id;
			filter_material();
		}
	});	
	$("#swg_size_id").combogrid({ 
		addition: { "id":0, "name":"Non Standard" },
		source: function(term, response){
			$.getJSON($("#swg_size_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			{* console.log(rowData); *}
			populate_dimension();
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#swg_class_id").combogrid({ 
		source: function(term, response){
			$.getJSON($("#swg_class_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			populate_dimension();
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#swg_series_id").combogrid({ 
		source: function(term, response){
			$.getJSON($("#swg_series_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			populate_dimension();
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#ir_item_id").combogrid({ 
		textField: 'code_name',
		source: function(term, response){
			$.getJSON($("#ir_item_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#or_item_id").combogrid({ 
		textField: 'code_name',
		source: function(term, response){
			$.getJSON($("#or_item_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#hoop_item_id").combogrid({ 
		textField: 'code_name',
		source: function(term, response){
			$.getJSON($("#hoop_item_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#filler_item_id").combogrid({ 
		textField: 'code_name',
		source: function(term, response){
			$.getJSON($("#filler_item_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	$("#branch_id").combogrid({ 
		source: function(term, response){
			$.getJSON($("#branch_id").data('url'), term, function(data){ response(data.data); });
		},
		onSelect: function(rowData){
			{* $("#ir_item_id")
				.combogrid('queryParams', { "pricelist_id":rowData.id, "pricelist_version_id":rowData.version_id })
				.combogrid('setValue', ''); *}
		}
	});
	
	{* SET DEFAULT VALUE *}
	{* $("#pricelist_id").combogrid('setValue', 1); *}
			{* $.ajax({ url: '',method: "GET",dataType: 'json', *}
				{* data: '{"skin": "'+$(this).data('skin')+'"}' *}
			{* }); *}
</script>