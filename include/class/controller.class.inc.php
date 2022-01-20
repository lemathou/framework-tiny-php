<?php

/**
 * Gestion controller
 * @author mathieu
 * @package db_object
 *
 */
class controller_manager extends db_object_manager{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;


public $_label = "Controlleur";

public $_fields = array(
	"ref" => array("label"=>"Référence courte", "type"=>"string", "readonly"=>true),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"description" => array("label"=>"Description", "type"=>"text"),
	"template_layout" => array("label"=>"Layout", "type"=>"string"),
	//"template_left_id" => array("label"=>"Template gauche", "type"=>"object", 'object_type'=>'template'),
	//"template_right_id" => array("label"=>"Template droit", "type"=>"object", 'object_type'=>'template'),
	"template_id" => array("label"=>"Template central", "type"=>"object", 'object_type'=>'template'),
	"fields" => array("label"=>"Champs supplémentaires", "type"=>""),
);
public $_field_disp_list = array("ref", "titre");

/**
 * Select en base de donnée
 * @param [] $params
 * @param int $limit
 * @param string $order
 * @return []
 */
public function select($params=null, $limit=null, $order=null)
{

$list = array();
foreach ($this->db_retrieve($params, $limit, $order) as $row)
{
	if (!isset($this->list[$row["id"]])){
		$classname = $row['ref'].'_controller';
		$this->list[$row["id"]] = $object = new $classname(null, $row);
	}
	else
		$object = $this->list[$row["id"]];
	$list[] = $object;
}

return $list;

}

protected function db_retrieve_more($list_id=null)
{

if (!is_array($list_id))
	return array();

$list = array();
$sql = "SELECT * FROM `controller_params` WHERE `controller_id` IN (".implode(',', $list_id).")";
$q = mysql_query($sql);
while($row = mysql_fetch_assoc($q))
	$list[$row['controller_id']]['fields'][$row['name']] = $row;

//var_dump($list);
return $list;

}

}

class controller extends db_object{

public $_name = 'controller';

public $fields = array();

//public $values = array();
public $page = null;
public $params = array();
public $header = array();

function __tostring(){
	return $this->titre;
}

function template(){

return $this->object('template_id');

}

function param_url($id){

return "paramurl-$id";

}

function param_title($id){

return "paramtitle-$id";

}

function error404()
{
	$page = new page(32);
        $page->display();
        die();
}

/**
 * Mise en place des éléments communs au template
 */
function view_before(){

// Header
$this->header = array(
	"title"=>$this->page->header_title,
	"description"=>$this->page->header_description,
	"url"=>$this->page->url(),
);

}

/**
 * Mise en place des éléments du template
 * A surcharger
 */
function view(){
}

/**
 * Mise en place des éléments communs au template
 */
function view_after(){

}

/**
 * Affichage de la page
 */ 
function display(){

$this->params = $this->page->params;

$this->view_before();
$this->view();
$this->view_after();

//var_dump($this->template_id);
$template = $this->template();
$template->controller = $this;
$template->page = $this->page;

$template->params = array_merge($template->params, $this->params);
$template->layout = $this->template_layout;
$template->header = array_merge($template->header, $this->header);

//var_dump($template);
$template->display();

}

}

