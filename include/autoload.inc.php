<?php

$object_list = array(
	// Native
	//"db_object"=>array(),
	"menu"=>array(),
	"template"=>array(),
	"controller"=>array(),
	"page"=>array(),
	"commonval"=>array(),
	// Project
	"account"=>array(),
	"activite"=>array(),
	"realisation"=>array(),
	"actualite"=>array(),
	"evenement"=>array(),
	"cat"=>array(),
	"partenaire"=>array(),
	"miniature"=>array(),
);

// MANUAL ACCESSOR DEFINITION


// AUTOMATIC ACCESSOR DEFINITION

/**
 * Retrieve an objet defined
 *
 * @param string $t
 * @param int $params
 * @return db_object_manager|db_object|bool
 */
function object($t, $params=null)
{

	static $list;
	if (!$list)
		$list = $GLOBALS["object_list"];
	if (!is_string($t) || !isset($list[$t]))
		return;

	$p = &$list[$t];
	$n = "${t}_manager";
	$l = &$list[$n];

	// Object de gestion
	if (!isset($l))
	{
		if (!empty($p["cache"]) && ($object=apc_fetch($n)))
		{
			$l = $object;
		}
		else
		{
			$l = new $n();
			if (!empty($p["cache"]))
				apc_store($n, $l);
		}
	}

	// Renvoi de l'objet de gestion
	if ($params === null)
	{
		return $l;
	}
	// Renvoi si objet existant
	else
	{
		if ($object=$l->get($params))
			return $object;
		else
			return false;
	}

}

// Default definition of accessors
foreach($object_list as $name=>$i)
{
	if (!function_exists($name))
	{
		eval("function $name(\$params=null) { return object(\"$name\", \$params); }");
	}
}

/**
 * Autoload class function
 * @param string $class_name
 */
function __autoload($class_name)
{

if (!is_string($class_name))
	return;

if (substr($class_name, -11, 11) == "_controller"){
	if (file_exists($filename=PATH_ROOT."/include/controller/".substr($class_name, 0, -11).'.inc.php'))
		include $filename;
	else
		eval('class '.$class_name.' extends controller {}');
}
elseif ((substr($class_name, -8, 8) != "_manager" || ($class_name=substr($class_name, 0, -8))) && isset($GLOBALS["object_list"][$class_name])){
	if (file_exists($filename=PATH_ROOT."/include/class/$class_name.class.inc.php"))
		include $filename;
	elseif (file_exists($filename=PATH_ROOT."/include/model/$class_name.class.inc.php"))
		include $filename;
	else
		die('Model '.$class_name.' not found, file not found '.$filename);
}
elseif (file_exists($filename=PATH_ROOT."/include/class/$class_name.class.inc.php")){
	include $filename;
}
else{
	die('Class '.$class_name.' not found, file not found '.$filename);
}

}
