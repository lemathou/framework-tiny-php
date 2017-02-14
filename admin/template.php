<?php

include "../config/config.inc.php";
include PATH_ROOT."/include/common.inc.php";
include "include/common.inc.php";

$menu_ref = "template";
$menu = $admin_menu_list[$menu_ref];

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
if (isset($_SESSION["account_id"]) && in_array($_SESSION["account_type"], $menu['perms']))
{

include "template/inc/menu.tpl.php";

$classname = "template";
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
