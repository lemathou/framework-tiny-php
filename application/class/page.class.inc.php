<?php

class page_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

//public $_db_id = "id";

public $_fields = array(
	"parent_id" => array("label"=>"Page parente", "type"=>"object", "object_type"=>"page"),
	"controller_id" => array("label"=>"Modèle de page", "type"=>"object", "object_type"=>"controller"),
	"url" => array("label"=>"URL", "type"=>"string"),
	"title" => array("label"=>"Titre", "type"=>"string"),
	"description" => array("label"=>"Description", "type"=>"string"),
	"active" => array("label"=>"Titre", "type"=>"bool"),
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
public $controller = null;

function __tostring()
{

return (string)$this->title;

}

/**
 * Récupère les paramètres de page en base de donnée
 */
function db_retrieve_params()
{

$this->params = array();
$q = db()->select("SELECT name, value FROM page_params WHERE page_id='".$this->id."'");
while(list($name, $value)=$q->fetch_row())
	$this->params[$name] = $value;

}

/**
 * Paramètres de page
 * @return []
 */
function params()
{

if ($this->params === null)
	$this->db_retrieve_params();
return $this->params;

}

/**
 * URL
 * @return string
 */
function url()
{

if ($this->id == PAGE_DEFAULT_ID)
	return "/";
else
	return $this->url."-".$this->id.".html";

}

/**
 * Lien vers la page
 * @return string
 */
function link()
{

return "<a href=\"".$this->url()."\">".$this->title."</a>";

}

/**
 * @return bool
 */
function auth()
{

return true;

}

/**
 * Renvoie le controlleur
 * @return controller
 */
function controller()
{

if (!$this->controller)
{
	$this->controller = $this->object("controller_id");
	$this->controller_params();
}

return $this->controller;

}

/**
 * Passage des paramètres au controlleur
 */
protected function controller_params()
{

$this->controller->header = array("title"=>$this->title, "description"=>$this->description);
foreach($this->params() as $name=>$value)
	$this->controller->params[$name] = $value;

}

public function submenu()
{

return $this->_manager()->select("parent_id='".$this->id."'");

}


}

?>