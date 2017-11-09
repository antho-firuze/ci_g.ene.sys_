(function($) {

  "use strict";

  $.fn.shollu_autofill = function(options) {
		var i, field_type, field_name, field_id;
		
		if (typeof options == 'string') {
			var args = Array.prototype.slice.call(arguments, 1),
					form = this[0];
			
			if (options == 'load'){
				for (i = 0; i < form.length; i++)
				{
					field_type = form[i].type.toLowerCase();
					field_name = form[i].name;
					field_id	 = form[i].id;
					$.each(args[0], function(k, v){
						if (field_name == k || field_id == k) { 
							switch (field_type)
							{
							case "select-multiple":
								if ($(form[i]).attr('multiselect') != 'undefined' && jQuery().multiselect){
									$(form[i]).val(v);
									$(form[i]).multiselect('select', v.replace(/\s+/g, '').split(','));
								} else {
									$(form[i]).val(v.replace(/\s+/g, '').split(','));
								}
								break;
							case "text":
							case "email":
							case "number":
							case "password":
								form[i].value = v;
								break;
							case "textarea":
								if ($(form[i]).hasClass('tinymce') && typeof(tinyMCE) !== 'undefined') {
									if (tinyMCE.get(field_id)){
										var id_tmp = field_id, val = v;
										setTimeout(function(){
											tinyMCE.get(id_tmp).setContent(val);
										}, 500);
									} 
								} else if ($(form[i]).hasClass('summernote') && jQuery().summernote){
									$(form[i]).summernote('code', v);
								} else {
									form[i].value = v;
								}
								break;
							case "hidden":
								if (field_id == field_name) {
									// if (!$(form[i]).hasClass('checkbox') && !$(form[i]).hasClass('multiselect'))
									if (!$(form[i]).is('.checkbox, .multiselect'))
										form[i].value = v;
								} else {
									// var shollu = $(form).find('#'+field_name).data('init-shollu_cb')?'shollu_cb':'';
									// shollu = shollu ? shollu : $(form).find('#'+field_name).data('init-shollu_cg')?'shollu_cg':'other';
									// console.log(shollu);
									
									if ($(form).find('#'+field_name).data('init-shollu_cb')) {
										if (jQuery().shollu_cb){
											$(form).find('#'+field_name).shollu_cb('setValue', v);
										}
									}
									if ($(form).find('#'+field_name).data('init-shollu_cg')) {
										if (jQuery().shollu_cg){
											$(form).find('#'+field_name).shollu_cg('setValue', v);
										}
									}
								}
								break;
							case "radio":
							case "checkbox":
								if (jQuery().iCheck) {
									if (parseInt(v)) { 
										$(form[i]).iCheck('check'); 
									} else { 
										$(form[i]).iCheck('uncheck') 
									}
								} else {
									form[i].checked = parseInt(v) ? true : false;
								}
								break;
							case "select-one":
							default:
								break;
							}
						}
					});
				}
			}
			
			if (options == 'reset'){
				for (i = 0; i < form.length; i++)
				{
					field_type = form[i].type.toLowerCase();
					field_name = form[i].name;
					field_id 	 = form[i].id;
					
					if (field_type == 'text' && $(form[i]).attr('readonly'))
						continue;

					switch (field_type)
					{
					case "select-multiple":
						if ($(form[i]).attr('multiselect') != 'undefined' && jQuery().multiselect){
							// $(form[i]).val([]);
							$(form[i]).multiselect('deselectAll', false).multiselect('refresh');
						} else {
							$(form[i]).val([]);
						}
						break;
					case "textarea":
						if ($(form[i]).hasClass('summernote') && jQuery().summernote){
							$(form[i]).summernote('code', '');
						}
						break;
					case "text":
					case "email":
					case "number":
					case "password":
					case "hidden":
						form[i].value = "";
						
						if (field_name){
							if ($(form[i]).attr('data-role') == 'tagsinput' && jQuery().tagsinput()){
								$(form[i]).tagsinput('removeAll');
							}
							if ($(form).find('#'+field_name).data('init-shollu_cb')) {
								if (jQuery().shollu_cb){
									$(form).find('#'+field_name).shollu_cb('setValue', '');
								}
							}
							if ($(form).find('#'+field_name).data('init-shollu_cg')) {
								if (jQuery().shollu_cg){
									$(form).find('#'+field_name).shollu_cg('setValue', '');
								}
							}
						}
						break;
					case "radio":
					case "checkbox":
						if (form[i].checked){	form[i].checked = false; }
						if (jQuery().iCheck) { 
							if ($(form[i]).iCheck('check')) { $(form[i]).iCheck('uncheck'); }
						} 
						break;
					case "select-one":
					case "select-multi":
						form[i].selectedIndex = -1;
						break;
					default:
						break;
					}
				}
			}
			
			return this;
		}
  };
	
}(jQuery));
