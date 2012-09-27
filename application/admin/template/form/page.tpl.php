<script type="text/javascript">
</script>

<style type="text/css">
form th{
	text-align: left;
}
form.form_page input{
	width: 100%;
}
form.form_page textarea{
	width: 100%;
	height: 10em;
}
form.form_content_page textarea{
	width: 100%;
	height: 20em;
}
</style>

<h2>Page <?php echo $form_data["titre"]; ?></h2>

<form class="form_page" method="post">
<input type="hidden" name="page_id" value="<?php echo $form_data["id"]; ?>" />
<table align="center">
<tr>
	<td width="250"></td>
	<td width="400"></td>
</tr>
<?php
foreach($field_list as $name=>$field) if (in_array($name, array("parent_id", "sspage_default", "pos", "visible", "titre", "header_title", "header_description")))
{
?>
<tr>
	<th><label><?php echo $field["label"]; ?> :</label></th>
<?php if ($field["type"] == "select") { ?>
	<td><select name="<?php echo $name; ?>"><option value="">--</option><?php
		foreach($field["list"] as $i=>$j)
			echo "<option value='".$i."'".((is_numeric($form_data[$name]) && $form_data[$name]==$i)?" selected":"").">".$j."</option>";
	?></select></td>
<?php } elseif ($field["type"] == "bool") { ?>
	<td>
		<input type="radio" name="<?php echo $name; ?>" value="0"<?php if (!$form_data[$name]) echo " checked=\"checked\""; ?> style="width:30px;" /> NON
		<input type="radio" name="<?php echo $name; ?>" value="1"<?php if ($form_data[$name]) echo " checked=\"checked\""; ?> style="width:30px;" /> OUI
	</td>
<?php } elseif ($field["type"] == "textarea") { ?>
	<td><textarea name="<?php echo $name; ?>"><?php echo $form_data[$name]; ?></textarea></td>
<?php } elseif ($field["type"] == "page") { ?>
	<td><select name="<?php echo $name; ?>"><option value="">-- Choisir si besoin --</option><?php
	if ($form_data["id"])
		$q = "SELECT id, titre FROM page WHERE ".str_replace("{page_id}", $form_data["id"], $field["q"])." ORDER BY parent_id, `pos`";
	else
		$q = "SELECT id, titre FROM page WHERE 1 ORDER BY parent_id, `pos`";
	$query = mysql_query($q);
	while($row=mysql_fetch_assoc($query))
	{
		echo "<option value='".$row["id"]."'".((is_numeric($form_data[$name]) && $form_data[$name]==$row["id"])?" selected":"").">".$row["titre"]."</option>";
	}
	?></select></td>
<?php } else { ?>
	<td><input name="<?php echo $name; ?>" value="<?php echo $form_data[$name]; ?>"<?php if (isset($field["readonly"])) echo " readonly"; ?> /></td>
<?php } ?>
</tr>
<?php
}
?>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="_page_update" value="Mettre à jour" style="width: auto;" /></td>
</tr>
</table>
</form>

<?php if (count($form_content_data)) { ?>
<hr />
<h3>Contenu de la page</h3>
<form method="get">
<input type="hidden" name="menu" value="page" />
<input type="hidden" name="page_id" value="<?php echo $form_data["id"]; ?>" />
<p align="center"><select name="content" onchange="this.form.submit()"><option value="">-- Choisir le contenu à editer --</option><?php foreach($form_content_data as $name=>$field) { ?>
<option value="<?php echo $name; ?>"<?php if (isset($_GET["content"]) && $_GET["content"]==$name) echo " selected"; ?>><?php echo $field["description"]; ?></option>
<?php } ?></select></p>
</form>
<?php } ?>

<?php if (count($form_content_data) && isset($_GET["content"])) { ?>
<form class="form_content_page" method="post" enctype="multipart/form-data">
<input type="hidden" name="page_id" value="<?php echo $form_data["id"]; ?>" />
<table align="center">
<tr>
	<td width="250"></td>
	<td width="700"></td>
</tr>
<?php
foreach($form_content_data as $name=>$field) if ($_GET["content"] == $name)
{
	$options = json_decode($field["options"], true);
	//var_dump($options);
	if ($field["type"]=="richtext") {
?>
<tr>
	<th><label><?php echo $field["description"]; ?> :</label></th>
	<td><textarea class="ckeditor" name="content[<?php echo $name; ?>]"><?php echo $field["texte"]; ?></textarea></td>
</tr>
<?php
	} elseif ($field["type"]=="textarea") {
?>
<tr>
	<th><label><?php echo $field["description"]; ?> :</label></th>
	<td><textarea name="content[<?php echo $name; ?>]"><?php echo $field["texte"]; ?></textarea></td>
</tr>
<?php
	} elseif ($field["type"]=="img") {
?>
<tr>
	<th><label><?php echo $field["description"]; ?> :</label></th>
	<td><input type="file" name="<?php echo $name; ?>" />
	<?php if (file_exists($filename="../".str_replace("{ref}", $form_data["ref"], $options["filename"]))) { ?><br /><img src="/<?php echo $filename; ?>" /></td><?php } ?>
</tr>
<?php
	} elseif ($field["type"]=="object") {
?>
	<th><label><?php echo $field["description"]; ?> :</label></th>
	<td><select name="<?php echo $name; ?>"><option value="">--</option><?php
	$object_type = (is_array($options) && isset($options["object_type"])) ?$options["object_type"] :"";
	if (function_exists($object_type)) foreach ($object_type()->select() as $o)
		echo "<option value=\"".$o->id."\"".($field["texte"]==$o->id?" selected":"").">".$o."</option>";
	?></select>
<?php
	} else {

?>
<tr>
	<th><label><?php echo $field["description"]; ?> :</label></th>
	<td><input name="content[<?php echo $name; ?>]" value="<?php echo $field["texte"]; ?>" /></td>
</tr>
<?php }
}
?>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="_page_content_update" value="Mettre à jour" style="width: auto;" /></td>
</tr>
</table>
</form>
<?php } ?>
