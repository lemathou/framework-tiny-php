<?php $cat = cat()->get($cat_id); ?>
<h1><?php echo $cat->titre; ?></h1>

<div class="partenaire_list">
<?php foreach (partenaire()->select('cat_id='.$cat_id.' AND active=1') as $partenaire){ ?>
<div class="partenaire">
<div style="margin-right: 10px;">
<h3><?php echo $partenaire; ?></h3>
<p class="link light"><?php echo $partenaire->link($partenaire->website, '_blank'); ?></p>
</div>
<div><?php echo $partenaire->description; ?></div>
<p style="clear:;"></p>
</div>
<?php } ?>
</div>

