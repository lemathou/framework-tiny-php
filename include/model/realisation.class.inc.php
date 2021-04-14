<?php

/**
 * Gestion Réalisations
 * @author mathieu
 * @package db_object
 *
 */
class realisation_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Réalisation";

public $_fields = array(
	"afficher" => array("label"=>"Affiché", "type"=>"bool"),
	"activite_id" => array("label"=>"Activité", "type"=>"object", "object_type"=>"activite"),
	"ref" => array("label"=>"Référence courte", "type"=>"string", "readonly"=>true),
	"url" => array("label"=>"Texte pour URL", "type"=>"string"),
	"titre" => array("label"=>"Titre", "type"=>"string"),
	"header_title" => array("label"=>"Titre header html", "type"=>"text"),
	"header_description" => array("label"=>"Description header html", "type"=>"text"),
	"texte"=>array("label"=>"Contenu texte", "type"=>"richtext"),
	"img1"=>array("label"=>"Image 1", "type"=>"img", "folder"=>"images/Realisations", "filename"=>"{ref}.jpg"),
	"img2"=>array("label"=>"Image 2", "type"=>"img", "folder"=>"images/Realisations", "filename"=>"{ref}-2.jpg"),
	"img3"=>array("label"=>"Image 3", "type"=>"img", "folder"=>"images/Realisations", "filename"=>"{ref}-3.jpg")
);
public $_field_disp_list = array("titre", "activite_id");

}

/**
 * Réalisation
 * @author mathieu
 * @package db_object
 *
 */
class realisation extends db_object
{

public function __tostring()
{

return (string)$this->titre;

}

public function activite(){

return $this->object('activite_id');

}

}

