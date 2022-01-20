<h1><?php //echo $titre; ?></h1>
<?php

$page = page()->get('plante');

foreach(plante()->select() as $plante) {
	echo '<p>'.$page->link($plante->id).'</p>';
}

?>
<div style="height: 150px;padding-bottom: 1px;"></div>
