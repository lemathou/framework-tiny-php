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
if (isset($_SESSION["account_id"]) && in_array($_SESSION["account_type"], array('root', 'admin', 'user')))
{

include "template/inc/menu.tpl.php";
include "template/page/accueil.tpl.php";

}
else
{

include "template/page/login.tpl.php";

}

?>
</body>
</html>
