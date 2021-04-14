<?php

function date_fr2en($date)
{
	$e = explode("/", $date);
	$e = array_reverse($e);
	return implode("-", $e);
}

function date_en2fr($date)
{
	$e = explode("-", $date);
	$e = array_reverse($e);
	return implode("/", $e);
}

function date_mysql($date){
        $d = explode(' ', $date);
        $d[0] = implode('/', array_reverse(explode('-', $d[0])));
        return implode(' ', $d);
}

function header_desc_format($string){
        return str_replace('"', "'", $string);
}

function stripAccents($string){
        return str_replace(
                array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý'),
                array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y'),
                $string
        );
        return strtr(
                $string,
                'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
                'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
}

