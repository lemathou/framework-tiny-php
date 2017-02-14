<?php
$cat = cat()->get($cat_id);
?>
<h1><?php echo $cat->titre; ?></h1>

<?php if (count($l=actualite()->select('cat_id='.$cat->id.' AND active=1', 5))) { ?>
<?php $page = page()->get('actualite'); ?>
<h3>Actualités :</h3>
<ul>
<?php foreach($l as $actualite) { ?>
	<li><?php echo $page->link($actualite->id); ?></li>
<?php } ?>
</ul>
<?php if (($nb=actualite()->count('cat_id='.$cat->id.' AND active=1')) > 5) { ?>
<p><a href="<?php //echo page()->get('actualite_cat')->url($cat->id); ?>">Voir l'ensemble des actualités (<?php echo $nb ?> au total)</a></p>
<?php } ?>
<?php } ?>

<?php if (count($l=evenement()->select('cat_id='.$cat->id.' AND active=1', 5))) { ?>
<?php $page = page()->get('evenement'); ?>
<h3>Evénements :</h3>
<ul>
<?php foreach($l as $o) { ?>
	<li><?php echo $page->link($o->id); ?></li>
<?php } ?>
</ul>
<?php if (($nb=evenement()->count('cat_id='.$cat->id.' AND active=1')) > 5) { ?>
<p><a href="<?php //echo page()->get('evenement_cat')->url($cat->id); ?>">Voir l'ensemble des événements (<?php echo $nb ?> au total)</a></p>
<?php } ?>
<?php } ?>

<?php if (count($l=activite()->select('cat_id='.$cat->id.' AND active=1', 5))) { ?>
<?php $page = page()->get('activite'); ?>
<h3>Activités :</h3>
<ul>
<?php foreach($l as $activite) { ?>
	<li><?php echo $page->link($activite->id); ?></li>
<?php } ?>
</ul>
<?php if (($nb=activite()->count('cat_id='.$cat->id.' AND active=1')) > 5) { ?>
<p><a href="<?php //echo page()->get('activite_cat')->url($cat->id); ?>">Voir l'ensemble des activités (<?php echo $nb ?> au total)</a></p>
<?php } ?>
<?php } ?>

<?php if (count($l=partenaire()->select('cat_id='.$cat->id.' AND active=1'))) { ?>
<h3>Partenaires</h3>
<ul>
<?php foreach($l as $partenaire) { ?>
	<li><?php echo $partenaire->link(); ?></li>
<?php } ?>
</ul>
<?php if (($nb=partenaire()->count('cat_id='.$cat->id.' AND active=1')) > 5) { ?>
<p><a href="<?php echo page()->get('partenaire_cat')->url($cat->id); ?>">Voir l'ensemble des partenaires (<?php echo $nb ?> au total)</a></p>
<?php } ?>
<?php } ?>

