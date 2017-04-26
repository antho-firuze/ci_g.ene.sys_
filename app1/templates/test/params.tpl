{var $template_url = $.php.base_url() ~ "templates/backend/adminlte/"}
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{$template_url}bootstrap/css/bootstrap.min.css">

	<script src="{$template_url}plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="{$.php.base_url()}assets/js/common.func.js"></script>
</head>
<body>
Testing HTTP Params with Array.

<a href="#">To Array</a>
<script>
var $subKey = getURLParameter("subKey");
var $subVal = getURLParameter("subVal");

$('a').click(function(e){
	e.stopPropagation();
	
	var key = [];
	if ($subKey)
		key.push($subKey);
	{* My key *}
	key.push("subKey2");
	
	var val = [];
	if ($subVal)
		val.push($subVal);
	{* My val *}
	val.push("subVal2");
	
	var origin_url = window.location.origin+window.location.pathname;
	console.log(origin_url +'?subKey='+key+'&subVal='+val); 
	{* history.pushState({}, '', origin_url +'?subKey='+key+'&subVal='+val); *}
	window.location.href = origin_url +'?subKey='+key+'&subVal='+val;
});
</script>
</body>
</html>