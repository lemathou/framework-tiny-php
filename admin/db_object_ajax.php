<?php

include "../config/config.inc.php";
include "../include/common.inc.php";

session_start();

if (!isset($_SESSION["account_id"]) || $_SESSION["account_type"] != "admin")
	die();

//var_dump($_POST);

if (!isset($_POST["classname"]) || !is_string($classname=$_POST["classname"]) || !isset($object_list[$_POST["classname"]]))
	die("Mauvais type d'objet");
if (!isset($_POST["q"]) || !is_string($q=$_POST["q"]))
	die("No query");
if (!isset($_POST["fieldname"]) || !is_string($_POST["fieldname"]))
	$_POST["fieldname"] = "id";
if (!isset($_POST["param"]) || !is_array($_POST["param"]))
	$_POST["param"] = array();

// Paramètres de la requête
$params = null;
switch($classname)
{
	case "marque";
		$params = "nom LIKE '%".mysql_real_escape_string($q)."%'";
		break;
}

// Comptage
if (($num=$classname()->count($params)) == 0)
	die("<i>Aucun résultat</i>");
// Limite
if (isset($_GET["limit"]) && is_numeric($_GET["limit"]) && $_GET["limit"] > 0)
	$nbmax = (int)$_GET["limit"];
else
	$nbmax = 0;

// Affichage
?>
<select name="<?php echo $_POST["fieldname"]; ?>"<?php if (isset($_POST["autosubmit"])) echo " onchange=\"this.form.submit()\""; ?>><option value="">-<?php if ($nbmax && $num>$nbmax) echo "- ($nbmax premiers / $num total) -"; ?>-</option><?php
foreach($classname()->select($params, $nbmax) as $object)
{
	echo "<option value=\"".$object->id."\" title=\"".$object."\">".$object."</option>";
}
if ($nbmax && $num > $nbmax)
	echo "<option value=\"\">...</option>";
?></select><?php if (isset($_POST["submitbutton"])) { ?><input type="submit" value="Choisir" /><?php } ?>
