<?php

class contact_controller extends controller{

function view(){

$form = array("nom"=>"", "prenom"=>"", "adresse"=>"", "cp"=>"", "ville"=>"", "tel"=>"", "email"=>"", "objet"=>"", "message"=>"");
$form_required = array("nom", "prenom", "ville", "tel", "email", "objet", "message");
$form_email = array("nom"=>"Nom", "prenom"=>"Prénom", "adresse"=>"ADresse", "cp"=>"Code postal", "ville"=>"Ville", "tel"=>"Téléphone", "email"=>"eMail", "objet"=>"Objet", "message"=>"Message");

// Assignation POST
foreach($_POST as $i=>$j)
	if (isset($form[$i]) && is_string($j))
		$form[$i] = $j;

// Submit
if (isset($_POST["_contact"]))
{
	$form["_submitted"] = true;

	// Captcha
	if (isset($form["_submitted"]) && (!isset($_POST["_captcha"]) || $_POST["_captcha"] != $_SESSION["captcha"]))
		$form["_message"] = "Le code de sécurité que vous avez saisi est invalide (".$_POST["_captcha"]." au lieu de ".$_SESSION["captcha"].")";
	
	// Vérif email
	if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/", $form["email"]))
	{
		$form["_message"] = "L'adresse email que vous avez saisie n'est pas valide";
	}
	
	// Champs remplis
	foreach($form_required as $i)
	{
		if (!$form[$i])
		{
			$form["_message"] = "Veuillez compléter l'ensemble des champs requis";
		}
	}
	
	// Envoi
	if (!isset($form["_message"]))
	{
		$message_header = "Content-Type: text/plain; charset=utf-8\r\nFrom: ".$form["prenom"]." ".$form["nom"]." <".$form["email"].">\r\n";
		$message = "";
		foreach($form_email as $i=>$j)
			$message .= "$j : ".$form[$i]."\r\n";
		if (mail($page["form_email"], "Message en provenance du site Internet", $message, $message_header))
		{
			$form["_message"] = "Votre message nous a bien été transmis.";
			// Sppression des informations
			foreach($form_email as $i=>$j)
				$form[$i] = "";
			unset($form["_submitted"]);
		}
		else
		{
			$form["_message"] = "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer ultérieurement";
		}
	}	
}

$this->params['form'] = $form;

}

}
