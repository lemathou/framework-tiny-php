<div class="left_list left_actu">
<h3><?php echo page()->get(10)->link(); ?></h3>
<?php
// Dernière activite mise en valeur et active
$list = activite()->select('active=1', 10);
$page = page()->get(11);
?>
<ul>
<?php foreach ($list as $object){ ?>
	<li><?php echo $page->link($object->id); ?></li>
<?php } ?>
</ul>
</div>
