(function (root, factory) {

    "use strict";

    // CommonJS module is defined
    if (typeof module !== 'undefined' && module.exports) {
        var isNode = (typeof process !== "undefined");
        var isElectron = isNode && ('electron' in process.versions);
        if (isElectron) {
            root.DTHelper = factory(root.jQuery);
        } else {
            module.exports = factory(require('jquery'), require('datatables'));
        }
    }
    // AMD module is defined
    else if (typeof define === "function" && define.amd) {
        define("datatables-helper", ["jquery", "datatables"], function ($) {
            return factory($);
        });
    } else {
        // planted over the root!
        root.DTHelper = factory(root.jQuery);
    }

}(this, function ($) {

    "use strict";
	
	var DTHelper = {};
	
	DTHelper.version = '1.0.0';
	
	DTHelper.initCheckList = function(tableData1, dataTable1){
		/* {* Don't change this code: Init for iCheck Plugin *} */
		var iCounter=0;
		var head_cb = tableData1.find('input[type="checkbox"].head-check');
		head_cb.iCheck({ checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue' });
		
		dataTable1.on( 'draw.dt', function () {
			var count_rows = dataTable1.rows().data().length;
			var line_cb = tableData1.find('input[type="checkbox"].line-check');
			line_cb.iCheck({ checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue' });
			line_cb.on('ifChecked', function(){
				// console.log("Debug: Line-Check (True)");
				if (iCounter==0) dataTable1.rows().deselect();
				dataTable1.row( $(this).parents('tr') ).select();
				iCounter++;
				
				if (count_rows==iCounter) { head_cb.data("clicks", true).iCheck('check'); }
			});
			line_cb.on('ifUnchecked', function(){
				dataTable1.row( $(this).parents('tr') ).deselect();
				iCounter--;
				
				if (count_rows!=iCounter) { head_cb.data("clicks", false).iCheck('uncheck'); }
			});
		} );

		/* {* Don't change this code: Init for btn-check *} */
		head_cb.on('ifClicked', function(){
			// console.log("Debug: Head-Check (ifClicked)");
			var clicks = head_cb.data('clicks');
			if (clicks) {
				dataTable1.rows().deselect();
				/* {* tableData1.find('tr[role="row"]').removeClass("selected"); *} */
				tableData1.find('input[type="checkbox"]').iCheck("uncheck");
			} else {
				dataTable1.rows().select();
				/* {* tableData1.find('tr[role="row"]').addClass("selected"); *} */
				tableData1.find('input[type="checkbox"]').iCheck("check");
			}
			head_cb.data("clicks", !clicks);
		});
		
		/* {* Don't change this code: This is for (Checked & Unchecked) or (Selected & Unselected) on DataTable *} */
		tableData1.find('tbody').on( 'click', 'tr', function () {
			var count_rows = dataTable1.rows().data().length;
			var count_selected = dataTable1.rows('.selected').data().length;
			
			if (count_selected !== count_rows) {
				
				if (count_selected <= 1){ 
					tableData1.find('input[type="checkbox"]').iCheck("uncheck");
					dataTable1.row($(this)).select();
				}
				
				if (count_selected > 1) {
					var selected = $(this).hasClass('selected');
					if (selected)
						tableData1.find('.selected input[type="checkbox"]').iCheck("check");
					else
						$(this).find('input[type="checkbox"]').iCheck("uncheck");
				}	
					
				$('#btn-check').data("clicks", false).removeClass("glyphicon-check").addClass('glyphicon-unchecked');
			} 
			
			if (count_selected == count_rows) {
				$(this).find('input[type="checkbox"]').iCheck("check");
				$('#btn-check').data("clicks", true).removeClass("glyphicon-unchecked").addClass('glyphicon-check');
			}
		});
	};
	
	DTHelper.defaults = {
		tableData1: $('<table class="table table-bordered table-hover" />'),
	};
	
	return DTHelper;
	
}));