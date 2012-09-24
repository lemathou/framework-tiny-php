<?php

class common_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

public $_db_id = "ref";

public $_fields = array(
	"name" => array("label"=>"Nom", "type"=>"string"),
	"type" => array("label"=>"Type de donnée", "type"=>"string"),
	"options" => array("label"=>"Options", "type"=>"text"),
	"description" => array("label"=>"Description", "type"=>"text"),
	"value" => array("label"=>"Valeur", "type"=>"text"),
);
public $_field_disp_list = array("description", "value");
public $_field_select_list = array("description");
public $_field_query_list = array("titre");

public function test_id($id)
{

return is_string($id);

}

public function load()
{

foreach($this->select() as $param)
{
	define($param->id, $param->value);
}

}

}

class common extends db_object
{

function __tostring()
{

return (string)$this->id;

}

}

?>