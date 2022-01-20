<?php

/**
 * Gestion Plantes
 * @author mathieu
 * @package db_object
 *
 */
class plante_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Plante";

public $_fields = array(
	"active" => array("label"=>"Actif", "type"=>"bool"),
	"cat_id" => array("label"=>"Rubrique", "type"=>"object", "object_type"=>"cat"),
	"ref" => array("label"=>"Référence courte", "type"=>"string", "calculate"=>"ref:titre", "readonly"=>true),
	"url" => array("label"=>"Texte pour URL", "type"=>"string", "calculate"=>"url:titre", "readonly"=>true),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"resume" => array("label"=>"Résumé", "type"=>"text"),
	"texte"=>array("label"=>"Contenu texte", "type"=>"richtext"),
	"img"=>array("label"=>"Image", "type"=>"img", "folder"=>"img/plante", "filename"=>"{ref}.jpg"),

);
public $_field_disp_list = array("titre");

}

/**
 * Plante
 * @author mathieu
 * @package db_object
 *
 */
class plante extends db_object
{

public function __tostring()
{

return (string)$this->titre;

}

}

