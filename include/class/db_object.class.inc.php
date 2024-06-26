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
 * Liste des types de champ "simples" (dans la table principale en base de donn�e)
 * @var []
 */
public $field_simple = array("int", "float", "string", "password", "text", "richtext", "object", "timestamp", "bool", 'date', "select", "select_multiple", "file", "img");

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
 * Class name
 * @var string
 */
public $_name = "";

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
 * More fields specifications
 * @var []
 */
public $_fields_more = array();
public $_db_fields_more_table = '';

/**
 * Fields to display in lists
 * @var []
 */
public $_field_disp_list = array();
/**
 * Object list cache
 * @var []
 */
private $list = array();
/**
 * Object list cache
 * @var []
 */
private $list_ref = array();

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

/**
 * Returns if an object exists
 * @param int|string $param
 * @return bool
 */
public function exists($param)
{

if (is_numeric($param) || is_string($param)) {
	if (is_numeric($param) && isset($this->list[$param])) {
		return true;
	}
	elseif (is_string($param) && isset($this->list_ref[$param])) {
		return true;
	}
	elseif ($this->get($param)) {
		return true;
	}
	else {
		return false;
	}
}
else {
	return false;
}

}

/**
 * Renvoie un object de la base
 * @param int|string $param
 * @return db_object
 */
public function get($param)
{

if (is_numeric($param)) {
	if (isset($this->list[$param])) {
		return $this->list[$param];
	}
	elseif(count($objects=$this->select('id='.$param))==1) {
		$object = array_pop($objects);
		if ($object->ref) {
			$this->list_ref[$object->ref] = $object->id;
		}
		return $object;
	}
	else {
		return false;
	}
}
elseif (isset($this->_fields['ref']) && is_string($param)) {
	if (isset($this->list_ref[$param])) {
		return $this->list[$this->list_ref[$param]];
	}
	elseif (count($objects=$this->select("ref='".mysql_real_escape_string($param)."'"))==1) {
		$object = array_pop($objects);
		if ($object->ref) {
			$this->list_ref[$object->ref] = $object->id;
		}
		return $object;
	}
	else {
		return false;
	}
}
else {
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
	if (!isset($this->list[$row["id"]])){
		$this->list[$row["id"]] = $object = new $classname(null, $row);
		if (isset($row['ref']))
			$this->list_ref[$row["ref"]] = $row["id"];
	}
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

if ($order){
	$q_o = array();
	foreach(explode(', ', $order) as $o)
		if (count($o2=explode(' ', trim($o)))>1)
			$q_o[] = "`".$o2[0]."` ".$o2[1];
		else
			$q_o[] = "`".$o2[0]."`";
	$q_order = "ORDER BY ".implode(', ', $q_o);
}
else
	$q_order = "";

$select_more = array();
$type_select_multiple = array();
$q_select = array("`".$this->_db_id."` as `id`");
foreach($this->_fields as $name=>$field)
{
	if (in_array($field["type"], $this->field_simple))
	{
		if ($field["type"] == "select_multiple")
			$type_select_multiple[] = $name;
		if (isset($field["db_fieldname"]))
			$q_select[] = "`".$field["db_fieldname"]."` as `".$name."`";
		else
			$q_select[] = "`".$name."`";
	}
	elseif ($field["type"] == "object_list")
	{
		$select_more[] = $name;
	}
}

$q_s = "SELECT ".implode(", ", $q_select)." FROM `".$this->_db_table."` ".$q_where." ".$q_order." ".$q_limit;
$q_r = mysql_query($q_s);
if ($this->DB_DEBUG == true || ($error=mysql_error()))
{
	echo "$q_s : ".$error;
}
$list = array();
$list_id = array();
while ($row=mysql_fetch_assoc($q_r))
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
	$list_id[] = $row["id"];
}

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
foreach($this->db_retrieve_more($list_id) as $id=>$row)
	$list[$id] = array_merge($list[$id], $row);

return $list;

}

/**
 * retrieve more info
 * @param []int $list_id
 */
