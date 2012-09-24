<?php

class account_manager extends db_object_manager
{

//public $DB_DEBUG = false;
//public $FILE_DEBUG = false;

//public $_db_id = "id";

public $_fields = array(
	"email" => array("label"=>"Adresse électronique", "type"=>"string"),
	"password" => array("label"=>"Mot de passe", "type"=>"password"),
	"type" => array("label"=>"Type de compte", "type"=>"select", "list"=>array("admin"=>"Administrateur", "redac"=>"Rédacteur", "user"=>"Associé", "client"=>"Client")),
	"name" => array("label"=>"Titulaire du compte", "type"=>"string"),
);
public $_field_disp_list = array("titre");
public $_field_select_list = array("titre");
public $_field_query_list = array("titre");

}

class account extends db_object
{

function __tostring()
{

return (string)$this->name;

}

}

?>