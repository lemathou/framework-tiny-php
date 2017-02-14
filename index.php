<?php

include "config/config.inc.php";
include "include/common.inc.php";

error_reporting(-1);
ini_set('display_errors', true);

//var_dump($_GET);

if (!isset($_GET["_page_id"]) || !is_numeric($page_id=$_GET["_page_id"]) || !($page_controller=page()->get($page_id)))
	$page_controller = page()->get(1);

//var_dump($page_controller);

if (isset($_GET["_param_id"]) && is_numeric($param_id=$_GET["_param_id"]))
	$page_controller->param_set($param_id);

// Récupère les éléments passés par GET
$page_controller->params_get();

$page_controller->display();

