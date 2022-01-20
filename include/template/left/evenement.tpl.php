<div class="left_list left_evenement">
<h3><?php echo page()->get(12)->link(); ?></h3>
<?php
// Dernière activite mise en valeur et active
$list = evenement()->select('active=1', null, 'date_fin DESC');
$page = page()->get(13);
?>
<ul>
<?php foreach ($list as $object){ ?>
	<li><?php echo $page->link($object->id); ?></li>
<?php } ?>
</ul>
</div>
