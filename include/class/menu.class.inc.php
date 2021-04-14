<?php

/**
 * Gestion menu
 * @author mathieu
 * @package db_object
 *
 */
class menu_manager extends db_object_manager{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Menu";

public $_fields = array(
	"parent_id" => array("label"=>"Parent", "type"=>"object", "object_type"=>"menu"),
	"page_id" => array("label"=>"Page", "type"=>"object", "object_type"=>"page"),
	"pos" => array("label"=>"Position", "type"=>"int"),
	"visible" => array("label"=>"Visible", "type"=>"bool"),
	"params" => array("label"=>"Paramètres supplémentaires", "type"=>""),
);
public $_field_disp_list = array("page_id", "parent_id", "pos", "visible");

protected function db_retrieve_more($list_id=null)
{

if (!is_array($list_id))
	return array();

$list = array();
$sql = "SELECT * FROM `menu_params` WHERE `menu_id` IN (".implode(',', $list_id).") AND `value` IS NOT NULL";
$q = mysql_query($sql);
if ($this->DB_DEBUG == true || ($error=mysql_error())){
	echo "$sql : ".$error;
}
while($row = mysql_fetch_assoc($q))
	$list[$row['menu_id']]['params'][$row['name']] = $row['value'];
return $list;

}

}

class menu extends db_object{

public $params = array();

public function __tostring(){

$page = $this->page();
if (count($this->params))
	return $page->title(current($this->params));
else
	return $page->title();

}

public function page(){

return $this->object('page_id');

}

function controller(){

return $this->page()->controller();

}

public function parent(){

return $this->object('parent_id');

}

protected function db_update_more($info)
{

if (!is_array($info))
	return false;

if (!isset($info['params']) || !count($info['params']))
	return false;

foreach ($info['params'] as $name=>$value){
	$sql = "REPLACE INTO `menu_params`
		(`menu_id`, `name`, `value`)
		VALUES ('$this->id', '$name', '".mysql_real_escape_string($value)."')";
	$q = mysql_query($sql);
	return mysql_affected_rows()>0;
}

return false;

}

}

