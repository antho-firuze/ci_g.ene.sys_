{var $template_url = $.php.base_url() ~ "templates/backend_theme/adminlte/"}
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{$template_url}bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="{$template_url}plugins/bootstrap-combogrid/bootstrap-combogrid.css">

	<script src="{$template_url}plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="{$template_url}plugins/bootstrap-combogrid/bootstrap-combogrid.js"></script>
	<script src="{$.php.base_url()}assets/genesys/js/bootstrap.helper.js"></script>
</head>
<body>
<script>
var form = $('<form />', { class: 'form-horizontal', autocomplete: 'off', width:"50%" });
{* 
var fg = $('<div />', { class:"form-group" });
var lbl = $('<label />', { class:"control-label col-sm-3", for:'idname' }).html('Label');
var col = $('<div />', { class:"col-sm-9"});
var input = $('<input />', { class: 'form-control',type: 'text',id: 'idname',name: 'idname',placeholder: 'Fill this box'});
col.append(input);
form.append( fg.append(lbl).append(col) );
 *}
form.append(BSHelper.Combobox({ label:"Country", idname:"country_id", url:"{$.php.base_url('systems/countrylist')}", disabled: false }));
form.append(BSHelper.Combobox({ label:"Province", idname:"province_id", url:"{$.php.base_url('systems/provincelist?id=-1')}" }));
form.append(BSHelper.Combobox({ label:"City", idname:"city_id", url:"{$.php.base_url('systems/citylist')}", value: -1 }));
form.append(BSHelper.Combobox({ label:"District", idname:"district_id", url:"{$.php.base_url('systems/districtlist')}", value: -1 }));
form.append(BSHelper.Combobox({ label:"Village", idname:"village_id", url:"{$.php.base_url('systems/villagelist')}", value: -1 }));

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
{*  *}
form.find("#country_id").combogrid({ 
	source: function(term, response){
		$.getJSON("{$.php.base_url('systems/countrylist')}", term, function(data){ response(data.data); });
	},
	onSelect: function(rowData){
		form.find("#province_id")
			.combogrid('queryParams', { "country_id":rowData.id })
			.combogrid('setValue', '');
	}
});

form.find("#province_id").combogrid({ 
	source: function(term, response){
		$.getJSON("{$.php.base_url('systems/provincelist')}", term, function(data){	response(data.data); });
	},
	onSelect: function(rowData){
		form.find("#city_id")
			.combogrid('queryParams', { "province_id":rowData.id })
			.combogrid('setValue', '');
	}
});

form.find("#city_id").combogrid({ 
	source: function(term, response){
		$.getJSON("{$.php.base_url('systems/citylist')}", term, function(data){ response(data.data); });
	},
	onSelect: function(rowData){
		form.find("#district_id")
			.combogrid('queryParams', { "city_id":rowData.id })
			.combogrid('setValue', '');
	}
});


form.find("#district_id").combogrid({ 
	source: function(term, response){
		$.getJSON("{$.php.base_url('systems/districtlist')}", term, function(data){ response(data.data); });
	},
	onSelect: function(rowData){
		form.find("#village_id")
			.combogrid('queryParams', { "district_id":rowData.id })
			.combogrid('setValue', '');
	}
});

form.find("#village_id").combogrid({ 
	source: function(term, response){
		$.getJSON("{$.php.base_url('systems/villagelist')}", term, function(data){ response(data.data); });
	},
	onSelect: function(rowData){
		{* console.log('Country: '+form.find("#country_id").combogrid('getValue').name);
		console.log('Province: '+form.find("#province_id").combogrid('getValue').name);
		console.log('City: '+form.find("#city_id").combogrid('getValue').name);
		console.log('District: '+form.find("#district_id").combogrid('getValue').name); *}
		console.log('Village: '+rowData.name);
	}
});

form.find('.btnx').click(function(){
	var i = $('.btnx').index(this),
	n = $('.btnx:eq('+i+')').attr('id');
	console.log(n);
	switch(n){
		case 'btn-disable':
			form.find("#village_id").combogrid('disable', true);
			break;
		case 'btn-enable':
			form.find("#village_id").combogrid('disable', false);
			break;
		case 'btn-init':
			form.find("#village_id").combogrid('init');
			break;
		case 'btn-destroy':
			form.find("#village_id").combogrid('destroy');
			break;
		case 'btn-setParams':
			form.find("#village_id").combogrid('queryParams', { "district_id":3276030 });
			break;
		case 'btn-setValue':
			form.find("#village_id").combogrid('setValue', '1101010012');
			break;
		case 'btn-setValue2':
			form.find("#village_id").combogrid('setValue', -1);
			break;
		case 'btn-getValue':
			console.log(form.find("#village_id").combogrid('getValue').name);
			break;
		case 'btn-version':
			console.log(form.find("#village_id").combogrid('version'));
			break;
	}
});

</script>
</body>
</html>