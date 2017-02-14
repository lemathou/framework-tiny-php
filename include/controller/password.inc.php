<?php

class password_controller extends controller{

function view(){

$form = array("email"=>"", "message"=>"", "form_aff"=>true);

if (isset($_POST["_password"]))
{
	if (!isset($_POST["email"]) || !is_string($_POST["email"]) || !$_POST["email"])
	{
		$form["message"] = "Adresse email invalide";
	}
	elseif (!isset($_POST["_captcha"]) || !isset($_SESSION["captcha"]) || $_POST["_captcha"] != $_SESSION["captcha"])
	{
		$form["message"] = "Code de sécurité Captcha invalide";
		$form["email"] = $_POST["email"];
	}
	else
	{
		$q_s = "SELECT `password` FROM account WHERE email='".mysql_real_escape_string($_POST["email"])."'";
		$q_r = mysql_query($q_s);
		unset($_SESSION["captcha"]);
		if (list($password)=mysql_fetch_row($q_r))
		{
			mail($_POST["email"], "Votre mot de passe sur le site D2P", "Votre mot de passe sur le site D2P est :\r\n  * $password\r\n", "From: ".$this->params["email_from"]);
			$form["message"] = "Votre mot de passe vient de vous être renvoyé par email";
			$form["form_aff"] = false;
		}
		else
		{
			$form["message"] = "Adresse email invalide";
	                $form["email"] = $_POST["email"];
		}
	}
}

//var_dump($form);

$this->params['form'] = $form;

}

}

