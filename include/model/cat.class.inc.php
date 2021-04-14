<?php

/**
 * Gestion Rubriques/Catégories
 * @author mathieu
 * @package db_object
 *
 */
class cat_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Catégorie";

public $_fields = array(
	"active" => array("label"=>"Actif", "type"=>"bool"),
	"ref" => array("label"=>"Référence courte", "type"=>"string", "calculate"=>"ref:titre", "readonly"=>true),
	"url" => array("label"=>"Texte formaté pour URL", "type"=>"string", "calculate"=>"url:titre", "readonly"=>true),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"resume" => array("label"=>"Résumé", "type"=>"text"),
	"description" => array("label"=>"Texte", "type"=>"text"),
);
public $_field_disp_list = array("titre");

}

/**
 * Rubrique/Catégorie
 * @author mathieu
 * @package db_object
 *
 */
class cat extends db_object
{

public function __tostring()
{

return (string)$this->titre;

}

}

