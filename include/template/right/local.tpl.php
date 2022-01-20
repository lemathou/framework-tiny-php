<div class="ssmenu">
<?php $page = page()->get('partenaire_cat'); ?>
<h3>Près de chez nous :</h3>
<ul>
	<li>&#10142; <a href="<?php echo $page->url(3); ?>"><?php echo cat()->get(3)->titre; ?></a></li>
	<li>&#10142; <a href="<?php echo $page->url(4); ?>"><?php echo cat()->get(4)->titre; ?></a></li>
	<li>&#10142; <a href="<?php echo $page->url(6); ?>"><?php echo cat()->get(6)->titre; ?></a></li>
	<li>&#10142; <a href="<?php echo $page->url(5); ?>"><?php echo cat()->get(5)->titre; ?></a></li>
</ul>
</div>

