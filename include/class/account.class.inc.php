<?php

/**
 * Gestion comptes
 * @author mathieu
 * @package db_object
 *
 */
class account_manager extends db_object_manager
{

public $DB_DEBUG = false;
public $FILE_DEBUG = false;

public $_fields = array(
	"type" => array("label"=>"Type", "type"=>"select", "list"=>array("admin"=>"Administrateur", "user"=>"Utilisateur", "client"=>"Client")),
	"nom" => array("label"=>"Nom", "type"=>"string"),
	"email" => array("label"=>"Email", "type"=>"string"),
	"password" => array("label"=>"Mot de passe", "type"=>"password"),
	"actif" => array("label"=>"Actif", "type"=>"bool"),
);
public $_field_disp_list = array("type", "nom", "email", 'actif');

}

/**
 * Activité
 * @author mathieu
 * @package db_object
 *
 */
class account extends db_object
{

public function __tostring()
{

return (string)$this->nom;

}

}

?>
