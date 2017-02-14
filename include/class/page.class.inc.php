<?php

/**
 * Gestion pages
 * @author mathieu
 * @package db_object
 *
 */
class page_manager extends db_object_manager{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_fields = array(
	"controller_id" => array("label"=>"Controller", "type"=>"object", "object_type"=>"controller"),
	"ref" => array("label"=>"Référence courte", "type"=>"string", "readonly"=>true),
	"url" => array("label"=>"URL", "type"=>"string"),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"header_title" => array("label"=>"Titre HTML", "type"=>"string"),
	"header_description" => array("label"=>"Description HTML", "type"=>"text"),
	"params" => array("label"=>"Paramètres supplémentaires", "type"=>""),
);
public $_field_disp_list = array('controller_id', "ref", "titre");

protected function db_retrieve_more($list_id=null)
{

if (!is_array($list_id))
	return array();

$list = array();
$sql = "SELECT p.id, pp.name, pp.value
	FROM `controller_params` cp
	JOIN `page` p ON p.controller_id=cp.controller_id
	LEFT JOIN `page_params` pp ON pp.page_id=p.id AND pp.name=cp.name
	WHERE p.`id` IN (".implode(',', $list_id).")";
$q = mysql_query($sql);
while($row = mysql_fetch_assoc($q)){
	$list[$row['id']]['params'][$row['name']] = $row['value'];
	$list[$row['id']][$row['name']] = $row['value'];
}
//var_dump($list);
return $list;

}

}

class page extends db_object{

public $param_id;
public $params = array();

function __construct($id=null, $info=null){

if (!isset($info['params']) || !is_array($info['params']))
	$info['params'] = array();

parent::__construct($id, $info);

}

protected function db_update_more($info)
{

//var_dump($info);
//var_dump($this->params);

$fields = $this->controller()->fields;
if (! empty($_FILES['params'])) foreach($_FILES['params']['tmp_name'] as $name=>$value) {
	//echo $name;
	if ($value && isset($fields[$name]) && $fields[$name]['type']=='img')
		$info['params'][$name] = $value;
}
//var_dump($info);


if (!is_array($info))
	return false;

if (!isset($info['params']) || !count($info['params']))
	return false;

$fields = $this->controller()->fields;

$r = 0;
foreach ($info['params'] as $name=>$value){
	if (! isset($fields[$name]))
		continue;
	$field = $fields[$name];
	$options = json_decode($field['options'], true);
	if ($field['type']=='img') {
		//var_dump($options);
		$value = $options['filename'];
		//var_dump($_FILES);
		//echo 'From : '.$_FILES['params']['tmp_name'][$name]. ' to '.$value;
		move_uploaded_file($_FILES['params']['tmp_name'][$name], '../'.$value);
		//echo $value;
		//continue;
	}
	$sql = "REPLACE INTO `page_params`
		(`page_id`, `name`, `value`)
		VALUES ('$this->id', '$name', '".mysql_real_escape_string($value)."')";
	$q = mysql_query($sql);
	//echo "<p>$sql</p>";
	if ($error=mysql_error($q))
		echo "<p>$error : $sql</p>";
	$r += (mysql_affected_rows()>0 ?1 :0);
}

return $r>0 ?true :false;

}

function __tostring(){

return $this->title();

}

function controller(){

return $this->object('controller_id');

}

function params_set($params){

$controller = $this->controller();
$controller_fields = $controller->fields;

if (is_array($params)){
	foreach($params as $name=>$value) if (is_string($name) && isset($controller_fields[$name])){
		$this->params[$name] = $value;
	}
}

}

function param_set($param_id){

$this->param_id = $param_id;

$controller = $this->controller();
$controller_fields = $controller->fields;
foreach($controller_fields as $field) if ($field['url_get']){
	//var_dump($field);
	$this->params[$field['name']] = $param_id;
	break;
}

}

/**
 * Retrieve GET params
 */
function params_get(){

$this->params_set($_GET);

}

/**
 * Retrieve POST params
 */
function params_post(){

$this->params_set($_POST);

}

function title($param_id=null){

$param_id = is_array($param_id) ?current($param_id) :($param_id ?$param_id :$this->param_id);

if (!$param_id)
	return $this->titre;
else
	return $this->controller()->param_title($param_id);

}

function url($param_id=null){

$param_id = is_array($param_id) ?current($param_id) :($param_id ?$param_id :$this->param_id);

if (!$this->url)
	return '/';
elseif (!$param_id)
	return '/'.$this->url.'-'.$this->id.'.html';
else
	return '/'.$this->url.'-'.$this->id.'/'.$this->controller()->param_url($param_id).'.html';

}

function link($param_id=null){

$param_id = is_array($param_id) ?current($param_id) :($param_id ?$param_id :$this->param_id);
//var_dump($param_id);

return '<a href="'.$this->url($param_id).'">'.$this->title($param_id).'</a>';

}

function display(){

$controller = $this->controller();
$controller->page = $this;
//var_dump($controller);
$controller->display();

}

}

