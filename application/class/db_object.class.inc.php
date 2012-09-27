<?php

/**
 * Classe de gestion ORM
 * @author mathieu
 * @package db_object
 *
 */
class db_object_manager
{

/**
 * Liste des types de champ "simples" (dans la table principale en base de donnée)
 * @var []
 */
public $field_simple = array("int", "float", "string", "text", "richtext", "object", "timestamp", "bool", "select", "select_multiple", "file", "img", "date", "datetime");

/**
 * Debug database operations
 * @var bool
 */
public $DB_DEBUG = false;
/**
 * Debug file operations
 * @var bool
 */
public $FILE_DEBUG = false;
/**
 * Class name shortcut
 * @var string
 */
public $_name = "";
/**
 * Object type name (displayed)
 * @var string
 */
public $_label = "";
/**
 * Database name
 * @var string
 */
public $_db_table = "";
/**
 * ID field name in database
 * @var string
 */
public $_db_id = "id";
/**
 * Fields specifications
 * @var []
 */
public $_fields = array();
/**
 * Fields to display by default in lists
 * @var []
 */
public $_field_disp_list = array();
/**
 * Fields to display in selection form
 * @var []
 */
public $_field_select_list = array();
/**
 * Fields to look for
 * @var []
 */
public $_field_query_list = array();

/**
 * Object list cache
 * @var []
 */
private $list = array();

/**
 * Constructeur
 */
public function __construct()
{

if (!$this->_name)
	$this->_name = substr(get_class($this), 0, -8);
if (!$this->_db_table)
	$this->_db_table = $this->_name;

}

public function test_id($id)
{

return is_numeric($id);

}

public function create()
{

$classname = $this->_name;

$object = new $classname();
return $object;

}

/**
 * 
 * @param [] $info
 * @return db_object
 */
public function insert($info)
{

$object = $this->create();
if ($object->insert($info))
	return $object;

}

/**
 * Returns if an object exists
 * @param int $id
 * @return bool
 */
public function exists($id)
{

if (!$this->test_id($id))
{
	return false;
}
elseif (isset($this->list[$id]))
{
	return true;
}
else
{
	$classname = $this->_name;
	$object = new $classname($id);
	if ($object->id)
	{
		$this->list[$id] = $object;
		return true;
	}
	else
	{
		return false;
	}
}

}

/**
 * Renvoie un object de la base
 * @param int $id
 * @return db_object
 */
public function get($id)
{

if (!$this->test_id($id))
{
	return false;
}
elseif (isset($this->list[$id]))
{
	return $this->list[$id];
}
else
{
	$classname = $this->_name;
	$object = new $classname($id);
	if ($object->id)
		return $this->list[$id] = $object;
	else
		return false;
}

}

/**
 * Select en base de donn�e
 * @param [] $params
 * @param int $limit
 * @param string $order
 * @return []
 */
public function select($params=null, $limit=null, $order=null)
{

$classname = $this->_name;

$list = array();
foreach ($this->db_retrieve($params, $limit, $order) as $row)
{
	if (!isset($this->list[$row["id"]]))
		$this->list[$row["id"]] = $object = new $classname(null, $row);
	else
		$object = $this->list[$row["id"]];
	$list[] = $object;
}

return $list;

}
/**
 * Select en base de donn�e
 * @param [] $params
 * @param int $limit
 * @param string $order
 * @return []
 */
public function db_retrieve($params=null, $limit=null, $order=null)
{

if ($params)
	$q_where = "WHERE ".$params;
else
	$q_where = "";

if ($limit)
	$q_limit = "LIMIT ".$limit;
else
	$q_limit = "";

if ($order)
	if (substr($order, 0, 1)=="`")
		$q_order = "ORDER BY ".$order;
	else
		$q_order = "ORDER BY `".$order."`";
else
	$q_order = "";

$select_more = array();
$type_select_multiple = array();
$q_select = array("`".$this->_db_id."` as `id`");
foreach($this->_fields as $name=>$field)
{
	if (isset($field["type"]) && in_array($field["type"], $this->field_simple))
	{
		if ($field["type"] == "select_multiple")
			$type_select_multiple[] = $name;
		if (isset($field["db_fieldname"]))
			$q_select[] = "`".$field["db_fieldname"]."` as `".$name."`";
		else
			$q_select[] = "`".$name."`";
	}
	elseif (isset($field["type"]) && $field["type"] == "object_list")
	{
		$select_more[] = $name;
	}
}

$q_r = db()->select("SELECT ".implode(", ", $q_select)." FROM `".$this->_db_table."` ".$q_where." ".$q_order." ".$q_limit);
if ($this->DB_DEBUG == true)
{
	echo "$q_r->sql : ".mysql_error();
}
$list = array();
while ($row=$q_r->fetch_assoc())
{
	// @todo : tout pourris...
	foreach($row as $i=>$j)
		$row[$i] = stripslashes($j);
	foreach($type_select_multiple as $name)
	{
		if ($row[$name] !== null)
			$row[$name] = explode(",", $row[$name]);
		else
			$row[$name] = array();
	}
	$list[$row["id"]] = $row;
}
echo mysql_error();

// Fields of type : object_list
foreach($select_more as $name)
{
	$field = $this->_fields[$name];
	$classname = $field["object_type"];
	$q_s = "SELECT `".$field["db_field_id"]."` as id, `".$field["db_field_ref_id"]."` as ref_id FROM `".$field["db_table"]."` WHERE `".$field["db_field_ref_id"]."` IN (".implode(", ", $list_id).")";
	$q_r = mysql_query($q_s);
	while ($row=mysql_fetch_assoc($q_r))
	{
		$list[$row["ref_id"]][$name][] = $row["id"];
	}
}

// More fields
if (count($list))
	$this->db_retrieve_more($list);

return $list;

}

/**
 * retrieve more info
 * @param [] $list
 */
protected function db_retrieve_more(&$list)
{

}

/**
 * Count en base de donn�e
 * @param [] $params
 * @return int
 */
public function count($params=null)
{

$classname = $this->_name;

if ($params)
	$q_where = "WHERE ".$params;
else
	$q_where;

$q_s = "SELECT COUNT(*) FROM `".$this->_db_table."` ".$q_where;
$q_r = mysql_query($q_s);
if ($this->DB_DEBUG == true)
{
	echo "$q_s : ".mysql_error();
}

return array_pop(mysql_fetch_row($q_r));

}

}

