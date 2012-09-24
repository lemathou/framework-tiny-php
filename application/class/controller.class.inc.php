<?php

class controller_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

//public $_db_id = "id";

public $_fields = array(
	"ref" => array("label"=>"Référence", "type"=>"string"),
	"name" => array("label"=>"Nom", "type"=>"string"),
	"view_id" => array("label"=>"Nom", "type"=>"object", "object_type"=>"view"),
	"description" => array("label"=>"Description", "type"=>"text"),
);
public $_field_disp_list = array("ref", "name", "description");
public $_field_select_list = array("name", "description");
public $_field_query_list = array("name", "description");

}

class controller extends db_object
{

function __tostring()
{

return (string)$this->name;

}

function view()
{

return $this->object("view_id");

}

/**
 * Traitements éventuels
 * @param unknown_type $param
 */
function action($param)
{

if (count($param) && file_exists($filename=CONTROLLER_DIR."/".$this->ref.".action.inc.php"))
	include $filename;

}

/**
 * Paramétrage de la vue
 * @param unknown_type $param
 */
function prepare($param)
{

if (file_exists($filename=CONTROLLER_DIR."/".$this->ref.".inc.php"))
	include $filename;

}

/**
 * Affichage de la vue
 */
function display()
{

if ($view=$this->view())
	$view->display();

}

}

?>