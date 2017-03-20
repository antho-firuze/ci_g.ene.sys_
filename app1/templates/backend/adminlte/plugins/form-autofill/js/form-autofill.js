(function($) {

  "use strict";

  $.fn.xform = function(options) {
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
							case "text":
							case "email":
							case "number":
							case "password":
							case "textarea":
								form[i].value = v;
								break;
							case "hidden":
								if (field_id == field_name) {
									if (! $(form[i]).hasClass('checkbox'))
										form[i].value = v;
								} else {
									if (jQuery().combogrid){
										$(form).find('#'+field_name).combogrid('setValue', v);
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
									form[i].checked = (v)?true:false;
								}
								break;
							case "select-one":
							case "select-multi":
								// form[i].selectedIndex = -1;
								break;
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
					switch (field_type)
					{
					case "text":
					case "email":
					case "number":
					case "password":
					case "textarea":
					case "hidden":
						form[i].value = "";
						if (jQuery().combogrid){
							if (field_name){
								$(form).find('#'+field_name).combogrid('setValue', '');
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
