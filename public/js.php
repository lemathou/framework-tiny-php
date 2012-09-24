<?php

include "config.inc.php";

$list = array(
	"page_common" => array(
		"front.min",
		"ajax2.min",
		"jquery-1.3.1.min",
		"jquery.alphanumeric.min",
		"jqDnr.min",
		"jqModal.min",
		"gestion_panier.min",
		"date.min",
		"jquery.datePicker.min",
		"jquery.mousewheel.min",
		"jquery.jScrollPane.min",
		"js",
		"menutop",
		"socialbar"
	)
);

if (!isset($_GET["file"]) || !is_string($file=$_GET["file"]))
	die();

if (isset($list[$file]))
{

header("Content-Type: application/javascript");
header("Cache-Control: public, must-revalidate, max-stale=".JS_CACHE_TTL_MIN.", max-age=".JS_CACHE_EXPIRES);

$contents = "";
$update_timestamp = 0;
foreach($list[$file] as $filename)
{
	$filename = "js/".$filename.".js";
	if (file_exists($filename))
	{
		$u = filemtime($filename);
		if ($update_timestamp < $u)
			$update_timestamp = $u;
		$contents .= file_get_contents($filename)."\n\n";
	}
	else
	{
		die("Manque $filename");
	}
}
header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $update_timestamp));
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + JS_CACHE_EXPIRES));
flush();

echo $contents;

}
elseif (file_exists($filename = "js/".$file.".js"))
{

$update_timestamp = filemtime($filename);
header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $update_timestamp));
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + JS_CACHE_EXPIRES));
flush();

echo file_get_contents($filename);


}

?>