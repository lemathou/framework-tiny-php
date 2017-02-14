<?php if ($object->id) { ?>
<form class="db_object" method="post" enctype="multipart/form-data">
<h3>Paramètres supplémentaires</h3>
<?php
$page = $object;
$controller = $page->controller();
//var_dump($controller);
$fields = $controller->fields;
$params = $page->params;
//var_dump($params);
?>
<table>
<input name="id" type="hidden" value="<?php echo $page->id; ?>" />
<?php foreach ($fields as $name=>$field) { ?>
<tr>
	<th class="label"><?php echo $field["description"]; ?> :<br /><span style="font-size:10px;font-weight: normal; text-transform: italic;"><?php echo $field["commentaire"]; ?></span></th>
	<td class="field"><?php echo field_form("params[$name]", $field, isset($params[$name]) ?$params[$name] :null); ?></td>
</tr>
<?php } ?>
</table>
<tr>
	<th>&nbsp;</th>
	<td><input type="submit" name="_update" value="Mettre à jour" /></td>
</tr>
</form>
<?php } ?>
