<h1>Plan du site</h1>

<div class="row">
	<div class="col-12 col-sm-6 col-md-4 col-xl-3">
	<h3>Jardin des trains</h3>
	<?php

	$list = [
		1, 4, 5, 27, 26,
		14, 15, 16,
	];

	foreach($list as $i) {
		echo '<p>'.page()->get($i)->link().'</p>';
	}

	?>
	</div>
	
	<div class="col-12 col-sm-6 col-md-4 col-xl-3">
	<h3>Activités</h3>
	<?php

	$list = [
		8, 10, 12, 18, 17, 22, 23, 25
	];

	foreach($list as $i) {
		echo '<p>'.page()->get($i)->link().'</p>';
	}

	?>
	</div>
	
	<div class="col-12 col-sm-6 col-md-4 col-xl-3">
	<h3>Sites remarquables</h3>
	<?php

	$list = [
		2, 3, 4, 5, 6, 7, 8, 9,
	];

	foreach($list as $i) {
		echo '<p>'.page()->get(20)->link($i).'</p>';
	}

	?>
	</div>

	<div class="col-12 col-sm-6 col-md-4 col-xl-3">
	<h3>Plantes et Bonzaïs</h3>
	<?php
	
	$list = [
		1,
	];

	foreach($list as $i) {
		echo '<p>'.page()->get('plante')->link($i).'</p>';
	}

	?>
	</div>
</div>
