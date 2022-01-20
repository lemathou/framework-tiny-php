<div class="left_list left_actu">
<h3>Plantes<?php //echo page()->get(8)->link(); ?></h3>
<?php
// Dernière actualité mise en valeur et active
$list = plante()->select('active=1', 10);
$page = page()->get('plante');
?>
<ul>
<?php foreach ($list as $elem){ ?>
	<li><?php echo $page->link($elem->id); ?></li>
<?php } ?>
</ul>
</div>
