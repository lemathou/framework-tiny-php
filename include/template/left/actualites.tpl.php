<div class="left_list left_actu" style="display:none;">
<h3><?php echo page()->get(8)->link(); ?></h3>
<?php
// Dernière actualité mise en valeur et active
$actualites = actualite()->select('active=1', 10, 'datetime desc');
$page = page()->get(9);
?>
<ul>
<?php foreach ($actualites as $actualite){ ?>
	<li><?php echo $page->link($actualite->id); ?> <span class="light">(<?php echo date_mysql($actualite->datetime); ?>)</span></li>
<?php } ?>
</ul>
</div>
