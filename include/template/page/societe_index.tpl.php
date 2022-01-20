<?php if (file_exists($filename="images/Societe/image-".$sspage["ref"].".jpg")) { ?>
<div class="img">
<img src="/<?php echo $filename; ?>" style="max-width: 333px;" />
</div>
<?php } ?>

<h1 class="titre" style="background-image:url('/images/ssmenu/bandeau-titre-<?php echo $sspage_nb; ?>.gif');"><?php echo $sspage["titre"]; ?></h1>

<div class="texte">
<?php echo $sspage["texte"]; ?>
</div>
