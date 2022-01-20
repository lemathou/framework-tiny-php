<?php
// Dernière actualité mise en valeur et active
$actualites = actualite()->select('active=1', 1, 'datetime DESC');
$actualite = array_pop($actualites);
$page = page()->get('actualite');
//var_dump($actualite);
?>
<div class="footer_actu row">
	<div class="col-12 col-sm-4 offset-lg-1 col-lg-3 offset-xl-2 col-xl-2">
		<div class="img">
			<a href="<?php echo $page->url($actualite->id); ?>"><img src="/<?php echo $actualite->img('img', 200); ?>" /></a>
		</div>
	</div>
	<div class="col-12 col-sm-8 col-lg-6 col-xl-5">
		<div style="padding-left: 10px;">
			<h3><?php echo $page->link($actualite->id); ?></h3>
			<p class="date"><?php echo 'le '.date_mysql($actualite->datetime); ?></p>
			<div class="text richtext">
			<?php echo $actualite->texte; ?>
			</div>
		</div>
	</div>
</div>
