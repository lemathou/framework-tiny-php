<?php

include "../config/config.inc.php";
include "../include/common.inc.php";
include "include/common.inc.php";

?>
<html>
<head>
<?php
include "template/inc/header.tpl.php";
?>
</head>
<body>
<?php
// Aff
if (isset($_SESSION["account_id"]) && $_SESSION["account_type"] == "admin")
{

$menu_ref = "realisation";
include "template/inc/menu.tpl.php";

$classname = "realisation";
include "include/actions.inc.php";
include "template/form/db_object.tpl.php";

}
else
{

include "template/page/login.tpl.php";

}

?>
</body>
</html>
