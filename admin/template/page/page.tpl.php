<?php

// TEMPLATE

if (isset($_GET["add"]))
{
	
$form_data = array("id"=>null);
foreach($field_list as $i=>$j)
	$form_data[$i] = "";

$form_content_data = array();
	
include "template/form/page.tpl.php";

}

elseif (isset($_GET["page_id"]) && is_numeric($_GET["page_id"]))
{

$q = "SELECT * FROM page WHERE id='".$_GET["page_id"]."'";
$query = mysql_query($q);
$form_data = mysql_fetch_assoc($query);
//var_dump($form_data);

$q = "SELECT name, type, description, options, commentaire, texte FROM page_content WHERE page_id='".$_GET["page_id"]."'";
$query = mysql_query($q);
$form_content_data = array();
while($row = mysql_fetch_assoc($query))
	$form_content_data[$row["name"]] = $row;

//var_dump($form_content_data);

include "template/form/page.tpl.php";

}

else
{

?>
<div class="liste">
<?php page_list(); ?>
</div>
<?php

}

?>
