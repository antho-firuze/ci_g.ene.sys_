(function ($) {

    "use strict";

	$.fn.serializeJSON = function () {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function (i, v) {
			o[v.name] = o[v.name] ? o[v.name] || v.value : v.value;
			// "on" ? "on" || "0" : "0"
			/* if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
					o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			} */
		});
		return JSON.stringify(o);
	};

	$.fn.serializeObject = function () {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function () {
			o[v.name] = o[v.name] ? o[v.name] || v.value : v.value;
			/* if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
					o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			} */
		});
		return o;
	};

})(jQuery);

