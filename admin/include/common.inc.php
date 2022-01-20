<?php

$admin_menu_list = array(
	"commonval"=>array('label'=>"Registre", 'perms'=>array('root', 'admin')),
	"controller"=>array('label'=>"Controlleurs", 'perms'=>array('root')),
	"template"=>array('label'=>"Templates", 'perms'=>array('root')),
	"page"=>array('label'=>"Pages", 'perms'=>array('root', 'admin')),
	"menu"=>array('label'=>"Menus", 'perms'=>array('root', 'admin')),

	"account"=>array('label'=>"Comptes utilisateur", 'perms'=>array('root', 'admin')),

	"activite"=>array('label'=>"Activités", 'perms'=>array('root', 'admin', 'user')),
	//"realisation"=>array('label'=>"Réalisations", 'perms'=>array('root', 'admin', 'user')),
	"actualite"=>array('label'=>"Actualités", 'perms'=>array('root', 'admin', 'user')),
	"evenement"=>array('label'=>"Evénements", 'perms'=>array('root', 'admin', 'user')),
	"cat"=>array('label'=>"Rubriques", 'perms'=>array('root', 'admin', 'user')),
	"partenaire"=>array('label'=>"Partenaires", 'perms'=>array('root', 'admin', 'user')),
	"miniature"=>array('label'=>"Miniatures", 'perms'=>array('root', 'admin', 'user')),
	"plante"=>array('label'=>"Plantes", 'perms'=>array('root', 'admin', 'user')),
);
$menu_ref = "";

if (!isset($_GET["menu"]) || !is_string($menu_ref=$_GET["menu"]) || !isset($admin_menu_list[$menu_ref]))
	$menu_ref = "acceuil";

