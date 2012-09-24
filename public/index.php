<?php

include "config.inc.php";
include INCLUDE_DIR."/include/common.inc.php";

// Page
if (!isset($_GET["page_id"]) || !($page=page()->get($_GET["page_id"])))
	$page = page()->get(PAGE_DEFAULT_ID);

// Controlleur de la page
$controller = $page->controller();
$controller->action();

?>