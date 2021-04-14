<?php

/**
 * Gestion Partenaires
 * @author mathieu
 * @package db_object
 *
 */
class partenaire_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_label = "Partenaire";

public $_fields = array(
	"active" => array("label"=>"Actif", "type"=>"bool"),
	"cat_id" => array("label"=>"Rubrique", "type"=>"object", 'object_type'=>'cat'),
	"ref" => array("label"=>"Référence courte", "type"=>"string", "calculate"=>"ref:nom", "readonly"=>true),
	"url" => array("label"=>"Texte formaté pour URL", "type"=>"string", "calculate"=>"url:nom", "readonly"=>true),
	"nom" => array("label"=>"Titre", "type"=>"string"),
	"website" => array("label"=>"Site Internet", "type"=>"string"),
	"resume" => array("label"=>"Résumé", "type"=>"text"),
	"description" => array("label"=>"Texte", "type"=>"richtext"),
	"url_retour" => array("label"=>"URL de retour pour l'échange", "type"=>"string"),
);
public $_field_disp_list = array("active", "cat_id", "nom");

}

/**
 * Partenaire
 * @author mathieu
 * @package db_object
 *
 */
class partenaire extends db_object
{

public function __tostring()
{

return (string)$this->nom;

}

public function link($label=null, $target=null)
{

return '<a href="'.(substr($this->website, 0, 4)!='http' ?'http://' :'').$this->website.'"'.(is_string($target) ?' target="'.$target.'"' :'').'>'.(is_string($label) ?$label :$this->nom).'</a>';

}

function cat()
{

return $this->object('cat_id');

}

}

