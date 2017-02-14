<?php

/**
 * Gestion des valeurs communes au site (converties en constantes)
 * @author mathieu
 * @package db_object
 *
 */
class commonval_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_fields = array(
	"name" => array("label"=>"Nom", "type"=>"string", "readonly"=>true),
	"description" => array("label"=>"Description", "type"=>"string"),
	"commentaire" => array("label"=>"Commentaire", "type"=>"text"),
	"type" => array("label"=>"Type", "type"=>"select", "list"=>array('int'=>"Nombre entier", 'float'=>"Nombre à virgule", 'object'=>"Objet", 'text'=>"Texte", 'textarea'=>"Texte long", 'richtext'=>"Texte enrichi", 'img'=>"Image", 'select'=>"Sélection parmis une liste")),
	"options" => array("label"=>"Options", "type"=>"text"),
	"value"=>array("label"=>"Valeur", "type"=>"text"),
);
public $_field_disp_list = array("name", "description", "value");

public function define(){
	foreach($this->select() as $o){
		if ($o->name && !defined($name=strtoupper($o->name)))
			define($name, $o->value);
	}
}

}

/**
 * Valeurs communes
 * @author mathieu
 * @package db_object
 *
 */
class commonval extends db_object
{

public function __tostring()
{

return (string)$this->name;

}

}

