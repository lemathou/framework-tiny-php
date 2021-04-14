<?php

/**
 * Gestion Evénements
 * @author mathieu
 * @package db_object
 *
 */
class evenement_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_fields = array(
	"active" => array("label"=>"Actif", "type"=>"bool"),
	"cat_id" => array("label"=>"Rubrique", "type"=>"object", "object_type"=>"cat"),
	"ref" => array("label"=>"Référence courte", "type"=>"string", "calculate"=>"ref:titre", "readonly"=>true),
	"url" => array("label"=>"Texte pour URL", "type"=>"string", "calculate"=>"url:titre", "readonly"=>true),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"resume" => array("label"=>"Résumé", "type"=>"text"),
	"texte" => array("label"=>"Contenu texte", "type"=>"richtext"),
	"date_affiche" => array("label"=>"Date debut affichage", "type"=>"date"),
	"date_debut" => array("label"=>"Date debut", "type"=>"date"),
	"date_fin" => array("label"=>"Date fin", "type"=>"date"),
	"dates" => array("label"=>"Dates", "type"=>"text"),
	"img"=>array("label"=>"Image", "type"=>"img", "folder"=>"img/evenements", "filename"=>"{ref}.jpg"),
	"pdffile"=>array("label"=>"PDF", "type"=>"file", "folder"=>"docs/evenements", "filename"=>"{ref}.pdf"),
);
public $_field_disp_list = array("active", "cat_id", "titre", 'resume');

}

/**
 * Evénement
 * @author mathieu
 * @package db_object
 *
 */
class evenement extends db_object
{

public function __tostring()
{

return (string)(($cat=$this->cat()) ?$cat.' : ' :'').$this->titre;

}

function cat(){

return $this->object('cat');

}

}

