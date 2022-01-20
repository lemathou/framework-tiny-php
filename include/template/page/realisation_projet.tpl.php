<?php
$realisation = realisation()->get($realisation_id);
$activite = $realisation->activite();
$realisations_url = page()->get_ref('realisations')->url($activite->id);
?>
<div class="img">
<?php if (file_exists("images/Realisations/".$realisation->ref.".jpg")) { ?>
<img src="/images/Realisations/<?php echo $realisation->ref; ?>.jpg" style="max-width:333px;" />
<?php } ?>
<?php if (file_exists("images/Realisations/".$realisation->ref."-2.jpg")) { ?>
<p style="height: 20px;margin: 0;">&nbsp;</p>
<img src="/images/Realisations/<?php echo $realisation->ref; ?>-2.jpg" style="max-width:333px;" />
<?php } ?>
<?php if (file_exists("images/Realisations/".$realisation->ref."-3.jpg")) { ?>
<p style="height: 20px;margin: 0;">&nbsp;</p>
<img src="/images/Realisations/<?php echo $realisation->ref; ?>-3.jpg" style="max-width:333px;" />
<?php } ?>
</div>

<h1 style="background-image:url('/images/ssmenu/bandeau-titre-<?php echo $activite->bandeau; ?>.gif');"><a href="<?php echo $realisations_url; ?>"><?php echo $activite; ?></a></h1>

<div class="texte">
<h1><?php echo $realisation->titre; ?></h1>
<?php echo $realisation->texte; ?>
</div>

<p style="clear: both;width: 560px;text-align: right;font-style: italic;margin-top: 20px;margin-bottom: 0;"><a href="<?php echo $realisations_url; ?>">Autres réalisations en <?php echo $activite->titre; ?></a></p>
