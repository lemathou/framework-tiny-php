<?php

class intranet_controller extends controller{

function view(){

if (!isset($_SESSION["account_id"]) || !in_array($_SESSION["account_type"], array("admin","user")))
	$subtemplate = "unauth";

global $subtemplate;

}

}

