<?php

session_start();

if (isset($_POST["_login"]))
{
	if (isset($_POST["username"]) && is_string($_POST["username"]) && isset($_POST["password"]) && is_string($_POST["password"]))
	{
		$q = "SELECT `id`, `email`, `type`, `nom` FROM `account` WHERE `email`='".mysql_real_escape_string($_POST["username"])."' AND `password`='".mysql_real_escape_string($_POST["password"])."'";
		$query = db()->select($q);
		if (mysql_num_rows($query) == 1)
		{
			list($_SESSION["account_id"], $_SESSION["account_email"], $_SESSION["account_type"], $_SESSION["account_name"]) = mysql_fetch_row($query);
		}
	}
}
elseif (isset($_POST["_logout"]) && isset($_SESSION["account_id"]))
{
	unset($_SESSION["account_id"]);
	unset($_SESSION["account_email"]);
	unset($_SESSION["account_type"]);
	unset($_SESSION["account_name"]);
}

?>