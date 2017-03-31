{var $template_url = $.php.base_url() ~ "templates/backend/adminlte/"}
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{$template_url}bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="{$template_url}plugins/shollu-combogrid/css/shollu_cg-white.css">

	<script src="{$template_url}plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="{$template_url}plugins/shollu-combogrid/js/shollu_cg.js"></script>
	<script src="{$.php.base_url()}assets/js/bootstrap.helper.js"></script>
</head>
<body>
<script>
var form = $('<form />', { autocomplete: 'off', width:"50%" });
form.append(BSHelper.Combogrid({ label:"Country", idname:"country_id", url:"{$.php.base_url('systems/c_1country')}", remote:true }));
form.append(BSHelper.Combogrid({ label:"Province", idname:"province_id", url:"{$.php.base_url('systems/c_2province')}", remote:true }));
form.append(BSHelper.Combogrid({ label:"City", idname:"city_id", url:"{$.php.base_url('systems/c_3city')}", value: -1, remote:true }));
form.append(BSHelper.Combogrid({ label:"District", idname:"district_id", url:"{$.php.base_url('systems/c_4district')}", value: -1, remote:true }));
form.append(BSHelper.Combogrid({ label:"Village", idname:"village_id", url:"{$.php.base_url('systems/c_5village')}", value: -1, remote:true }));
form.append(BSHelper.Input({ type:"text", label:"Villagex", idname:"village_idx", value: -1 }));
form.append('<div class="col-sm-3"></div><input type="button" id="btn-disable" class="btnx col-sm-9" value="Disable">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-enable" class="btnx col-sm-9" value="Enable">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-init" class="btnx col-sm-9" value="Init">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-destroy" class="btnx col-sm-9" value="Destroy">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-setParams" class="btnx col-sm-9" value="setParams Village (district_id = 3276030)">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-getValue" class="btnx col-sm-9" value="getValue Village">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-setValue" class="btnx col-sm-9" value="setValue Village (1101010012:Labuhan Bakti)">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-setValue2" class="btnx col-sm-9" value="setValue Village (null/-1)">');
form.append('<div class="col-sm-3"></div><input type="button" id="btn-version" class="btnx col-sm-9" value="Version">');
$('body').append( form );

$("#country_id").shollu_cg({ 
	onSelect: function(rowData){
		console.log(rowData);
		$("#province_id")
			.shollu_cg({ queryParams: { "country_id":rowData.id } })
			.shollu_cg('setValue', '');
	}
});

$("#province_id").shollu_cg({ 
	onSelect: function(rowData){
		console.log(rowData);
		$("#city_id")
			.shollu_cg({ queryParams: { "province_id":rowData.id } })
			.shollu_cg('setValue', '');
	}
});

$("#city_id").shollu_cg({ 
	onSelect: function(rowData){
		console.log(rowData);
		$("#district_id")
			.shollu_cg({ queryParams: { "city_id":rowData.id } })
			.shollu_cg('setValue', '');
	}
});


$("#district_id").shollu_cg({ 
	onSelect: function(rowData){
		console.log(rowData);
		$("#village_id")
			.shollu_cg({ queryParams: { "district_id":rowData.id } })
			.shollu_cg('setValue', '');
	}
});

$("#village_id").shollu_cg({ 
	onSelect: function(rowData){
		console.log(rowData);
		{* console.log('Country: '+form.find("#country_id").shollu_cg('getValue').name);
		console.log('Province: '+form.find("#province_id").shollu_cg('getValue').name);
		console.log('City: '+form.find("#city_id").shollu_cg('getValue').name);
		console.log('District: '+form.find("#district_id").shollu_cg('getValue').name); *}
		{* console.log('Village: '+rowData.name); *}
	}
});

form.find('.btnx').click(function(){
	var i = $('.btnx').index(this),
	n = $('.btnx:eq('+i+')').attr('id');
	{* console.log(n); *}
	switch(n){
		case 'btn-disable':
			form.find("#village_id").shollu_cg('disable', true);
			break;
		case 'btn-enable':
			form.find("#village_id").shollu_cg('disable', false);
			break;
		case 'btn-init':
			form.find("#village_id").shollu_cg('init');
			break;
		case 'btn-destroy':
			form.find("#village_id").shollu_cg('destroy');
			break;
		case 'btn-setParams':
			form.find("#village_id").shollu_cg('queryParams', { "district_id":3276030 });
			break;
		case 'btn-setValue':
			form.find("#village_id").shollu_cg('setValue', '1101010012');
			break;
		case 'btn-setValue2':
			form.find("#village_id").shollu_cg('setValue', -1);
			break;
		case 'btn-getValue':
			console.log(form.find("#country_id").shollu_cg('getValue'));
			break;
		case 'btn-version':
			console.log(form.find("#village_id").shollu_cg('version'));
			break;
	}
});

</script>
</body>
</html>