protected function db_retrieve_more($list_id=null)
{

return array();

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
	$q_where = "";

$q_s = "SELECT COUNT(*) FROM `".$this->_db_table."` ".$q_where;
$q_r = mysql_query($q_s);
if ($this->DB_DEBUG == true) {
	echo "$q_s : ".mysql_error();
}
$row = mysql_fetch_row($q_r);
return array_pop($row);

}

public function insert($info=array())
{

$classname = $this->_name;

$object = new $classname();
$object->insert($info);
if ($object->id) {
	$this->list[$object->id] = $object;
	if ($object->ref) {
		$this->list_ref[$object->ref] = $object->id;
	}
	return $object;
}

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
 * Manager object
 * @access public
 * @var db_object_manager
 */
public $_manager = null;
/**
 * Object ID
 * @var int
 */
public $id = null;

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
$classname = $this->_name;
$this->_manager = $classname();

foreach ($this->_manager->_fields as $name=>$value)
	$this->$name = null;

if (is_numeric($id))
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
	return $this->_manager->_name." #".$this->id;
else
	return $this->_manager->_name." # en cours...";

}

/**
 * Return image url
 * @param string $name
 * @return string
 */
public function file($name)
{

if (isset($this->_manager->_fields[$name]) && in_array($this->_manager->_fields[$name]["type"], array("img", "file")) && $this->$name)
{
	return $this->_manager->_fields[$name]["folder"]."/".$this->$name;
}

}

/**
 * Return image url
 * @param string $name
 * @return string
 */
public function img($name, $width=null)
{

if (isset($this->_manager->_fields[$name]) && in_array($this->_manager->_fields[$name]["type"], array("img", "file")) && $this->$name)
{
	if (is_numeric($width))
		return str_replace('img/', 'img2/'.$width.'/', $this->_manager->_fields[$name]["folder"])."/".$this->$name;
	else
		return $this->_manager->_fields[$name]["folder"]."/".$this->$name;
}

}

/**
 * Return object associated to a field
 * @param string $fieldname
 * @return db_object
 */
function object($fieldname)
{

if (!is_string($fieldname) || !isset($this->_manager->_fields[$fieldname]))
	return;

$field = $this->_manager->_fields[$fieldname];
if (!isset($field["type"]) || $field["type"] != "object" || !isset($field["object_type"]))
	return;

if (!is_string($classname=$field["object_type"]) || !class_exists($classname))
	return;
if (!is_numeric($this->$fieldname))
	return;

return $classname()->get($this->$fieldname);

}

/* INSERT UPDATE VERIF */

