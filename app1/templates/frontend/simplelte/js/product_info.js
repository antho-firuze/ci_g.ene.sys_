function accordion(dataList){
	
	var id = 'accordion'+BSHelper.newGuid();
	var shelter = $('<div class="panel-group" id="'+id+'" />');

	$.each(dataList, function(i){
		var id2 = 'collapse'+i;
		var panel = $('<div class="panel panel-'+dataList[i]['paneltype']+'" />');
		panel.append($('<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#'+id+'" href="#'+id2+'">'+dataList[i]['title']+'</a></h4></div>'));
		
		panel.append($('<div id="'+id2+'" class="panel-collapse collapse"><div class="panel-body">'+dataList[i]['body']+'</div></div>'));
		shelter.append(panel);
	});
	return shelter;
};

function getCertificates(id){
		// BSHelper.Accordion({ 
			// dataList: [
				// { paneltype:"default",title:"SWG Basic Knowledge",body:swgbasicknowledge },
				// { paneltype:"default",title:"Material Selection",body:materialselection },
				// { paneltype:"default",title:"Torque Installation Guide",body:torqueinstallationguide },
			// ]
		// })
			var b = [
					{ paneltype:"default",title:"SWG Basic Knowledge",body:'swgbasicknowledge' },
					{ paneltype:"default",title:"Material Selection",body:'materialselection' },
					{ paneltype:"default",title:"Torque Installation Guide",body:'torqueinstallationguide' },
				];
			// return accordion(b);
			// return;
	var a = [];
	$.ajax({ url: getCertificate_url, method: "GET", async: true, dataType: 'json',
		data: { "id": id },
		success: function(data) {
			$.each(data.data, function(k, v){
				a.push({ paneltype:"default",title:v.title,body:v.file_name });
			});
			// console.log(a);
			// return BSHelper.Accordion({ dataList:a });
			// return BSHelper.newGuid();
			// return $('<div class="panel-group" />').html(id);
			if (a.length == data.data.length)
				return accordion(a);
			// console.log(a.length);
			// console.log(data.data.length);

		},
		error: function(data) {
			console.log(data.responseText);
			if (data.status==500){
				var message = data.statusText;
			} else {
				var error = JSON.parse(data.responseText);
				var message = error.message;
			}
		}
	}); 
	
}