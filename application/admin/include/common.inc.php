<?php

$admin_menu_list = array("account"=>"Comptes utilisateur", "page"=>"Pages", "activite"=>"Activités", "realisation"=>"Réalisations");
$menu_ref = "";

if (!isset($_GET["menu"]) || !is_string($menu_ref=$_GET["menu"]) || !isset($admin_menu_list[$menu_ref]))
	$menu_ref = "acceuil";

?>
