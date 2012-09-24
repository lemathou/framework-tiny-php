<?php

$list = array(
	"page_common" => array(
		"reset",
		"general",
		"gestion_payement",
		"jqmodal",
		"menutop",
		"socialbar",
		"",
		""
	)
);

header("Content-Type: text/css");
header("Cache-Control: public, must-revalidate, max-stale=".CSS_CACHE_TTL_MIN.", max-age=".CSS_CACHE_EXPIRES);

if (!isset($_GET["file"]) || !is_string($file=$_GET["file"]))
	die();

if (isset($list[$file]))
{

$contents = "";
$update_timestamp = 0;
foreach($list[$file] as $filename)
{
	$filename = "css/".$filename.".css";
	if (file_exists($filename))
	{
		$u = filemtime($filename);
		if ($update_timestamp < $u)
			$update_timestamp = $u;
		$contents .= file_get_contents($filename)."\n\n";
	}
	else
	{
		//die("Manque $filename");
	}
}
header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $update_timestamp));
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + CSS_CACHE_EXPIRES));
flush();

echo $contents;

}
elseif (file_exists($filename = "css/".$file.".css"))
{

$update_timestamp = filemtime($filename);
header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $update_timestamp));
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + CSS_CACHE_EXPIRES));
flush();

echo file_get_contents($filename);

}

?>