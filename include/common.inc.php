<?php

if (!mysql_connect(DB_HOST, DB_USER, DB_PASS))
	die("Erreur Connection MySQL");
elseif (!mysql_select_db(DB_BASE))
	die("Erreur Base de donnée : ".DB_BASE);
mysql_query("SET NAMES UTF8");

include "autoload.inc.php";
include "field.inc.php";
include "functions.inc.php";

session_start();

// Valeurs communes
commonval()->define();

if (isset($_POST["_login"]))
{
	//var_dump($_POST);
	if (isset($_POST["username"]) && is_string($_POST["username"]) && isset($_POST["password"]) && is_string($_POST["password"]))
	{
		$sql = "SELECT `id`, `email`, `type`, `nom` FROM `account` WHERE `email`='".mysql_real_escape_string($_POST["username"])."' AND MD5(`password`)='".mysql_real_escape_string($_POST["password"])."' AND actif=1";
		$q = mysql_query($sql);
		if (mysql_num_rows($q) == 1)
		{
			list($_SESSION["account_id"], $_SESSION["account_email"], $_SESSION["account_type"], $_SESSION["account_name"]) = mysql_fetch_row($q);
			//echo 'Connecté';
		}
		//echo $_SESSION["account_type"];
		//echo $sql;
	}
}
elseif (isset($_POST["_logout"]) && isset($_SESSION["account_id"]))
{
	unset($_SESSION["account_id"]);
	unset($_SESSION["account_email"]);
	unset($_SESSION["account_type"]);
	unset($_SESSION["account_name"]);
}

// Controlleurs
//controlleur()->select();

// Pages
page()->select();

// Activités
activite()->select();

// Réalisations
//realisation()->select();