public function field_calculated(&$info)
{

foreach($this->_manager->_fields as $name=>&$field) if (isset($field['calculate'])){
	list($type, $var) = explode(':', $field['calculate']);
	if ($type=='url'){
		if (!isset($info[$var]))
			continue;
		$url = strtolower(stripAccents($info[$var]));
		$patterns = $replacements = array();
		$patterns[0] = '/(&amp;|&)/i';
		$replacements[0] = '-and-';
		$patterns[1] = '/[^a-zA-Z01-9]/i';
		$replacements[1] = '-';
		$patterns[2] = '/(-+)/i';
		$replacements[2] = '-';
		$patterns[3] = '/(-$|^-)/i';
		$replacements[3] = '';
		$url = preg_replace($patterns, $replacements, $url);
		if (strlen($url)>100){
			$urle = explode('-', $url);
			while (strlen($url)>100){
				array_pop($urle);
				$url = implode('-', $urle);
			}
		}
		$info[$name] = $url;
	}
	if ($type=='ref'){
		if (!isset($info[$var]))
			continue;
		$url = strtolower(stripAccents($info[$var]));
		$patterns = $replacements = array();
		$patterns[0] = '/(&amp;|&)/i';
		$replacements[0] = '';
		$patterns[1] = '/[^a-zA-Z01-9]/i';
		$replacements[1] = '_';
		$patterns[2] = '/(_+)/i';
		$replacements[2] = '_';
		$patterns[3] = '/(_$|^_)/i';
		$replacements[3] = '';
		$url = preg_replace($patterns, $replacements, $url);
		$urle = explode('_', $url);
		$s = 0;
		while (strlen($url)>20) {
			$s++;
			foreach($urle as $i=>&$j) {
				if (strlen($j)<=$s) {
					unset($urle[$i]);
					$url = implode('_', $urle);
					if (strlen($url)<=20)
						 break;
				}
			}
		}
		while (strlen($url)>50){
			array_pop($urle);
			$url = implode('_', $urle);
		}
		$info[$name] = $url;
	}
}

//var_dump($info); die();

}

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
	if (!isset($this->_manager->_fields[$name])) {
		unset($info[$name]);
	}
	else {
		$field = $this->_manager->_fields[$name];
		if (isset($field["type"])) {
			$type = $field["type"];
			if (in_array($type, array("int", "float", "numeric", "decimal"))) {
				if (!is_numeric($value)) {
					$value = NULL;
				}
			}
			elseif ($type == "boolean") {
				$value = ($value) ?1 :0;
			}
			elseif ($type == "object") {
				if (!is_numeric($value)) {
					$value = NULL;
				}
				else {
					$object_classname = $field["object_type"];
					if (!$object_classname()->exists($value))
						$value = NULL;
				}
			}
			elseif (in_array($type, array("string", "text", "richtext"))) {
				if (!is_string($value)) {
					$value = NULL;
				}
			}
			elseif ($type == "select") {
				if ((!is_string($value) && !is_numeric($value)) || !isset($field["list"][$value])) {
					$value = NULL;
				}
			}
			elseif ($type == "select_multiple") {
				if (!is_array($value)) {
					$value = NULL;
				}
				else {
					foreach($value as $i=>$v)
						if (!isset($field["list"][$v]))
							unset($value[$i]);
				}
			}
			elseif ($type == "date") {
				if (!is_string($value)) {
					$value = NULL;
				}
				elseif (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/", $value)) {
					$e = explode("/", $value);
					$e = array_reverse($e);
					$value = implode("-", $e);
				}
				elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value)) {
					$value = NULL;
				}
			}
			elseif (in_array($type, array("datetime", "timestamp"))) {
				if (!is_string($value)) {
					$value = NULL;
				}
				//elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value)) {
			}
			elseif (in_array($type, array("img", "file"))) {
				//var_dump($_FILES);
				// Sans upload ou upload foireux
				if (isset($_FILES[$name]) && (!$_FILES[$name]["tmp_name"] || $_FILES[$name]["error"] != UPLOAD_ERR_OK)) {
					unset($_FILES[$name]);
				}
				// Fichier sans nom ou nom foireux
				if (isset($_FILES[$name])) {
					if (isset($field["filename"])) {
						$_FILES[$name]["name"] = $this->field_map_replace($field["filename"]);
					}
					else {
						$nb = 0;
						$name = $field["filename"];
						while (file_exists(PATH_ROOT."/".$field["folder"]."/".$_FILES[$name]["name"])) {
							$nb++;
							$_FILES[$name]["name"] = $nb."-".$name;
						}
					}
					$value = $_FILES[$name]["name"];
				}
				// Renommage sans fichier
				elseif ($value && (isset($field["filename"]) || !$this->$name || !file_exists(PATH_ROOT."/".$field["folder"]."/".$this->$name))) {
					//echo PATH_ROOT."/".$field["folder"]."/".$this->$name;
					unset($info[$name]);
				}
			}
		}
	}
}
if (!empty($_FILES)) {
	//var_dump($_FILES); var_dump($info);
}

}

function field_map_replace($string)
{

$replace_from = $replace_to = array();
foreach($this->_manager->_fields as $name=>$field)
{
	$replace_from[] = "{".$name."}";
	$replace_to[] = $this->$name;
}
return str_replace($replace_from, $replace_to, $string);

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
	if ($name=="id" || isset($this->_manager->_fields[$name]))
		$this->$name = $value;

}

public function duplicate()
{



}

/* OPERATIONS */

/**
 * Insertion objet
 * @param [] $info
 * @return bool
 */
