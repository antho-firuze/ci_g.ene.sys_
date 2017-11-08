(function ($) {

    "use strict";

	$.fn.serialize = function(type) {
		if (typeof(type) == 'undefined') type = 'json';
		type = type.toLowerCase();
		
		var o = {};
		// Exclude Select Element
		var a = this.find('[name]').not('select').serializeArray();
		$.each(a, function (i, v) {
			v.value = (v.value == 'on') ? '1' : v.value;
			o[v.name] = o[v.name] ? o[v.name] || v.value : v.value;
		});
		// Only Select Element
		var a = this.find('select').serializeArray();
		$.each(a, function (i, v) {
			if (o[v.name]) {
				o[v.name] += ',' + v.value;
			} else {
				o[v.name] = v.value;
			}
		});
		return (type == 'json') ? JSON.stringify(o) : o;
	};

	$.fn.serializeJSON = function () {
		var o = {};
		// Exclude Select Element
		var a = this.find('[name]').not('select').serializeArray();
		$.each(a, function (i, v) {
			v.value = (v.value == 'on') ? '1' : v.value;
			o[v.name] = o[v.name] ? o[v.name] || v.value : v.value;
		});
		// Only Select Element
		var a = this.find('select').serializeArray();
		$.each(a, function (i, v) {
			if (o[v.name]) {
				o[v.name] += ',' + v.value;
			} else {
				o[v.name] = v.value;
			}
		});
		return JSON.stringify(o);
	};

	$.fn.serializeOBJ = function () {
		var o = {};
		// Exclude Select Element
		var a = this.find('[name]').not('select').serializeArray();
		$.each(a, function (i, v) {
			v.value = (v.value == 'on') ? '1' : v.value;
			o[v.name] = o[v.name] ? o[v.name] || v.value : v.value;
		});
		// Only Select Element
		var a = this.find('select').serializeArray();
		$.each(a, function (i, v) {
			if (o[v.name]) {
				o[v.name] += ',' + v.value;
			} else {
				o[v.name] = v.value;
			}
		});
		return o;
	};

})(jQuery);

