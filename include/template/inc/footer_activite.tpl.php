<div class="footer_actu">
<?php
// Dernière activité mise en valeur et active
$list = activite()->select('active=1', 1, 'datetime DESC');
$activite = array_pop($list);
$page = page()->get(9);
?>
<div class="img"><a href="<?php echo $page->url($activite->id); ?>"><img src="/<?php echo $activite->file('img'); ?>" /></a></div>
<h3><?php echo $page->link($activite->id); ?></h3>
<div class="text richtext">
<?php echo $activite->texte; ?>
</div>
</div>
