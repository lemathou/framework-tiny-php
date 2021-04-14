<script type="text/javascript">
var date;
function select_object(object, params)
{
	//alert(params);
	if (params == undefined || !params)
		var s_params = {};
	else
		var s_params = params;
	for(i in s_params)
		alert(i+" : "+s_params[i]);
	s_params.classname = object.alt;
	s_params.fieldname = object.id.substr(1, object.id.length-6);
	s_params.q = object.value;
	//alert(params.q);
	var thisdate = new Date().getTime();
	date = thisdate;
	setTimeout(function(){q_object(s_params, thisdate);}, '500');
}
function q_object(params, thisdate)
{
	if (date == thisdate)
	{
		$.post("db_object_ajax.php", params, function(data){
			//alert(data);
			$("#_"+params.fieldname+"_select").html(data);
		});
	}
}
$(document).ready(function(){
	$("input.select_object").keypress(function(){select_object(this);});
});
</script>
<link href="css/db_object.css" rel="stylesheet" type="text/css" />

</head>
<body>
<h1 style="float: right;margin: 0 10px;"><?php echo $classname()->_label; ?></h1>
<p>
	<a href="?list">Liste</a>
	| <a href="?add">Ajouter</a>
</p>
<hr />
<?php

/* SELECT TEMPLATE */

// Modification
if (isset($_GET["id"]) && ($object=$classname()->get($_GET["id"])))
{

$template = "form";

}

// Ajout
elseif (isset($_GET["add"]))
{

$template = "form";
$object = new $classname();

}

// Liste
else
{

$template = "list";

}

/* DISPLAY TEMPLATE */

if ($template == "form")
{
	include 'db_object.form.tpl.php';
}
// Liste
else //if ($template == "list")
{
        include 'db_object.list.tpl.php';
}

