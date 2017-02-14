<?php

if (!defined('PATH_ROOT')){
        define("PATH_ROOT", realpath(dirname(__FILE__)));
        define("PATH_IMG", PATH_ROOT.'/img');
	define("PATH_CACHE", PATH_ROOT.'/cache/img');
}

define('IMG_CACHE_EXPIRES', 30*24*60*60); // 30 jours

$quality = 75;

$source = (isset($_GET["src"]) && is_string($_GET["src"])) ?$_GET["src"] :"";
$width = (isset($_GET["width"]) && is_string($_GET["width"])) ?$_GET["width"] :"";
$height = (isset($_GET["height"]) && is_string($_GET["height"])) ?$_GET["height"] :"";
$p = (isset($_GET["p"]) && is_string($_GET["p"])) ?$_GET["p"] :"";

// Vérif existance image à traiter
if (! $source || ! file_exists(PATH_IMG.'/'.$source))
	die();
$source_path = realpath(PATH_IMG.'/'.$source);
//var_dump($source_path); die();

//$source = realpath(PATH_IMG.'/'.$source);

// Chemin
$basename = basename($source);
list($nom, $ext) = explode(".", $basename);

// header standard pour la mise en cache
header("Cache-Control: max-age=2592000"); // 30 jours
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', ($time=time()) + IMG_CACHE_EXPIRES));

// Vérif date fichier
$last_modified_time = filemtime($source_path);
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
// header image
switch(strtolower($ext)) {
	case 'jpg':
		header('Content-Type: image/jpeg');
		break;
	case 'png':
		header('Content-Type: image/png');
		break;
	case 'gif':
		header('Content-Type: image/gif');
		break;
	default:
		break;
}

$cache_filename = PATH_CACHE.'/'.$width."x".$height."/".$source;
//echo $cache_filename; die();

// Flush headers
flush();

if (! $width && ! $height) {
	readfile($source_path);
	die();
}


// Vérif cache
$cache_test = PATH_CACHE.'/'.$width."x".$height;
if (!file_exists($cache_test))
	mkdir($cache_test);

$source_e = explode('/', dirname($source));
foreach($source_e as $i) {
	$cache_test .= "/".$i;
	if (!file_exists($cache_test))
		mkdir($cache_test);
	//echo $cache_test.'<br />';
}
if (file_exists($cache_filename) && filemtime($cache_filename)>=$last_modified_time) {
	//echo "yeah";
	readfile($cache_filename);
	die();
}

// Régénération image

switch(strtolower($ext)){
	case 'jpg':
		$src_img=imagecreatefromjpeg($source_path);
		break;
	case 'png':
		$src_img=imagecreatefrompng($source_path);
		break;
	case 'gif':
		$src_img=imagecreatefromgif($source_path);
		break;
	default:
		die();
		break;
}

//Taille de l'image originale
$w = imagesx($src_img);
$h = imagesy($src_img);
$r = $w/$h;

if ($width > $w)
	$width = $w;
if ($height > $h)
	$height = $h;

//Récupère les proportions
if ($width!="" && $height!="") {
	$ratio = $width/$height;
	
	$p = $width/$w;
	// width/height = w/h <=> height < width/r
	if ($ratio < $r){
		//
	}
	
	$imageInfo = array($width,$height);
	$default_size = 55;
	// On calcul la proportion pour afficher l'image
	if($imageInfo[0] > $imageInfo[1])
	{
		if($imageInfo[0] < $default_size)
		{
			$width = $default_size;
		}
		else
		{
			$width = $imageInfo[0];
		}
		$ratio = $width/$imageInfo[0];
		$height = $imageInfo[1] * $ratio;				
	}
	elseif($imageInfo[0] == $imageInfo[1])
	{
		if($imageInfo[0] < $default_size)
		{
			$width = $default_size;
			$height = $default_size;
		} 
		else 
		{
			$width = $imageInfo[0];
			$height = $imageInfo[1];
		}				
	}
	else
	{
		if($imageInfo[1] < $default_size)
		{
			$height = $default_size;	
		}
		else
		{
			$height = $imageInfo[1];	
		}			
		$ratio = $height/$imageInfo[1];
		$width = $imageInfo[0] * $ratio;
									
	}
}
elseif ($p!="") {
	$height = $p * $width;
}
elseif ($width) {
	$p = $h / $w;
	$height = $p * $width;
}
elseif ($height) {
	$p = $h / $w;
	$width = $height / $p;
}
else {
	$p = $h / $w;
	$width = $w;
	$height = $h;
}

if(strtolower($ext)!='gif'){
	$dst_img = imagecreatetruecolor($width, $height);
}
else{
	$color_transparent = imagecolortransparent($src_img);  
	if ($color_transparent > 0)
		$dst_img = imagecreate($width, $height);	
	else
		$dst_img = imagecreatetruecolor($width, $height);		
	imagepalettecopy($dst_img,$src_img);				
	if ($color_transparent > 0){
		imagefill($dst_img,0,0,$color_transparent);
	    imagecolortransparent($dst_img, $color_transparent);			
	}
}	

imagecopyresampled($dst_img,$src_img,0,0,0,0,$width,$height,$w,$h);
if(strtolower($ext)=='jpg')
	imagejpeg($dst_img, $cache_filename, $quality);
else if(strtolower($ext)=='png')	
	imagepng($dst_img, $cache_filename);
else if(strtolower($ext)=='gif')	
	imagegif($dst_img, $cache_filename);

readfile($cache_filename);

if($src_img)
	imagedestroy ($src_img);		
imagedestroy ($dst_img);
