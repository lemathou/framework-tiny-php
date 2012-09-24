<?php

include "config.inc.php";
include INCLUDE_DIR."/common.inc.php";

$page_list = array();

header("Content-type: application/xml; charset=utf-8");

ob_start();

echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
	<loc>http://<?php echo DOMAIN; ?></loc>
</url>
<?php
foreach($page_list as $type=>$info)
{
?>
<url>
	<loc>http://<?php echo NOM_DOM_2; ?>/<?php echo $info["url"]; ?>.html</loc>
</url>
<?php
}
?>
</urlset>
<?php
/*
fwrite(fopen("sitemap.xml", "w"), ob_get_contents());
ob_end_clean();
header("location: /sitemap.xml");
die();
*/
ob_end_flush();
?>
