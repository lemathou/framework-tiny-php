<?php

//var_dump($_POST);

if (!isset($classname))
	die("Paramètres requis");

if (isset($_POST["_update"]))
{
	if (isset($_POST["id"]) && is_numeric($_POST["id"]) && ($object=$classname()->get($_POST["id"])))
	{
		$object->update($_POST);
	}
}
elseif (isset($_POST["_delete"]))
{
	if (isset($_POST["id"]) && is_numeric($_POST["id"]) && ($object=$classname()->get($_POST["id"])))
	{
		$object->delete();
		$_GET = array("list"=>"");
	}
}
elseif (isset($_GET["delete_id"]))
{
	if (is_numeric($_GET["delete_id"]) && ($object=$classname()->get($_GET["delete_id"])))
	{
		$object->delete();
		$_GET = array("list"=>"");
	}
}
elseif (isset($_POST["_insert"]))
{
	$object = new $classname();
	$object->insert($_POST);
}
elseif (isset($_GET["copy_id"]) && is_numeric($_GET["copy_id"]) && ($object=$classname()->get($_GET["copy_id"])))
{
	$o = $object->duplicate();
	$_GET = array("id"=>$o->id);
}

