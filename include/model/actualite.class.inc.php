<?php

/**
 * Gestion Actualités
 * @author mathieu
 * @package db_object
 *
 */
class actualite_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Actualité";

public $_fields = array(
	"active" => array("label"=>"Actif", "type"=>"bool"),
	"cat_id" => array("label"=>"Rubrique", "type"=>"object", 'object_type'=>'cat'),
	"datetime" => array("label"=>"Date", "type"=>"timestamp"),
	"ref" => array("label"=>"Référence courte", "calculate"=>"ref:titre", "type"=>"string", "readonly"=>true),
	"url" => array("label"=>"Texte pour URL", "calculate"=>"url:titre", "type"=>"string", "readonly"=>true),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"resume" => array("label"=>"Résumé", "type"=>"text"),
	"texte" => array("label"=>"Contenu texte", "type"=>"richtext"),
	"img"=>array("label"=>"Image", "type"=>"img", "folder"=>"img/actualites", "filename"=>"{ref}.jpg", "notinsert"=>true),
);
public $_field_disp_list = array("active", "cat_id", "titre", 'resume');

}

/**
 * Actualité
 * @author mathieu
 * @package db_object
 *
 */
class actualite extends db_object
{

public function __tostring()
{

return (string)(($cat=$this->cat()) ?$cat.' : ' :'').$this->titre;

}

function cat(){

return $this->object('cat');

}

}

