<?php

$field_list = array(
	"visible" => array("label"=>"Visible Menu", "type"=>"bool"),
	"parent_id" => array("label"=>"Page parente", "type"=>"page", "q"=>"id != '{page_id}' AND (parent_id IS NULL)"),
	"pos" => array("label"=>"Position", "type"=>"int"),
	"template" => array("label"=>"Template", "type"=>"text", "readonly"=>true),
	"css" => array("label"=>"CSS", "type"=>"text", "readonly"=>true),
	"js" => array("label"=>"JS", "type"=>"text", "readonly"=>true),
	"ref" => array("label"=>"REF", "type"=>"text", "readonly"=>true),
	"url" => array("label"=>"URL", "type"=>"text"),
	"sspage_default" => array("label"=>"Sous-page par défaut", "type"=>"page", "q"=>"parent_id = '{page_id}'"),
	"titre" => array("label"=>"Titre", "type"=>"text"),
	"header_title" => array("label"=>"Titre HTML", "type"=>"text"),
	"header_description" => array("label"=>"Description HTML", "type"=>"textarea"),
);

function page_list($parent_id=null, $add="")
{

$q = "SELECT page.*, parent_page.titre as parent_titre
	FROM page
	LEFT JOIN page AS parent_page ON parent_page.id = page.parent_id
	".(is_numeric($parent_id)?"WHERE page.parent_id='".$parent_id."'":"WHERE page.parent_id IS NULL")."
	ORDER BY page.parent_id, page.`pos`";
$query = mysql_query($q);
while($row=mysql_fetch_assoc($query))
{
?>
<div class="<?php if (!$add) echo "rub"; elseif ($add == "=>&nbsp;") echo "srub"; ?>">
<?php if ($add) echo "$add"; ?><a href="?page_id=<?php echo $row["id"]; ?>"><?php echo $row["titre"]; ?></a>
</div>
<?php
page_list($row["id"], "=>&nbsp;$add");
}
//echo "$q : ".mysql_error()."</p>";

}

// ACTION

if (isset($_POST["_page_update"]) && isset($_POST["page_id"]) && is_numeric($_POST["page_id"]))
{
	$q_u = array();
	foreach($field_list as $name=>$field)
	{
		if (isset($_POST[$name]))
		{
			if ($field["type"]=="page")
			{
				if (is_numeric($_POST[$name]))
					$q_u[] = "`$name`='".$_POST[$name]."'";
				else
					$q_u[] = "`$name`=NULL";
			}
			elseif ($field["type"]=="text" || $field["type"]=="textarea")
			{
				$q_u[] = "`$name`='".mysql_real_escape_string($_POST[$name])."'";
			}
			elseif ($field["type"]=="bool" || ($field["type"]=="int"))
			{
				$q_u[] = "`$name`='".(int)($_POST[$name])."'";
			}
		}
	}
	if (count($q_u))
	{
		$q = "UPDATE page SET ".implode(", ", $q_u)." WHERE id='".$_POST["page_id"]."'";
		mysql_query($q);
	}
}

if (isset($_POST["_page_content_update"]) && isset($_POST["page_id"]) && is_numeric($_POST["page_id"]))
{
	$q = "SELECT page.ref, page_content.*
		FROM page
		JOIN page_content ON page.id=page_content.page_id
		WHERE page_id='".$_POST["page_id"]."'";
	$r = mysql_query($q);
	while ($row=mysql_fetch_assoc($r))
	{
		$name = $row["name"];
		if ($row["type"]=="img")
		{
			$options = json_decode($row["options"], true);
			if (isset($_FILES[$name]) && $_FILES[$name]["tmp_name"])
			{
				//var_dump($options)
				$filename = str_replace(array("{ref}"), array($row["ref"]), $options["filename"]);
				move_uploaded_file($_FILES[$name]["tmp_name"], "../".$filename);
			}
		}
		else // texte
		{
			if (isset($_POST["content"][$name]) && is_string($_POST["content"][$name]))
			{
				$q = "UPDATE page_content SET `texte`='".mysql_real_escape_string($_POST["content"][$name])."' WHERE page_id='".$_POST["page_id"]."' AND `name`='".mysql_real_escape_string($name)."'";
				mysql_query($q);
			}
		}
	}
}

