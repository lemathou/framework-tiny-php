<?php

class menu_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

//public $_db_id = "id";

public $_fields = array(
	"name" => array("label"=>"Nom", "type"=>"string"),
	"page_list" => array("label"=>"Pages associées")
);
public $_field_disp_list = array("name");
public $_field_select_list = array("name");
public $_field_query_list = array("name");


/**
 * Récupère les pages associées en base de donnée
 */
function db_retrieve_more(&$list)
{

$q = db()->select("SELECT menu_id, pos, page_id FROM menu_page_ref WHERE menu_id IN (".implode(", ", array_keys($list)).") ORDER BY menu_id, pos");
while(list($menu_id, $pos, $page_id) = $q->fetch_row())
	$list[$menu_id]["page_list"][$pos] = $page_id;

}

}

class menu extends db_object
{

function __tostring()
{

return (string)$this->nom;

}

function ordered_list()
{

if (!is_array($this->page_list))
	return array();

$list = array();

foreach($this->page_list as $page_id)
{
	$page = page()->get($page_id);
	if (!$page->parent_id || !in_array($this->page_list, $page_id))
		$list[$page_id] = array();
}

return $list;

}

}

?>