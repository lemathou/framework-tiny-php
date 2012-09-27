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
<style type="text/css">
p{
	margin: 0;
}
p, td, th, li, input, select, textarea {
	font-size: inherit;
}
form.db_object{
	width: auto;
	font-size: 0.85em;
}
form.db_object table{
	width: 100%;
}
form.db_object th{
	text-align: left;
}
form.db_object th.label{
	width: 250px;
}
form.db_object td.field input{
	width: 100%;
}
form.db_object td.field input.number{
	width: 14em;
}
form.db_object td.field  textarea{
	width: 100%;
	height: 10em;
}
form.db_object td.field  textarea.richtext{
	height: 20em;
}
.list td, .list th{
	vertical-align: top;
}
.list th{
	text-align: left;
}
</style>
</head>
<body>
<h1><?php echo $classname()->_label; ?></h1>
<p>
	<a href="?list">Liste</a>
	| <a href="?add">Ajouter</a>
</p>
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
?>
<form class="db_object" method="post" action="?id=<?php echo $object->id; ?>" enctype="multipart/form-data">
<table>
<?php if ($object->id) { ?>
<tr>
	<th>ID</th>
	<td><?php echo $object->id; ?><input name="id" type="hidden" value="<?php echo $object->id; ?>" /></td>
</tr>
<?php } ?>
<?php foreach($classname()->_fields as $name=>$field) { ?>
<tr>
	<th class="label"><?php echo $field["label"]; ?> :</th>
	<td class="field"><?php
	if (!empty($field["readonly"]) && $object->id)
		echo "<script type=\"text/javascript\">$(document).ready(function(){ $('.db_object [name=".$name."]').attr('disabled','true'); });</script>\n";
	if ($field["type"] == "text")
	{
		echo "<textarea name=\"".$name."\">".$object->$name."</textarea>";
	}
	elseif ($field["type"] == "richtext")
	{
		echo "<textarea class=\"ckeditor\" id=\"".$name."\" name=\"".$name."\">".$object->$name."</textarea>";
	}
	elseif ($field["type"] == "string")
	{
		echo "<input name=\"".$name."\" value=\"".$object->$name."\" />";
	}
	elseif ($field["type"] == "password")
	{
		echo "<input type=\"password\" name=\"".$name."\" value=\"".$object->$name."\" />";
	}
	elseif ($field["type"] == "object")
	{
		$object_class = $field["object_type"];
		if ($object_class()->count() < 20)
		{
		?>
		<select name="<?php echo $name; ?>"><option value="">--</option><?php
		foreach ($object_class()->select() as $o)
			echo "<option value=\"".$o->id."\"".($object->$name==$o->id?" selected":"").">".$o."</option>";
		?></select>
		<?php
		}
		else
		{
		?>
		<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $object->$name; ?>" />
		<input class="select_object" alt="<?php echo $object_class; ?>" id="<?php echo "_".$name."_name"; ?>" value="<?php echo (($object->$name)?$object_class()->get($object->$name):""); ?>" />
		<div id="<?php echo "_".$name."_select"; ?>"></div>
		<?php
		}
	}
	elseif (in_array($field["type"], array("int", "numeric", "float")))
	{
		echo "<input class=\"number\" name=\"".$name."\" value=\"".$object->$name."\" />";
	}
	elseif ($field["type"] == "bool")
	{
		echo "<input type=\"radio\" name=\"".$name."\" value=\"0\"".(is_numeric($object->$name) && !$object->$name ?" checked" : "")." style=\"width:20px;\" /> NON <input type=\"radio\" name=\"".$name."\" value=\"1\"".(is_numeric($object->$name) && $object->$name ?" checked" : "")." style=\"width:20px;\" /> OUI";
	}
	elseif($field["type"] == "img")
	{
		if (isset($field["filename"]))
			 echo "<div style=\"float:right;\"><img src=\"/".$field["folder"]."/".$object->field_map_replace($field["filename"])."\" /></div>";
		elseif ($object->$name)
			echo "<div style=\"float:right;\"><img src=\"/".$object->file($name)."\" /></div>";
		if (isset($field["filename"]))
			echo "<input type=\"hidden\" name=\"".$name."\" value=\"".$object->$name."\" /> ";
		else
			echo "<input name=\"".$name."\" value=\"".$object->$name."\" /> ";
		echo " <input type=\"file\" name=\"".$name."\" />";
	}
	elseif($field["type"] == "file")
	{
		if ($object->$name)
			echo "<div style=\"float:right;\"><a href=\"/".$object->file($name)."\">Télécharger</a></div>";
		echo "<input name=\"".$name."\" value=\"".$object->$name."\" /> <input type=\"file\" name=\"".$name."\" />";
	}
	elseif($field["type"] == "timestamp")
	{
		echo date_mysql($object->$name);
	}
	elseif($field["type"] == "select")
	{
		echo "<select name=\"".$name."\"><option value=\"\">-- Choisir --</option>";
		foreach($field["list"] as $i=>$j)
			echo "<option value=\"".$i."\"".($i==$object->$name ?" selected" : "").">".$j."</option>";
		echo "</select>";
	}
	elseif($field["type"] == "select_multiple")
	{
		echo "<input name=\"".$name."\" value=\"\" type=\"hidden\" /><select name=\"".$name."[]\" multiple>";
		foreach($field["list"] as $i=>$j)
			echo "<option value=\"".$i."\"".(is_array($object->$name)&&in_array($i, $object->$name) ?" selected" : "").">".$j."</option>";
		echo "</select>";
	}
	elseif($field["type"] == "object_list")
	{
		//echo "<input type=\"hidden\" name=\"".$name."\" />";
		$classname = $field["object_type"];
		if (is_array($object->$name))
		{
			foreach($object->$name as $i)
				echo "<p><a href=\"javascript:;\" style=\"color: red;\">X</a> ".($classname()->get($i))."</p>\n";
		}
	}
	?></td>
</tr>
<?php } ?>
<tr>
	<td>&nbsp;</td>
	<td><?php if ($object->id) { ?>
		<input type="submit" name="_update" value="Mettre à jour" />
		<input type="button" name="_delete" value="Supprimer" style="color:red;" onclick="if (confirm('Supprimer ?')) this.form.submit();" />
		<?php } else { ?>
		<input type="submit" name="_insert" value="Ajouter" />
		<?php } ?></td>
</tr>
</table>
</form>
<?php
}
// Liste
else //if ($template == "list")
{
?>
<h3>Liste</h3>
<table class="list">
<tr>
	<td>&nbsp;</td>
<?php foreach ($classname()->_field_disp_list as $name) { ?>
	<th><?php echo $classname()->_fields[$name]["label"]; ?></th>
<?php } ?>
</tr>
<?php foreach($classname()->select() as $object) { ?>
<tr>
<td><a href="?id=<?php echo $object->id; ?>"><img src="images/edit.png" alt="Mettre à jour" title="Modifier" /></a></td>
<?php foreach ($classname()->_field_disp_list as $name) { ?>
	<td><?php
		$field = $classname()->_fields[$name];
		$type = $field["type"];
		if ($type=="object" && is_numeric($object->$name))
		{
			$object_type = $field["object_type"];
			echo $object_type()->get($object->$name);
		}
		elseif (is_string($object->$name))
			echo $object->$name;
		elseif (is_array($object->$name))
			echo implode(", ", $object->$name);
		else
			echo "&nbsp;";
	 ?></td>
<?php } ?>
</tr>
<?php } ?>
</table>
<?php
}
?>
