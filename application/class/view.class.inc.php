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
	"template_main_ref" => array("label"=>"Template principal", "type"=>"string"),
	"template_page_ref" => array("label"=>"Template de page", "type"=>"string"),
	"http_code" => array("label"=>"Code retour HTTP", "type"=>"string"),
	"robots" => array("label"=>"Meta robots (indexation moteurs)", "type"=>"string"),
	"css" => array("label"=>"Feuilles de style", "type"=>"string"),
	"js" => array("label"=>"Javascript", "type"=>"string"),
	"cache_min_ttl" => array("label"=>"TTL mini pour le cache", "type"=>"int"),
	"cache_max_ttl" => array("label"=>"TTL maxi pour le cache", "type"=>"int"),
);
public $_field_disp_list = array("ref", "name", "description");
public $_field_select_list = array("name", "description");
public $_field_query_list = array("name", "description");

}

class view extends db_object
{

public $params = array();

public $header = array(
	"title"=>"",
	"description"=>"",
	"css"=>array(),
	"js"=>array()
);
public $footer = array();
public $page = array();

function __tostring()
{

return (string)$this->name;

}

/**
 * Affichage de la vue
 */
function display()
{

if ($this->css)
	foreach(explode(",", $this->css) as $css)
		$this->header["css"][] = $css;

if ($this->js)
	foreach(explode(",", $this->js) as $js)
		$this->header["js"][] = $js;

if (file_exists($filename=TEMPLATE_DIR."/".$this->template_main_ref.".tpl.php"))
	include $filename;

}

/**
 * Affichage de la partie page de la vue
 */
function template_page_display()
{

$page = $this->page;

if ($this->template_page_ref && file_exists($filename=TEMPLATE_DIR."/page/$this->template_page_ref.tpl.php"))
	include $filename;
elseif (file_existe($filename=TEMPLATE_DIR."/page/default.tpl.php"))
	include $filename;

}

}

?>