<?php

/*
 * Default classes
 */
$_object_list = array(
	"page"=>array(),
	"menu"=>array(),
	"controller"=>array(),
	"view"=>array(),
	"account"=>array(),
	"common"=>array()
);

// MANUAL ACCESSOR DEFINITION

/**
 * Database
 * @return db_manager
 */
function db()
{

static $db;
if (!$db)
	$db = new db_manager();

return $db;

}

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
		$list = array_merge($GLOBALS["_object_list"], $GLOBALS["_model_list"]);
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
foreach($_object_list as $name=>$i)
{
	if (!function_exists($name))
	{
		eval("function $name(\$params=null) { return object(\"$name\", \$params); }");
	}
}
foreach($_model_list as $name=>$i)
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

if ((substr($class_name, -8, 8) != "_manager" || ($class_name=substr($class_name, 0, -8))) && isset($GLOBALS["_object_list"][$class_name]))
	include CLASS_DIR."/$class_name.class.inc.php";
elseif ((substr($class_name, -8, 8) != "_manager" || ($class_name=substr($class_name, 0, -8))) && isset($GLOBALS["_model_list"][$class_name]))
	include MODEL_DIR."/$class_name.class.inc.php";
elseif (file_exists($filename=CLASS_DIR."/$class_name.class.inc.php"))
	include $filename;

}

?>