<?php

/**
 * Gestion base de donnée
 * @author mathieu
 * @package db_manager
 */
class db_manager
{

function __construct()
{

if (!mysql_connect(DB_HOST, DB_USER, DB_PASS))
	die("Erreur Connection MySQL");
elseif (!mysql_select_db(DB_BASE))
	die("Erreur Base de donnée");
mysql_query("SET NAMES UTF8");
	
}

function select($sql)
{

return new db_select($sql);

}

function delete($sql)
{

return new db_update($sql);

}

function update($sql)
{

return new db_update($sql);

}

function insert($sql)
{

return new db_insert($sql);

}

}

/**
 * Requête de base de donnée
 * @author mathieu
 * @package db_manager
 */
abstract class db_query
{

public $sql;
protected $req;

function __construct($sql)
{

$this->sql = $sql;
$this->req = mysql_query($sql);
if (DB_DEBUG && ($error=mysql_error()))
	echo "<p>$this->sql : $error</p>";

}

}

/**
 * Requête SELECT
 * @author mathieu
 * @package db_manager
 */
class db_select extends db_query
{

function num_rows()
{

return mysql_num_rows($this->req);

}

function fetch_row()
{

if (DB_DEBUG)
{
	$return = mysql_fetch_row($this->req);
	if ($error=mysql_error())
		echo "<p>$this->sql : $error</p>";
	return $return;
}
else
{
	return mysql_fetch_row($this->req);
}

}

function fetch_assoc()
{

if (DB_DEBUG)
{
	$return = mysql_fetch_assoc($this->req);
	if ($error=mysql_error())
		echo "<p>$this->sql : $error</p>";
	return $return;
}
else
{
	return mysql_fetch_assoc($this->req);
}

}

function fetch_all()
{

$list = array();
while($row = $this->fetch_assoc())
	$list[] = $row;
return $list;

}

}

/**
 * Requête INSERT
 * @author mathieu
 * @package db_manager
 */
class db_insert extends db_query
{

function insert_id()
{

return mysql_insert_id();

}

}

/**
 * Requêtes UPDATE, REPLACE, DELETE
 * @author mathieu
 * @package db_manager
 */
class db_update extends db_query
{

function affected_rows()
{

return mysql_affected_rows();

}

}

?>