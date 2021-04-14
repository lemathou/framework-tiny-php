<form class="db_object" method="post" action="?id=<?php echo $object->id; ?>" enctype="multipart/form-data">
<table>
<?php if ($object->id) { ?>
<tr>
	<th>ID</th>
	<td><?php echo $object->id; ?><input name="id" type="hidden" value="<?php echo $object->id; ?>" /></td>
</tr>
<?php } ?>
<?php foreach($classname()->_fields as $name=>$field) if (in_array($field['type'], $classname()->field_simple) && (empty($field["calculate"])) && ($object->id || empty($field["notinsert"])) && (!$object->id || empty($field["notupdate"]))) { ?>
<tr>
	<th class="label"><?php echo $field["label"]; ?> :</th>
	<td class="field<?php echo " field_".$field["type"]; ?>"><?php
	if (!empty($field["readonly"]))
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
		echo "<input name=\"".$name."\" value=\"".htmlentities($object->$name, ENT_COMPAT, "UTF-8")."\" />";
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
	elseif (in_array($field["type"], array("bool", "boolean")))
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
	elseif(in_array($field["type"], array("timestamp", "datetime")))
	{
		echo date_mysql($object->$name);
	}
	elseif($field["type"] = "date")	
	{
		echo "<input name=\"".$name."\" value=\"".date_en2fr($object->$name)."\" class=\"date\" />";
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
</tr>
<tr>
	<td>&nbsp;</td>
	<td><?php if ($object->id) { ?>
		<input type="submit" name="_update" value="Mettre à jour" />
		<input type="submit" name="_delete" value="Supprimer" style="color:red;" onclick="return (confirm('Supprimer ?'))" />
		<?php } else { ?>
		<input type="submit" name="_insert" value="Ajouter" />
		<?php } ?></td>
</tr>
</table>
</form>
<?php if (file_exists($filename=PATH_ROOT."/admin/template/form/$classname.tpl.php")) { include $filename; } ?>

