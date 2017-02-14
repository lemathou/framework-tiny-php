<?php

/**
 * Gestion Activités
 * @author mathieu
 * @package db_object
 *
 */
class activite_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_fields = array(
	"active" => array("label"=>"Actif", "type"=>"bool"),
	#"pos" => array("label"=>"Position sur l'accueil", "type"=>"int"),
	"cat_id" => array("label"=>"Rubrique", "type"=>"object", 'object_type'=>'cat'),
	"ref" => array("label"=>"Référence courte", "calculate"=>"ref:titre", "type"=>"string", "readonly"=>true),
	"url" => array("label"=>"Texte formaté pour URL", "calculate"=>"url:titre", "type"=>"string", "readonly"=>true),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"resume" => array("label"=>"Résumé", "type"=>"text"),
	"texte" => array("label"=>"Texte", "type"=>"richtext"),
	#"texte_rea" => array("label"=>"Intro réalisations", "type"=>"richtext"),
	#"intro" => array("label"=>"Intro accueil", "type"=>"text"),
	#"bandeau" => array("label"=>"Bandeau", "type"=>"select", "list"=>array("1"=>"Bleu", "2"=>"Bordeau", "3"=>"Vert", "4"=>"Gris")),
	#"color" => array("label"=>"Couleur", "type"=>"string"),
	"img"=>array("label"=>"Image", "type"=>"img", "folder"=>"img/activites", "filename"=>"{ref}.jpg", "notinsert"=>true),
);
public $_field_disp_list = array("active", "cat_id", "titre", 'resume');

}

/**
 * Activité
 * @author mathieu
 * @package db_object
 *
 */
class activite extends db_object
{

public function __tostring()
{

return (string)(($cat=$this->cat()) ?$cat.' : ' :'').$this->titre;

}

function cat()
{

return $this->object('cat_id');

}

}

