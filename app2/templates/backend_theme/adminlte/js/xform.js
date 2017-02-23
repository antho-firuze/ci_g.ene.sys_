(function($) {

  "use strict";

  $.fn.xform = function(options) {
		if (typeof options == 'string') {
			// console.log('debug: options-string');
			var args = Array.prototype.slice.call(arguments, 1),
					form = this[0];
			
			if (options == 'load'){
				// console.log('debug: load');
				for (i = 0; i < form.length; i++)
				{
					field_type = form[i].type.toLowerCase();
					field_name = form[i].name.toLowerCase();
					$.each(args[0], function(k, v){
						// console.log(k);
						if (field_name == k) { 
							switch (field_type)
							{
							case "text":
							case "email":
							case "password":
							case "textarea":
								form[i].value = v;
								break;
							case "hidden":
								// form[i].value = v;
								
								if (jQuery().combogrid){
									// console.log('debug: '+field_name+': '+v);
									if (field_name){
										$(form).find('#'+field_name).combogrid('setValue', v);
									}
								}
								break;
							case "radio":
							case "checkbox":
								// if (parseInt(v)) { form[i].checked = true; } else {	form[i].checked = false; }
								// for plugins iCheck
								if (jQuery().iCheck) {
									if (parseInt(v)) { 
										$(form[i]).iCheck('check'); 
									} else { 
										$(form[i]).iCheck('uncheck') 
									}
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
				// console.log('debug: reset');
				var i, field_type, field_name;
				for (i = 0; i < form.length; i++)
				{
					field_type = form[i].type.toLowerCase();
					field_name = form[i].name.toLowerCase();
					switch (field_type)
					{
					case "text":
					case "email":
					case "password":
					case "textarea":
					case "hidden":
						form[i].value = "";
						if (jQuery().combogrid){
								// console.log('debug: '+field_name);
							if (field_name){
								$(form).find('#'+field_name).combogrid('setValue', '');
							}
						}
						break;
					case "radio":
					case "checkbox":
						if (form[i].checked){	form[i].checked = false; }
						// for plugins iCheck
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