public function insert($info)
{

if (is_numeric($this->id))
	return;

$this->field_verif($info);
$this->field_calculated($info);
$this->field_verif_insert($info);

if (is_numeric($id=$this->db_insert($info)))
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

if (!is_numeric($this->id))
	return;

$this->field_verif($info);
foreach($info as $name=>$value)
	if ($this->$name === $value && (!in_array($this->_manager->_fields[$name]["type"], array("img", "file")) || !isset($_FILES[$name])))
		unset($info[$name]);
$this->field_verif_update($info);

if ($this->db_update($info))
{
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

if (!is_numeric($this->id))
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

if (!is_numeric($id) || !count($list=$this->_manager->db_retrieve("`".$this->_manager->_db_id."`='".$id."'")))
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

if (!is_numeric($this->id))
	return false;

$q_list = array();
$file_move_list = $file_rename_list = $file_delete_list = array();
//var_dump($_FILES); var_dump($info);
foreach($info as $name=>$value)
{
	$field = $this->_manager->_fields[$name];
	if (isset($field["type"]))
	{
		$type = $field["type"];
		if (in_array($field["type"], $this->_manager->field_simple))
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
			if (in_array($type, array("img", "file")))
			{
				if (isset($_FILES[$name]) && $this->$name) {
					$file_update = true;
					$file_delete_list[] = PATH_ROOT."/".$field["folder"]."/".$this->$name;
				}
				if (!isset($_FILES[$name]) && $this->$name) {
					$file_update = true;
					$file_rename_list[PATH_ROOT."/".$field["folder"]."/".$this->$name] = PATH_ROOT."/".$field["folder"]."/".$value;
				}
				if (isset($_FILES[$name])) {
					$file_update = true;
					$file_move_list[$_FILES[$name]["tmp_name"]] = PATH_ROOT."/".$field["folder"]."/".$value;
				}
			}
		}
	}
}

if (count($q_list)){
	$q_s = "UPDATE `".$this->_manager->_db_table."` SET ".implode(", ", $q_list)." WHERE `".$this->_manager->_db_id."`='".$this->id."'";
	$q_r = mysql_query($q_s);
}

if ($this->_manager->DB_DEBUG == true || (isset($q_s) && ($error=mysql_error())))
{
	echo "$q_s : ".$error;
}
$return = (isset($q_s) && mysql_affected_rows()>0 ?true :false);

foreach($file_delete_list as $name)
{
	if ($this->_manager->FILE_DEBUG)
		echo "<p>Delete $name</p>\n";
	$return = (unlink($name) || $return);
}
foreach($file_rename_list as $from=>$to)
{
	if ($this->_manager->FILE_DEBUG)
		echo "<p>Rename $from $to</p>\n";
	$return = (rename($from, $to) || $return);
}
foreach($file_move_list as $from=>$to)
{
	if ($this->_manager->FILE_DEBUG)
		echo "<p>Move uplodaed $from $to</p>\n";
	//var_dump(move_uploaded_file($from, $to));
	$return = (move_uploaded_file($from, $to) || $return);
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

if (is_numeric($this->id))
	return false;

$q_list_1 = $q_list_2 = array();
$file_move_list = array();
foreach($info as $name=>$value)
{
	$field = $this->_manager->_fields[$name];
	if (isset($field["type"]))
	{
		if (in_array($field["type"], $this->_manager->field_simple))
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
			if (in_array($type, array("img", "file")))
			{
				$file_move_list[$_FILES[$name]["tmp_name"]] = PATH_ROOT."/".$field["folder"]."/".$value;
			}
		}
	}
}

$q_s = "INSERT INTO `".$this->_manager->_db_table."` (".implode(", ", $q_list_1).") VALUES (".implode(", ", $q_list_2).")";
$q_r = mysql_query($q_s);
if ($this->_manager->DB_DEBUG == true)
{
	echo "$q_s : ".mysql_error();
}

$return = mysql_insert_id();

if ($return)
{
	foreach($file_move_list as $from=>$to)
	{
		if ($this->_manager->FILE_DEBUG)
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

if (!is_numeric($this->id))
	return false;

$q_s = "DELETE FROM `".$this->_manager->_db_table."` WHERE `".$this->_manager->_db_id."`='".$this->id."'";
$q_r = mysql_query($q_s);
if ($this->_manager->DB_DEBUG == true)
{
	echo "$q_s : ".mysql_error();
}
$return = (mysql_affected_rows()>0 ?true :false);

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

