<div class="partenaire">
<?php $partenaire = partenaire()->get($partenaire_id); ?>
<h1><?php echo $partenaire->nom; ?></h1>


<div class="text richtext">
<?php echo $partenaire->description; ?>
</div>

<div class="img">
<img src="/<?php echo $partenaire->file('img'); ?>" style="max-width:660px;" />
</div>

<div class="g-plusone" data-annotation="inline" data-width="300"></div>
<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
