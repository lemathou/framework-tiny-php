<?php

class view_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

//public $_db_id = "id";

public $_fields = array(
	"ref" => array("label"=>"Référence", "type"=>"string"),
	"name" => array("label"=>"Nom", "type"=>"string"),
	"description" => array("label"=>"Description", "type"=>"text"),
	"main_template_ref" => array("label"=>"Template principal", "type"=>"string"),
	"cache_min_ttl" => array("label"=>"TTL mini pour le cache", "type"=>"int"),
	"cache_max_ttl" => array("label"=>"TTL maxi pour le cache", "type"=>"int"),
);
public $_field_disp_list = array("ref", "name", "description");
public $_field_select_list = array("name", "description");
public $_field_query_list = array("name", "description");

}

class view extends db_object
{

public $page_template_ref = null;

public $header = array(
	"title"=>"",
	"description"=>"",
	"css"=>array(),
	"js"=>array()
);
public $page = array();
public $footer = array();
public $data = array();

function __tostring()
{

return (string)$this->name;

}

/**
 * Affichage de la vue
 */
function display()
{

if (file_exists($filename=TEMPLATE_DIR."/".$this->main_template_ref.".tpl.php"))
	include $filename;

}

}

?>