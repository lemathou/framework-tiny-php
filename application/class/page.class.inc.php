<?php

class page_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

//public $_db_id = "id";

public $_fields = array(
	"controller_id" => array("label"=>"Modèle de page", "type"=>"object", "object_type"=>"controller"),
	"url" => array("label"=>"URL", "type"=>"string"),
	"title" => array("label"=>"Titre", "type"=>"string"),
	"description" => array("label"=>"Description", "type"=>"string"),
	"active" => array("label"=>"Titre", "type"=>"bool"),
	"menutop" => array("label"=>"Titre", "type"=>"bool"),
);
public $_field_disp_list = array("titre");
public $_field_select_list = array("titre");
public $_field_query_list = array("titre");

public function menutop()
{

return $this->select("parent_id IS NULL and menutop='1'", null, "`pos`");

}

}

class page extends db_object
{

public $params = null;

function __tostring()
{

return (string)$this->title;

}

function db_retrieve_params()
{

$this->params = array();
$q = db()->select("SELECT name FROM page_data WHERE page_id='".$this->id."'");
while(list($name, $value)=$q->fetch_row())
	$this->params[$name] = $value;

}

function params()
{

if ($this->params === null)
	$this->db_retrieve_params();
return $this->params;

}

function url()
{

return $this->url."-".$this->id.".html";

}

function link()
{

return "<a href=\"".$this->url()."\">".$this->title."</a>";

}

function auth()
{

return true;

}

function controller()
{

return $this->object("controller_id");

}

public function submenu()
{

return $this->_manager()->select("parent_id='".$this->id."'");

}


}

?>