/**
 * Classe objet ORM
 * @author mathieu
 * @package db_object
 *
 */
class db_object
{

/**
 * Class name
 * @var string
 */
public $_name = "";

/**
 * Object ID
 * @var int
 */
public $id = null;

public function _field($name)
{

if (isset($this->_manager()->_fields[$name]))
	return $this->_manager()->_fields[$name];

}

public function _field_label($name)
{

if (isset($this->_manager()->_fields[$name]))
	return $this->_manager()->_fields[$name]["label"];

}

public function _label()
{

return $this->_manager()->_label;

}

public function _manager()
{

$classname = $this->_name;
return $classname();

}

public function test_id($id)
{

return $this->_manager()->test_id($id);

}

/* CONSTRUCT */

/**
 * Constructeur
 * @param int $id
 * @param [] $info
 */
public function __construct($id=null, $info=null)
{

if (!$this->_name)
	$this->_name = get_class($this);

foreach ($this->_manager()->_fields as $name=>$value)
	$this->$name = null;

if ($this->test_id($id))
{
	if ($info=$this->db_retrieve($id))
		$this->field_update($info);
}
elseif (is_array($info))
{
	$this->field_update($info);
}

}

/* DISPLAY */

/**
 * Default display
 * @return string
 */
public function __tostring()
{

if ($this->id)
	return $this->_manager()->_name." #".$this->id;
else
	return $this->_manager()->_name." # en cours...";

}

public function field_form($name)
{

$field = $this->_manager()->_fields[$name];

if ($field["type"] == "text")
{
	echo "<textarea name=\"".$name."\">".$this->$name."</textarea>";
}
elseif ($field["type"] == "richtext")
{
	if (isset($field["textmode"]) && $field["textmode"] == "rich") { ?>
<script type="text/javascript">
tinyMCE.init({
mode : "exact",
elements : "<?php echo $name; ?>",
theme : "advanced",
force_br_newlines : "true",
plugins : "table,zoom,paste,searchreplace,insertdatetime,directionality,print,paste,ibrowser",
button_tile_map : true,
//theme_advanced_buttons1_add : "fontsizeselect",//fontselect,,separator
theme_advanced_buttons2_add : "separator,forecolor,backcolor",//print,separator,insertdate,inserttime,
theme_advanced_buttons2: "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,link,unlink,separator,charmap,pastetext,code,ibrowser",//,separator,hr,removeformat
theme_advanced_buttons3: "separator",
theme_advanced_buttons3_add_before: "tablecontrols,separator,pastetext,selectall,search,replace",//pasteword,,ltr,rtl
paste_create_paragraphs : false,
paste_create_linebreaks : false,
paste_use_dialog : true,
paste_auto_cleanup_on_paste : true,
paste_convert_middot_lists : false,
paste_unindented_list_class : "unindentedList",
paste_convert_headers_to_strong : true,
theme_advanced_blockformats : "p,h1,h2,h3",
theme_advanced_toolbar_location : "top",
content_css : "../css/wyziwyg.css",
external_image_list_url : "script/image_list.js",
language : "fr",
preformatted : false,
invalid_elements : "div,span"
});
</script>
<?php } else {//if ($field["textmode"] == "light") ?>
<script type="text/javascript">
tinyMCE.init({
mode : "exact",
elements : "<?php echo $name; ?>",
theme : "advanced",
plugins : "paste,ibrowser",
force_br_newlines : true,
theme_advanced_buttons1: "bold,italic,underline,strikethrough,link,unlink,undo,redo,cleanup,bullist,numlist,pastetext,code,ibrowser",
theme_advanced_buttons2: "",
theme_advanced_buttons3: "",
convert_newlines_to_brs: true,
button_tile_map : true,
language : "fr",
preformatted : false,
invalid_elements : "div,span"
});
</script>
<?php }
	echo "<textarea class=\"richtext\" id=\"".$name."\" name=\"".$name."\">".$this->$name."</textarea>";
}
elseif ($field["type"] == "string")
{
	echo "<input name=\"".$name."\" value=\"".$this->$name."\" />";
}
elseif ($field["type"] == "object")
{
	$object_class = $field["object_type"];
	?>
	<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $this->$name; ?>" />
	<input class="select_object" alt="<?php echo $object_class; ?>" id="<?php echo "_".$name."_name"; ?>" value="<?php echo (($this->$name)?$object_class()->get($this->$name):""); ?>" />
	<div id="<?php echo "_".$name."_select"; ?>"></div>
	<?php
}
elseif (in_array($field["type"], array("int", "numeric", "float")))
{
	echo "<input class=\"number\" name=\"".$name."\" value=\"".$this->$name."\" />";
}
elseif ($field["type"] == "bool")
{
	echo "<input type=\"radio\" name=\"".$name."\" value=\"\"".(!is_numeric($this->$name) ?" checked" : "")." /> Ind�fini";
	echo "<input type=\"radio\" name=\"".$name."\" value=\"0\"".(is_numeric($this->$name) && !$this->$name ?" checked" : "")." /> NON";
	echo " <input type=\"radio\" name=\"".$name."\" value=\"1\"".(is_numeric($this->$name) && $this->$name ?" checked" : "")." /> OUI";
}
elseif($field["type"] == "img")
{
	if ($this->$name)
		echo "<div style=\"float:right;\"><img src=\"/".$this->file($name)."\" /></div>";
	echo "<input name=\"".$name."\" value=\"".$this->$name."\" /> <input type=\"file\" name=\"".$name."\" />";
}
elseif($field["type"] == "file")
{
	if ($this->$name)
		echo "<div style=\"float:right;\"><a href=\"/".$this->file($name)."\">T�l�charger</a></div>";
	echo "<input name=\"".$name."\" value=\"".$this->$name."\" /> <input type=\"file\" name=\"".$name."\" />";
}
elseif($field["type"] == "timestamp")
{
	echo date_mysql($this->$name);
}
elseif($field["type"] == "select")
{
	echo "<select name=\"".$name."\"><option value=\"\">-- Choisir --</option>";
	foreach($field["list"] as $i=>$j)
		echo "<option value=\"".$i."\"".($i==$this->$name ?" selected" : "").">".$j."</option>";
	echo "</select>";
}
elseif($field["type"] == "select_multiple")
{
	echo "<input name=\"".$name."\" value=\"\" type=\"hidden\" /><select name=\"".$name."[]\" multiple>";
	foreach($field["list"] as $i=>$j)
		echo "<option value=\"".$i."\"".(is_array($this->$name)&&in_array($i, $this->$name) ?" selected" : "").">".$j."</option>";
	echo "</select>";
}
elseif($field["type"] == "object_list")
{
	//echo "<input type=\"hidden\" name=\"".$name."\" />";
	$classname = $field["object_type"];
	if (is_array($this->$name))
	{
		foreach($this->$name as $i)
		echo "<p><a href=\"javascript:;\" style=\"color: red;\">X</a> ".($classname()->get($i))."</p>\n";
	}
}

}

/**
 * Return image url
 * @param string $name
 * @return string
 */
public function file($name)
{

if (isset($this->_manager()->_fields[$name]) && in_array($this->_manager()->_fields[$name]["type"], array("img", "file")) && $this->$name)
{
	return $this->_manager()->_fields[$name]["folder"]."/".$this->$name;
}

}

/**
 * Return object associated to a field
 * @param string $fieldname
 * @return db_object
 */
function object($fieldname)
{

if (!is_string($fieldname) || !isset($this->_manager()->_fields[$fieldname]))
	return;

$field = $this->_manager()->_fields[$fieldname];
if (!isset($field["type"]) || $field["type"] != "object" || !isset($field["object_type"]))
	return;

$classname = $field["object_type"];
return $classname()->get($this->$fieldname);

}

/* INSERT UPDATE VERIF */

/**
 * Contr�le des champs
 * @param [] $info
 */
public function field_verif(&$info)
{

if (!is_array($info))
	$info = array();

foreach($info as $name=>&$value)
{
	if (!isset($this->_manager()->_fields[$name]))
	{
		unset($info[$name]);
	}
	else
	{
		$field = $this->_manager()->_fields[$name];
		if (isset($field["type"]))
		{
			$type = $field["type"];
			if (in_array($type, array("object", "int", "float", "numeric", "decimal")) && !is_numeric($value))
			{
				$value = NULL;
			}
			elseif ($type == "object" && $value)
			{
				$object_classname = $field["object_type"];
				if (!$object_classname()->exists($value))
					$value = NULL;
			}
			elseif (in_array($type, array("string", "text", "richtext")) && !is_string($value))
			{
				$value = NULL;
			}
					elseif ($type == "select" && ((!is_string($value) && !is_numeric($value)) || !isset($field["list"][$value])))
			{
				$value = NULL;
			}
			elseif ($type == "select_multiple")
			{
				if (!is_array($value))
				{
					$value = NULL;
				}
				else
				{
					foreach($value as $i=>$v)
						if (!isset($field["list"][$v]))
							unset($value[$i]);
				}
			}
			elseif ($type == "date")
			{
				if (!is_string($value))
					$value = NULL;
				elseif (is_numeric(strpos($value, "/")))
					$value = implode("-", array_reverse(explode("/", $value)));
			}
			elseif ($type == "datetime")
			{
				if (!is_string($value))
					$value = NULL;
			}
			elseif ($type == "img" || $type == "file")
			{
				// Sans upload ou upload foireux
				if (isset($_FILES[$name]) && (!$_FILES[$name]["tmp_name"] || $_FILES[$name]["error"] != UPLOAD_ERR_OK))
				{
					unset($_FILES[$name]);
				}
				// Fichier sans nom ou nom foireux
				if (isset($_FILES[$name]))
				{
					$nb = 0;
					$name = $_FILES[$name]["name"];
					while (file_exists(PATH_ROOT."/".$field["folder"]."/".$_FILES[$name]["name"]))
					{
						$nb++;
						$_FILES[$name]["name"] = $nb."-".$name;
					}
					$value = $_FILES[$name]["name"];
				}
				// Renommage sans fichier
				elseif ($value && (!$this->$name || !file_exists(PATH_ROOT."/".$field["folder"]."/".$this->$name)))
				{
					//echo PATH_ROOT."/".$field["folder"]."/".$this->$name;
					unset($info[$name]);
				}
			}
		}
	}
}
//var_dump($_FILES); var_dump($info);

}

/**
 * Contr�le suppl�mentaire � l'insertion
 * @param [] $info
 */
public function field_verif_insert(&$info)
{

}

/**
 * Contr�le suppl�mentaire � la mise � jour
 * @param [] $info
 */
public function field_verif_update(&$info)
{

}

/**
 * Update object with data
 * @param [] $info
 */
private function field_update(&$info)
{

if (!is_array($info))
	return;

foreach($info as $name=>$value)
	if ($name=="id" || isset($this->_manager()->_fields[$name]))
		$this->$name = $value;

}

/* OPERATIONS */

/**
 * Insertion objet
 * @param [] $info
 * @return bool
 */
public function insert($info)
{

if ($this->test_id($this->id))
	return;

$this->field_verif($info);
$this->field_verif_insert($info);

if ($this->test_id($id=$this->db_insert($info)))
{
	$this->id = $id;
	$this->field_update($info);
	return true;
}
else
	return false;

}

/**
 * Mise � jour objet
 * @param [] $info
 * @return bool
 */
public function update($info)
{

if (!$this->test_id($this->id))
	return;

$this->field_verif($info);
foreach($info as $name=>$value)
	if ($this->$name === $value && (!in_array($this->_manager()->_fields[$name]["type"], array("img", "file")) || !isset($_FILES[$name])))
		unset($info[$name]);
$this->field_verif_update($info);

//var_dump($info);
if ($this->db_update($info))
{
	//var_dump($info);
	$this->field_update($info);
	return true;
}
else
	return false;

}

/**
 * Supression objet
 * @return bool
 */
public function delete()
{

if (!$this->test_id($this->id))
	return;

return $this->db_delete($this->id);

}

/* DATABASE */
/*
 * Comprend autant les op�rations en base de donn�e que sur le syst�me de fichiers,
 * bref sur tout support de stockage de donn�e (ce qui se tient logiquement)
 */

/**
 * Retrieve object info from database
 * @param int $id
 * @return []|bool
 */
protected function db_retrieve($id)
{

if (!$this->test_id($id) || !count($list=$this->_manager()->db_retrieve("`".$this->_manager()->_db_id."`='".$id."'")))
	return false;

return array_pop($list);

}

/**
 * Update object in database
 * @param [] $info
 * @return int
 */
protected function db_update($info)
{

if (!$this->test_id($this->id))
	return false;

$q_list = array();
$file_move_list = $file_rename_list = $file_delete_list = array();
//var_dump($_FILES); var_dump($info);
foreach($info as $name=>$value)
{
	$field = $this->_manager()->_fields[$name];
	if (isset($field["type"]))
	{
		$type = $field["type"];
		if (in_array($field["type"], $this->_manager()->field_simple))
		{
			if ($field["type"] == "select_multiple")
			{
				if (is_array($value))
					foreach($value as $i=>$v)
						$value[$i] = mysql_real_escape_string($v);
				$q_list[] = "`".(isset($field["db_fieldname"]) ?$field["db_fieldname"] :$name)."` = ".(is_array($value)&&count($value) ?"'".implode(",",$value)."'" :"NULL");
			}
			else
				$q_list[] = "`".(isset($field["db_fieldname"]) ?$field["db_fieldname"] :$name)."` = ".($value===NULL?"NULL":"'".mysql_real_escape_string($value)."'");
			if ($type == "img")
			{
				if (isset($_FILES[$name]) && $this->$name)
					$file_delete_list[] = PATH_ROOT."/".$field["folder"]."/".$this->$name;
				if (!isset($_FILES[$name]) && $this->$name)
					$file_rename_list[PATH_ROOT."/".$field["folder"]."/".$this->$name] = PATH_ROOT."/".$field["folder"]."/".$value;
				if (isset($_FILES[$name]))
					$file_move_list[$_FILES[$name]["tmp_name"]] = PATH_ROOT."/".$field["folder"]."/".$value;
			}
		}
	}
}

$q_r = db()->update("UPDATE `".$this->_manager()->_db_table."` SET ".implode(", ", $q_list)." WHERE `".$this->_manager()->_db_id."`='".$this->id."'");

if ($this->_manager()->DB_DEBUG == true)
{
	echo "$q_s : ".mysql_error();
}
$return = ($q_r->affected_rows()>0 ?true :false);
if ($return)
{
	foreach($file_delete_list as $name)
	{
		if ($this->_manager()->FILE_DEBUG)
			echo "<p>Delete $name</p>\n";
		unlink($name);
	}
	foreach($file_rename_list as $from=>$to)
	{
		if ($this->_manager()->FILE_DEBUG)
			echo "<p>Rename $from $to</p>\n";
		rename($from, $to);
	}
	foreach($file_move_list as $from=>$to)
	{
		if ($this->_manager()->FILE_DEBUG)
			echo "<p>Move uplodaed $from $to</p>\n";
		move_uploaded_file($from, $to);
	}
}

// More fields
$return = ($this->db_update_more($info) || $return);

return $return;

}

/**
 * Modification suppl�mentaire
 * @param [] $info
 */
protected function db_update_more($info)
{

return false;

}

/**
 * Insert in database
 * @param [] $info
 * @return bool
 */
protected function db_insert($info)
{

if ($this->test_id($this->id))
	return false;

$q_list_1 = $q_list_2 = array();
$file_move_list = array();
foreach($info as $name=>$value)
{
	$field = $this->_manager()->_fields[$name];
	if (isset($field["type"]))
	{
		if (in_array($field["type"], $this->_manager()->field_simple))
		{
			$type = $field["type"];
			$q_list_1[] = "`".(isset($field["db_fieldname"]) ?$field["db_fieldname"] : $name)."`";
			if ($field["type"] == "select_multiple")
			{
				if (is_array($value))
					foreach($value as $i=>$v)
						$value[$i] = "'".mysql_real_escape_string($v)."'";
				$q_list_2[] = (is_array($value)&&count($value) ?"(".implode(",",$value).")" :"NULL");
			}
			else
				$q_list_2[] = ($value===NULL?"NULL":"'".mysql_real_escape_string($value)."'");
			if ($type == "img")
			{
				$file_move_list[$_FILES[$name]["tmp_name"]] = PATH_ROOT."/".$field["folder"]."/".$value;
			}
		}
	}
}

$q_r = db()->insert("INSERT INTO `".$this->_manager()->_db_table."` (".implode(", ", $q_list_1).") VALUES (".implode(", ", $q_list_2).")");
if ($this->_manager()->DB_DEBUG == true)
{
	echo "$q_r->sql : ".mysql_error();
}

$return = $q_r->insert_id();

if ($return)
{
	foreach($file_move_list as $from=>$to)
	{
		if ($this->_manager()->FILE_DEBUG)
			echo "<p>Move uploaded $from $to</p>\n";
		move_uploaded_file($from, $to);
	}
}

if ($return)
	$this->db_insert_more($return, $info);

return $return;

}

/**
 * Insertions suppl�mentaires
 * @param int $id
 * @param [] $info
 * @return bool
 */
protected function db_insert_more($id, $info)
{

return false;

}

/**
 * Delete object in database
 * @return bool
 */
protected function db_delete()
{

if (!$this->test_id($this->id))
	return false;

$q_r = db()->update("DELETE FROM `".$this->_manager()->_db_table."` WHERE `".$this->_manager()->_db_id."`='".$this->id."'");
if ($this->_manager()->DB_DEBUG == true)
{
	echo "$q_r->sql : ".mysql_error();
}
$return = ($q_r->affected_rows()>0 ?true :false);

if ($return)
	$this->db_delete_more();

return $return;

}

/**
 * Suppressions suppl�mentaires
 * @return bool
 */
protected function db_delete_more()
{

return false;

}

}

?>