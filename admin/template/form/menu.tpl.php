<?php if ($object->id) { ?>
<form class="db_object" method="post">
<h3>Paramètre supplémentaire</h3>
<?php
$menu = $object;
$page = $menu->page();
$controller = $page->controller();
//var_dump($controller);
$fields = $controller->fields;
$params = $menu->params;
//var_dump($params);
?>
<input name="id" type="hidden" value="<?php echo $menu->id; ?>" />
<table>
<?php foreach ($fields as $name=>$field) if ($field['url_get']) { ?>
<tr>
	<th class="label"><?php echo $field["description"]; ?> :</th>
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
