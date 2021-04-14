<h3>Liste</h3>
<table class="list">
<thead>
<tr>
	<td colspan="2">&nbsp;</td>
<?php foreach ($classname()->_field_disp_list as $name) { ?>
	<th><?php echo $classname()->_fields[$name]["label"]; ?></th>
<?php } ?>
</tr>
</thead>
<tbody>
<?php foreach($classname()->select() as $object) { ?>
<tr>
<td><a href="?delete_id=<?php echo $object->id; ?>" onclick="return confirm('Êtes-vous certain de vouloir supprimer cet enregistrement ?')"><img src="images/delete.gif" alt="Supprimer" title="Supprimer" /></a></td>
<td><a href="?id=<?php echo $object->id; ?>"><img src="images/edit.png" alt="Mettre à jour" title="Modifier" /></a></td>
<?php foreach ($classname()->_field_disp_list as $name) { ?>
	<td><?php
		$field = $classname()->_fields[$name];
		$type = $field["type"];
		if (in_array($type, array('bool', 'boolean'))) {
			echo $object->$name ?'OUI' :'NON';
		}
		elseif ($type=="object" && is_numeric($object->$name)) {
			$object_type = $field["object_type"];
			echo $object_type()->get($object->$name);
		}
		elseif (is_string($object->$name))
			echo $object->$name;
		elseif (is_array($object->$name))
			echo implode(", ", $object->$name);
		else
			echo "&nbsp;";
	 ?></td>
<?php } ?>
</tr>
<?php } ?>
</tbody>
</table>

