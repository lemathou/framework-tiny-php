<?php

/**
 * Gestion templates
 * @author mathieu
 * @package db_object
 *
 */
class template_manager extends db_object_manager{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Template";

public $_fields = array(
	"ref" => array("label"=>"Référence courte", "type"=>"string", "readonly"=>true),
	"ref_right" => array("label"=>"Référence courte droite", "type"=>"string"),
	"ref_left" => array("label"=>"Référence courte gauche", "type"=>"string"),
	"ref_footer" => array("label"=>"Référence courte footer", "type"=>"string"),
	"description" => array("label"=>"Description", "type"=>"text"),
	"css" => array("label"=>"js", "type"=>"string"),
	"js" => array("label"=>"css", "type"=>"string"),
	//"params" => array("label"=>"Paramètres supplémentaires", "type"=>""),
);
public $_field_disp_list = array("ref", "css", "js");

}

class template extends db_object{

public $controller;
public $page;

public $layout;
public $template;
public $menutop;
public $header = array('js'=>array(), 'css'=>array());

public $params = array();

public function __tostring(){
	return $this->ref;
}

public function __construct($id=null, $info=null){

return parent::__construct($id, $info);

}

/**
 * Menus
 */
public function menu(){

$menutop = array();
$sql = "SELECT m.*
	FROM `menu` m
	JOIN `page` p ON p.`id`=m.`page_id`
	JOIN `controller` c ON c.`id`=p.`controller_id`
	WHERE m.`visible`=1
	ORDER BY m.`parent_id`, m.`pos`";
$q = mysql_query($sql);
//echo mysql_error();
$row_parent = array();
while($row=mysql_fetch_assoc($q)){
	$row['smenu'] = array();
	$row['params'] = array();
	if ($row["parent_id"]){
		if (isset($menutop[$row["parent_id"]])){
			$row_parent[$row["id"]] = $row["parent_id"];
			$menutop[$row["parent_id"]]["smenu"][$row["id"]] = $row;
		}
		// Pas de parent actif : on affiche pas
		else{
		}
	}
	else{
		$menutop[$row["id"]] = $row;
	}
}

$sql = "SELECT * FROM `menu_params` WHERE `value` IS NOT NULL";
$q = mysql_query($sql);
while($row=mysql_fetch_assoc($q)){
	if(isset($row_parent[$row['menu_id']]))
		$menutop[$row_parent[$row['menu_id']]]['smenu'][$row['menu_id']]['params'][$row['name']] = $row['value'];
	elseif(isset($menutop[$row['menu_id']]))
		$menutop[$row['menu_id']]['params'][$row['name']] = $row['value'];
}
//var_dump($menutop);

$this->menutop = $menutop;

}

public function view_before(){

$this->header['js'] = array_merge($this->header['js'], explode(',', $this->js));
$this->header['css'] = array_merge($this->header['css'], explode(',', $this->css));

//echo $this->css;
//var_dump(explode(',', $this->css));

$this->menu();

}

public function view(){
}

public function view_after(){
}

public function display(){

$this->view_before();
$this->view();
$this->view_after();

//var_dump($this->params);
extract($this->params);

if (file_exists($filename = PATH_TEMPLATE.'/'.$this->layout.'.tpl.php'))
	include $filename;
else
	die('Layout '.$filename.' introuvable');

}

}

