<div class="footer_actu">
<?php
// Dernier événement mise en valeur et active
$list = evenement()->select('`active`=1 AND `date_affiche` <= NOW()', 1, 'date_affiche DESC');
$evenement = array_pop($list);
$page = page()->get('evenement');
?>
<div class="img"><a href="<?php echo $page->url($evenement->id); ?>"><img src="/<?php echo $evenement->file('img'); ?>" /></a></div>
<h3><?php echo $page->link($evenement->id); ?></h3>
<p class="date"><?php echo 'du '.date_mysql($evenement->date_debut).' au '.date_mysql($evenement->date_fin); ?></p>
<div class="text richtext">
<?php echo $evenement->texte; ?>
</div>
</div>
