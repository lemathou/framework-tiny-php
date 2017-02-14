<?php

function field_form($name, $field, $value)
{
	if (isset($field['options']) && $field['options'])
	{
		$options = json_decode($field['options']);
		foreach($options as $i=>$j)
			$field[$i] = $j;
	}
	$type = $field["type"];

	if ($type == "text")
	{
		echo "<textarea name=\"".$name."\">".$value."</textarea>";
	}
	elseif ($type == "richtext")
	{
		echo "<textarea class=\"ckeditor\" id=\"".$name."\" name=\"".$name."\">".$value."</textarea>";
	}
	elseif ($type == "string")
	{
		echo "<input name=\"".$name."\" value=\"".$value."\" />";
	}
	elseif ($type == "password")
	{
		echo "<input type=\"password\" name=\"".$name."\" value=\"".$value."\" />";
	}
	elseif ($type == "object")
	{
		$object_class = $field["object_type"];
		if ($object_class()->count() < 20)
		{
		?>
		<select name="<?php echo $name; ?>"><option value="">--</option><?php
		foreach ($object_class()->select() as $o)
			echo "<option value=\"".$o->id."\"".($value==$o->id?" selected":"").">".$o."</option>";
		?></select>
		<?php
		}
		else
		{
		?>
		<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<input class="select_object" alt="<?php echo $object_class; ?>" id="<?php echo "_".$name."_name"; ?>" value="<?php echo (($value)?$object_class()->get($value):""); ?>" />
		<div id="<?php echo "_".$name."_select"; ?>"></div>
		<?php
		}
	}
	elseif (in_array($type, array("int", "numeric", "float")))
	{
		echo "<input class=\"number\" name=\"".$name."\" value=\"".$value."\" />";
	}
	elseif (in_array($type, array("bool", "boolean")))
	{
		echo "<input type=\"radio\" name=\"".$name."\" value=\"0\"".(is_numeric($value) && !$value ?" checked" : "")." style=\"width:20px;\" /> NON <input type=\"radio\" name=\"".$name."\" value=\"1\"".(is_numeric($value) && $value ?" checked" : "")." style=\"width:20px;\" /> OUI";
	}
	elseif(in_array($type, array("img", 'file')))
	{
		//var_dump($field);
		if ($value){
			if ($type=='img')
				echo "<div style=\"float:right;\"><a href=\"/".$value."\" title=\"Agrandir\" target=\"_blank\"><img src=\"/".$value."\" style=\"max-width: 600px;\" /></a></div>";
			else
				echo "<div style=\"float:right;\"><a href=\"/".$field["folder"]."/".$value."\">Télécharger</a></div>";
		}
		if (isset($field["filename"]))
			echo "<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" /> ";
		else
			echo "<input name=\"".$name."\" value=\"".$value."\" /> ";
		echo "<input type=\"file\" name=\"".$name."\" />";
	}
	elseif(in_array($type, array("timestamp", "datetime")))
	{
		echo date_mysql($value);
	}
	elseif(in_array($type, array("date")))
	{
		echo date_mysql($value);
	}
	elseif($type == "select")
	{
		echo "<select name=\"".$name."\"><option value=\"\">-- Choisir --</option>";
		foreach($field["list"] as $i=>$j)
			echo "<option value=\"".$i."\"".($i==$value ?" selected" : "").">".$j."</option>";
		echo "</select>";
	}
	elseif($type == "select_multiple")
	{
		echo "<input name=\"".$name."\" value=\"\" type=\"hidden\" /><select name=\"".$name."[]\" multiple>";
		foreach($field["list"] as $i=>$j)
			echo "<option value=\"".$i."\"".(is_array($value)&&in_array($i, $value) ?" selected" : "").">".$j."</option>";
		echo "</select>";
	}
	elseif($type == "object_list")
	{
		//echo "<input type=\"hidden\" name=\"".$name."\" />";
		$classname = $field["object_type"];
		if (is_array($value))
		{
			foreach($value as $i)
				echo "<p><a href=\"javascript:;\" style=\"color: red;\">X</a> ".($classname()->get($i))."</p>\n";
		}
	}

}
