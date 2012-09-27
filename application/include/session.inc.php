<?php

session_start();

if (isset($_POST["_login"]))
{
	if (isset($_POST["username"]) && is_string($_POST["username"]) && isset($_POST["password"]) && is_string($_POST["password"]))
	{
		$qs = "SELECT `id`, `email`, `type`, `name` FROM `account` WHERE `email`='".db()->escape_string($_POST["username"])."' AND MD5(`password`)='".db()->escape_string($_POST["password"])."'";
		$q = db()->select($qs);
		if ($q->num_rows() == 1)
		{
			list($_SESSION["account_id"], $_SESSION["account_email"], $_SESSION["account_type"], $_SESSION["account_name"]) = $q->fetch_row();
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